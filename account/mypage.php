<?php
    include '../db/connect.php';

    $stmt = $connect->prepare("SELECT * FROM bookinfo WHERE takenby = ?");
    $stmt->bind_param('s', $_COOKIE['userlevel']);
    $stmt->execute();    
    $result = $stmt->get_result();
    $stmt->close();

    $is_admin = ($_COOKIE['userlevel'] ?? "") == 'admin';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>마이페이지 | Rolling Ress Library</title>
    <link rel="stylesheet" href="/styles/pages/listall.css">
    <link rel="stylesheet" href="/styles/form.css">
    <link rel="stylesheet" href="/styles/attribute.css">
    <link rel="stylesheet" href="/styles/part/header.css">
    <link rel="stylesheet" href="/styles/part/nav.css">
    <link rel="stylesheet" href="/styles/part/footer.css">
    <script defer type="module" src="/scripts/js/base.js"></script>
</head>
<body>
    <div id="wrap">
        <header include-html="/htmls/header.html"></header>
        <nav include-html="/htmls/nav.html"></nav>
        <article>
            <h1 id="article_title">마이페이지</h1>
            <form id="myBooks">
                <table cellspacing="0" cellpadding="5">
                <tr>
                    <td>선택</td>
                    <td>제목</td>
                    <td>저자</td>
                    <td>출판사</td>
                </tr>
                <?php while ($row = $result->fetch_array()): ?>
                    <tr>
                    <td>
                        <input type="checkbox" name="books" />
                    </td>
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
                    </tr>
            <?php endwhile ?>
            </table>
                <!--select name="mybooks" id="mybooks">
                    <?php# for ($i = 0; $row = $result->fetch_array();): ?>
                        <?php# if ($row['takenby'] == $_COOKIE['userlevel']): ?>
                            <option value="book<?#echo $i++?>"><? #echo $row['title'] ?></option>
                        <?php# endif; ?>
                    <?php# endfor; ?>
                </select>-->
            </form>
        </article>
    </div>
    <footer include-html="/htmls/footer.html"></footer>
</body>
</html>