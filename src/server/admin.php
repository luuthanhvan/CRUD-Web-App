<!DOCTYPE html>
<?php
    // thực hiện kết nối đến cơ sở dữ liệu
    require 'connect.php';
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--bootstrap-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="../public/css/admin.css">
        <title>Admin</title>
    </head>
    <body>
        <?php
            // viết câu truy vấn để thực hiện việc lấy dữ liệu từ CSDL => mục đích: hiển thị thông tin bệnh
            $sql = "SELECT benh.maloaibenh AS mabenh, tenloaibenh, GROUP_CONCAT(tentrieuchung SEPARATOR', ') AS 'trieuchung', mota 
                    FROM benh, chitietbenh, trieuchung 
                    WHERE benh.maloaibenh=chitietbenh.maloaibenh 
                    AND chitietbenh.matrieuchung=trieuchung.matrieuchung 
                    GROUP BY tenloaibenh;";

            // thực thi câu truy vấn
            $result = $connection->query($sql);

            // hiển thị thông tin
            echo "<div class='container'>";
                echo "<h2 class='title'>Thông tin bệnh</h2>";
                echo "<table class='table table-striped'>";
                    echo "<thead>";
                        echo "<tr>
                                <th scope='col'>Mã bệnh</th>
                                <th scope='col'>Tên bệnh</th>
                                <th scope='col'>Triệu chứng</th>
                                <th scope='col'>Mô tả</th>
                                <th scope='col'>Sửa</th>
                                <th scope='col'>Xóa</th>
                            </tr>";
                    echo "</thead>";
                    echo "<tbody>";
                        // lấy từng dòng trong CSDL
                        while(($row = $result->fetch_assoc()) !== null){
                            // echo $row['tenloaibenh'] . " " . $row['tentrieuchung'] . " " . $row['mota'] . "<br/>";
                            echo "<tr> 
                                <th scope='row'>".$row['mabenh']."</th>
                                <td>".$row['tenloaibenh']."</td>
                                <td>".$row['trieuchung']."</td>
                                <td>".$row['mota']."</td>
                                <td>
                                    <a href='modify.php?maBenh=".$row['mabenh']."'><img src='../public/icons/edit.png' width='20px' height='20px'/></a>
                                </td>
                                <td>
                                    <a href='delete.php?maBenh=".$row['mabenh']."'><img src='../public/icons/delete.png' width='20px' height='20px'/></a>
                                </td>
                            </tr>";
                        }
                    echo "</tbody>";
                echo "</table>";
            echo "</div>"; // end div container
        ?>
        <!-- tạo form nhập bệnh -->
        <div class='container'>
            <button id="btn-them" type="button" class="btn btn-info" onclick="show()">Thêm mới bệnh</button>
            <div class="form-nhap">
                <form name="form-nhap" action="add.php" method="GET" onsubmit="return validateForm()">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input class="form-control" type="text" name="mabenh" placeholder="Nhập mã bệnh">
                            <p id="error1"></p>
                        </div>
                        <div class="form-group col-md-6">
                            <input class="form-control" type="text" name="tenbenh" placeholder="Nhập tên bệnh">
                            <p id="error2"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mô tả</label>
                        <textarea name="mota" class="form-control" rows="3"></textarea>
                    </div>
                    <select name="trieuchung[]" class="custom-select" multiple>
                        <optgroup label='Chọn triệu chứng'>
                            <?php
                                $sql = "SELECT * FROM trieuchung";
                                $result = $connection->query($sql);
                                while(($row = $result->fetch_assoc()) !== null){
                                    echo"<option value='".$row['matrieuchung']."'>".$row['tentrieuchung']."</option>";
                                }
                            ?>
                        </optgroup>
                    </select>
                    <input id="btn-submit" type="submit" value="Thêm"/>
                </form>
            </div>
        </div> <!-- end div container -->
    </body>
    <!-- add JS code -->
    <script src="./index.js"></script>
</html>
<?php
    // đóng kết nối CSDL
    $connection->close();
?>