<?php
    // lấy dữ liệu từ form
    $mabenh = $_GET['mabenh'];
    $benh = $_GET['tenbenh'];
    $mota = $_GET['mota'];
    
    // thực hiện kết nối đến CSDL
    require 'connect.php';

    // viết câu truy vấn để update dữ liệu vào bảng benh
    $sql = "UPDATE benh SET tenloaibenh='$benh', mota='$mota' WHERE maloaibenh='$mabenh'";

    // thực thi câu truy vấn
    $connection->query($sql);
    
    // lấy các mã triệu chứng từ thẻ select để update dữ liệu vào bảng chitietbenh
    foreach($_GET['trieuchung'] as $value){
        // echo $value."<br/>";
        $sql = "UPDATE chitietbenh SET matrieuchung='$value' WHERE maloaibenh='$mabenh'";
        $connection->query($sql);
    }

    // đóng kết nối CSDL
    $connection->close();

    // điều hướng trở về trang admin
    header("location: admin.php");
?>