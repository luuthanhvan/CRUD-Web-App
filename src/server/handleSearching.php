<?php
    // lấy dữ liệu từ form
    $content = $_GET['content'];
    
    // thực hiện kết nối đến CSDL
    require 'connect.php';

    // viết câu truy vấn để lấy dữ liệu từ bảng triệu chứng
    $sql = "SELECT * FROM trieuchung WHERE tentrieuchung LIKE '$content%'";
    
    // thực thi câu truy vấn
    $result = $connection->query($sql);
    
    // nếu có dữ liệu
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo $row['tentrieuchung']; // trả dữ liệu lấy được về client
        }
    } // ngược lại trả về chuỗi rỗng
    else{
        echo "";
    }
    
    // đóng kết nối CSDL
    $connection->close();
?>