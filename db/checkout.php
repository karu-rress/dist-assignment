<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
</head>
<body>
<?php
    include '../db/connect.php';

    $isbn = $_GET['isbn'];

    $stmt = $connect->prepare("UPDATE bookinfo SET takenby = ? WHERE isbn = ?");
    $stmt->bind_param('si', $_COOKIE['userlevel'], $isbn);
    $stmt->execute();

    $rows = $stmt->affected_rows;
    if ($rows === 0) {
        $stmt->close();
        echo '<script>alert("오류가 발생했습니다. ISBN을 확인하세요.");
            location.href = "/books/about.php?isbn=' . $isbn .'";</script>';
    }
    else {
        addlog($connect, $isbn, $_COOKIE['userlevel'], 'check out');
        $stmt->close();
        echo '<script>alert("성공적으로 대출되었습니다.");
            location.href = "/books/about.php?isbn=' . $isbn .'";</script>';
    }
?>
</body>
</html>