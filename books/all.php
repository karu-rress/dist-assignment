<?php
    include '../db/connect.php';

    $stmt = $connect->prepare("SELECT * FROM bookinfo");
    $stmt->execute();    
    $result = $stmt->get_result();
    $stmt->close();

    $is_admin = ($_COOKIE['userlevel'] ?? "") === 'admin';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>전체 도서 | Rolling Ress Library</title>
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
            <h1>전체 도서 목록</h1>
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
            <? endwhile ?>
            </table>
            <br><br><br>
    </div>
        </article>
    <footer include-html="/htmls/footer.html"></footer>
</body>
</html>