<?php
    // lấy dữ liệu từ form
    $mabenh = $_GET['mabenh'];
    $benh = $_GET['tenbenh'];
    $mota = $_GET['mota'];

    // thực hiện kết nối đến CSDL
    require 'connect.php'; // tạo đối tượng connect

    // viết câu truy vấn để insert dữ liệu vào bảng benh
    $sql = "INSERT INTO benh (maloaibenh, tenloaibenh, mota) VALUES ('$mabenh', '$benh', '$mota');";
    
    // lấy các mã triệu chứng từ mảng trieuchung[] trong thẻ input (type = checkbox) để insert dữ liệu vào bảng chitietbenh
    foreach($_GET['trieuchung'] as $value){ //vòng lặp foreach trong php
        // echo $value."<br/>";
        $sql .= "INSERT INTO chitietbenh (maloaibenh, matrieuchung) VALUES ('$mabenh', '$value');";        
    }

    // thực thi các câu truy vấn
    $connection->multi_query($sql);

    // đóng kết nối CSDL
    $connection->close();

    // điều hướng trở về trang admin  nghĩa là xử lý xong việc thêm sẽ quay về trang admin.php 
    header("location: admin.php");
?>