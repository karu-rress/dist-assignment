<?php
    include '../db/connect.php';

    # 띄어쓰기 단위로 분해한 후 AND, OR 조건을 통해 검색
    $search_query = $_GET['search'];

    # SQL Injection 코드를 분명 클라이언트단에서 걸렀는데, 그래도 쿼리에 포함되어 있다면
    # 사용자가 의도적으로 자바스크립트를 조작한 경우.
    if (preg_match('(\*|;|--)', $search_query) === 1) {
        http_response_code(406);
        die('406 Not allowed');
    }

    $option = $_GET['option'];
    $search_query_refined = preg_replace('/\s+/', ' ', $search_query);
    $search_words = explode(' ', $search_query_refined);

    # bind_param을 여러 번 사용할 수 없어 여기서는 SQL Injection을
    # 클라이언트와 서버단에서 각각 처리
    $query = "SELECT * FROM bookinfo ";
    $first = true;
    foreach ($search_words as &$word) {
        $query .= ($first ? "WHERE" : $option) . " title LIKE '%$word%' ";
        $first = false;
    }

    $stmt = $connect->prepare($query);
    $stmt->execute();    
    $result = $stmt->get_result();
    $stmt->close();
    $is_admin = ($_COOKIE['userlevel'] ?? "") === 'admin';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>검색 결과 | Rolling Ress Library</title>
    <link rel="stylesheet" href="/styles/pages/listall.css">
    <link rel="stylesheet" href="/styles/form.css">
    <link rel="stylesheet" href="/styles/attribute.css">
    <link rel="stylesheet" href="/styles/part/header.css">
    <link rel="stylesheet" href="/styles/part/nav.css">
    <link rel="stylesheet" href="/styles/part/footer.css">
    <link rel="icon" href="/resources/Rolling Ress.png">
    <script defer type="module" src="/scripts/js/base.js"></script>
</head>
<body>
    <div id="wrap">
        <header include-html="/htmls/header.html"></header>
        <nav include-html="/htmls/nav.html"></nav>
        <article>
            <h1 id="article_title">'<? echo $search_query?>' 검색 결과</h1>
            <table cellspacing="0" cellpadding="5">
            <tr>
                    <th>제목</th>
                    <th>저자</th>
                    <th>출판사</th>
                    <th>상태</th>
                </tr>
                <?php while ($row = $result->fetch_array()): ?>
                    <tr>
                    <td>
                        <?php if ($is_admin): ?>
                            <a href='/manage/about.php?isbn=<? echo $row['isbn'] ?>'>
                        <?php else: ?>
                            <a href='/books/about.php?isbn=<? echo $row['isbn'] ?>'>
                        <?php endif; ?>
                        <span class='book_title'><? echo $row['title'] ?></span>
                        </a>
                    </td>
                    <td><? echo $row['author'] ?></td>
                    <td><? echo $row['publisher'] ?></td>
                    <?php if (empty($row['takenby'])): ?>
                        <?php if (isset($_COOKIE['userlevel'])): ?>
                            <td class="available">이용 가능</td>
                        <? else: ?>
                            <td>로그인 필요</td>
                        <? endif; ?>
                    <? else: ?>
                        <td>대출중</td>
                    <? endif ?>
                    </tr>
            <?php endwhile ?>
            </table>
        </article>
    </div>
    <footer include-html="/htmls/footer.html"></footer>
</body>
</html>