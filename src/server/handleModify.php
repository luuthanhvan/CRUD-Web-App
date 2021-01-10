<?php
    // lấy dữ liệu từ form
    $mabenh = $_POST['mb']; // lấy name ở dòng 44
    // echo $mabenh."<br>";
    $benh = $_POST['tb']; // lấy name ở dòng 49
    // echo $benh."<br>";
    $mota = $_POST['mt']; // lấy name ở dòng 55
    // echo $mota."<br>";
    $trieuchung = $_POST['tc']; // lấy name ở dòng 69 lưu bằng mảng [] do có nhiều triệu chứng
    
    // thực hiện kết nối đến CSDL
    require 'connect.php';

    // viết câu truy vấn để update dữ liệu vào bảng benh
    $sql = "UPDATE benh SET tenloaibenh='$benh', mota='$mota' WHERE maloaibenh='$mabenh';";

    // nếu người dùng có click chọn triệu chứng bệnh (tức là số phần tử trong mảng $trieuchung là khác 0)
    // thì mới thực hiện việc xóa hết các triệu chứng cũ đi và cập nhật lại danh sách triệu chứng
    // mục đích là để tránh trường hợp không chọn triệu chứng nào nó cũng vẫn xóa hết
    if(count($trieuchung) != 0){
        // xóa toàn bộ triệu chứng trong bảng chitietbenh
        $sql .= "DELETE FROM chitietbenh WHERE maloaibenh='$mabenh';";
        
        // lấy các mã triệu chứng từ thẻ select để update dữ liệu vào bảng chitietbenh
        foreach($trieuchung as $value){
            $sql .= "INSERT INTO chitietbenh (maloaibenh, matrieuchung) VALUES ('$mabenh', '$value');";
        }
    }
    
    // thực thi các câu truy vấn
    $connection->multi_query($sql);

    // đóng kết nối CSDL
    $connection->close();

    // điều hướng trở về trang admin
    header("location: admin.php");
?>