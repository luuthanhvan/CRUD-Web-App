<?php
    // lấy dữ liệu từ form
    $content = $_GET['content'];
    
    // thực hiện kết nối đến CSDL
    require 'connect.php'; // kiểu giống như sử dụng thư viện import, cần chạy hết code file connect.php

    // viết câu truy vấn để lấy dữ liệu từ bảng triệu chứng
    $sql = "SELECT * FROM trieuchung WHERE tentrieuchung LIKE '$content%'";
    
    // thực thi câu truy vấn
    $result = $connection->query($sql); // query là phương thức của connection, trả về bảng csdl, result sẽ hứng dữ liệu này
    
    // nếu có dữ liệu
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){ // duyệt hết tất cả các mảng lấy được.
            echo $row['tentrieuchung']."</br>"; // trả hết dữ liệu lấy được về cho client.
        }
    } // ngược lại trả về chuỗi rỗng
    else{
        echo "";
    }
    
    // đóng kết nối CSDL
    $connection->close(); // mở thì phải đóng
?>