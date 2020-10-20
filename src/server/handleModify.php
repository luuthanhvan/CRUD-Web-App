<?php
    // lấy dữ liệu từ form
    $mabenh = $_POST['mb'];
    // echo $mabenh."<br>";
    $benh = $_POST['tb'];
    // echo $benh."<br>";
    $mota = $_POST['mt'];
    // echo $mota."<br>";
    $trieuchung = $_POST['tc'];
    
    // thực hiện kết nối đến CSDL
    require 'connect.php';

    // viết câu truy vấn để update dữ liệu vào bảng benh
    $sql = "UPDATE benh SET tenloaibenh='$benh', mota='$mota' WHERE maloaibenh='$mabenh'";

    // thực thi câu truy vấn
    $connection->query($sql);

    // xóa toàn bộ triệu chứng trong bảng chitietbenh
    $sql = "DELETE FROM chitietbenh WHERE maloaibenh='$mabenh'";
    $connection->query($sql);

    // lấy các mã triệu chứng từ thẻ select để update dữ liệu vào bảng chitietbenh
    foreach($trieuchung as $value){
        // echo $value."<br/>";
        $sql = "INSERT INTO chitietbenh (maloaibenh, matrieuchung) VALUES ('$mabenh', '$value')";
        $connection->query($sql);
    }

    // đóng kết nối CSDL
    $connection->close();

    // điều hướng trở về trang admin
    header("location: admin.php");
?>