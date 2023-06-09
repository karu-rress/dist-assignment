<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
</head>
<body>
<?php
    include '../db/connect.php';

    $isbn = $_GET['isbn'];

    $stmt = $connect->prepare("DELETE FROM bookinfo WHERE isbn = ?");
    $stmt->bind_param('i', $isbn);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        $stmt->close();
        echo '<script>alert("존재하지 않는 ISBN이거나 삭제 과정에서 오류가 발생했습니다.");
        location.href = "/manage/about.php?isbn=' . $isbn .'";</script>';
    }
    else {
        addlog($connect, $isbn, 'admin', 'delete');
        $stmt->close();
    echo '<script>alert("성공적으로 삭제되었습니다."); 
        location.href = "/books/all.php";</script>';
    }
?>
</body>
</html>