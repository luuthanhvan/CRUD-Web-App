<?php
    // lấy dữ liệu từ form
    $mabenh = $_GET['mabenh'];
    $benh = $_GET['tenbenh'];
    $mota = $_GET['mota'];

    // thực hiện kết nối đến CSDL
    require 'connect.php';

    // viết câu truy vấn để insert dữ liệu vào bảng benh
    $sql = "INSERT INTO benh (maloaibenh, tenloaibenh, mota) VALUES ('$mabenh', '$benh', '$mota')";

    // thực thi câu truy vấn
    $connection->query($sql);
    
    // lấy các mã triệu chứng từ mảng trieuchung[] trong thẻ input (type = checkbox) để insert dữ liệu vào bảng chitietbenh
    foreach($_GET['trieuchung'] as $value){
        // echo $value."<br/>";
        $sql = "INSERT INTO chitietbenh (maloaibenh, matrieuchung) VALUES ('$mabenh', '$value')";
        $connection->query($sql);
    }

    // đóng kết nối CSDL
    $connection->close();

    // điều hướng trở về trang admin
    header("location: admin.php");
?>