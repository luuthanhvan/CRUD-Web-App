<?php
    // lấy mã bệnh từ bên trang admin.php truyền qua
    $maBenh = $_GET['maBenh'];

    // thực hiện kết nối đến CSDL
    require 'connect.php';

    // viết câu truy vấn xử lý xóa bảng chitietbenh
    $sql = "DELETE FROM chitietbenh WHERE maloaibenh='$maBenh'";

    // thực thi câu truy vấn
    $connection->query($sql);

    // viết câu truy vấn xử lý xóa bảng benh
    $sql = "DELETE FROM benh WHERE maloaibenh='$maBenh'";

    // thực thi câu truy vấn
    $connection->query($sql);

    // đóng kết nối CSDL
    $connection->close();

    // điều hướng trở về trang admin
    header("location: admin.php");
?>