<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--bootstrap-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="../public/css/admin.css">
        <title>Sửa thông tin bệnh</title>
    </head>
    <body>
        <?php
            // lấy mã bệnh từ bên trang admin.php truyền qua
            $maBenh = $_GET['maBenh'];
            // echo $maBenh;

            // thực hiện kết nối đến CSDL
            require 'connect.php';

            // viết câu truy vấn lấy dữ liệu từ bảng benh
            $sql = "SELECT * FROM benh WHERE maloaibenh='$maBenh'";
            // echo $sql;
            // thực thi câu truy vấn
            $result = $connection->query($sql);

            // lấy 1 dòng từ kết quả truy vấn trả về
            $row = $result->fetch_assoc();

            $mabenh = $row['maloaibenh'];
            $tenbenh = $row['tenloaibenh'];
            // echo $tenbenh;
            $mota = $row['mota'];

            // xuất ngược các dữ liệu trong CSDL vào form
            echo "<div class='container'>";
                echo "<h3 class='title'> Sửa thông tin bệnh </h3>";
                echo "<form action='handleModify.php' method='POST'>";
                    echo "<input type='hidden' name='mb' value=".$mabenh.">";

                    echo "<div class='form-row'>";
                        echo "<div class='form-group col-md-6'>";
                            echo "<label>Tên bệnh</label>";
                            echo "<input class='form-control' type='text' name='tb' value='$tenbenh'>";
                        echo "</div>";
                    echo "</div>";
                    
                    echo "<div class='form-group'>";
                        echo "<label>Mô tả</label>";
                        echo "<textarea name='mt' class='form-control' rows='3' value='$mota'>".$mota."</textarea>";
                    echo "</div>";
        
                    echo "<label>Chọn triệu chứng</label>";
                    echo"<div class='vertical-scrollable'>";
                        echo "<div class='row'>";
                            $sql = "SELECT * FROM trieuchung";
                            $result = $connection->query($sql);
                            while(($row = $result->fetch_assoc()) !== null){
                                echo "<div class='col-sm-8'>
                                    <div class='form-group'>
                                        <input type='checkbox' name='tc[]' value='".$row['matrieuchung']."'/>
                                        <label>".$row['tentrieuchung']."</label>
                                    </div>
                                </div>";
                            }
                        echo "</div>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                        echo"<td><input id='btn-sua' class='btn btn-secondary' type='submit' value='Sửa'/></td>";
                        echo"<td><button id='btn-boqua' class='btn btn-secondary' type='button'>Bỏ qua</button></td>";
                    echo "</div>";
                echo "</form>";
            echo "</div>"; // end div container

            // đóng kết nối CSDL
            $connection->close();
        ?>

        <script>
            // bắt sự kiện onclick vào button Bỏ qua, điều hướng ngược về trang admin
            document.getElementById("btn-boqua").onclick = function () {
                location.href = "admin.php";
            };
        </script>
    </body>
</html>