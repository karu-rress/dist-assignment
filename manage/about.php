<?php
    include '../db/connect.php';
    $isbn = $_GET['isbn'];
    
    $stmt = $connect->prepare("SELECT * FROM bookinfo WHERE isbn = ?");
    $stmt->bind_param('d', $isbn);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array();
    $stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Book Info | Rolling Ress Library</title>
    <link rel="stylesheet" href="/styles/form.css">
    <link rel="stylesheet" href="/styles/attribute.css">
    <link rel="stylesheet" href="/styles/part/header.css">
    <link rel="stylesheet" href="/styles/part/nav.css">
    <link rel="stylesheet" href="/styles/part/footer.css">
    <script defer type="module" src="/scripts/js/base.js"></script>
</head>
<body>
    <header include-html="/htmls/header.html"></header>
    <nav include-html="/htmls/nav.html"></nav>
    <article>
    <h1>Book Info</h1>
    <form name="frm_content" method="post" action="../db/update.php?isbn=<? echo $isbn ?>">
        <input type="text" name="isbn" class="box" placeholder="ISBN" value="<? echo $row['isbn'] ?>">
        <input type="text" name="title" class="box" placeholder="제목" value="<? echo $row['title'] ?>">
        <input type="text" name="author" class="box" placeholder="저자" value="<? echo $row['author'] ?>">
        <input type="text" name="publisher" class="box" placeholder="출판사" value="<? echo $row['publisher'] ?>">
        <input type="text" name="takenby" class="box" placeholder="대출자 (미 입력시 대출 가능 상태)" value="<? echo $row['takenby'] ?>">
        <div><input type="submit" class="actionbutton" value="수정"><input type="button" class="actionbutton" value="삭제"></div>
    </form>
    </article>
    <footer include-html="/htmls/footer.html"></footer>
</body>
</html>