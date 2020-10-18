<!DOCTYPE html>
<?php
    // thực hiện kết nối đến cơ sở dữ liệu
    require 'connect.php';
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

            echo "<div id='container'>";
                echo "<div id='header'>";
                    echo "<h3> Thông tin bệnh </h3>";
                echo "</div>"; // end div header
                
                echo "<div id='content'>";
                    echo "<table border='1'>";
                    echo "<tr> 
                        <th> Mã loại bệnh </th>
                        <th> Tên loại bệnh </th>
                        <th> Tên triệu chứng </th>
                        <th> Mô tả </th>
                        <th> Sửa </th>
                        <th> Xóa </th>
                    </tr>";
                    
                    // lấy từng dòng trong CSDL
                    while(($row = $result->fetch_assoc()) !== null){
                        // echo $row['tenloaibenh'] . " " . $row['tentrieuchung'] . " " . $row['mota'] . "<br/>";
                        echo "<tr> 
                            <td>".$row['mabenh']."</td>
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
                    echo "</table>";
                echo "</div>"; // end div content
            echo "</div>"; // end div container
        ?>

        <button type="button" onclick="show()">Thêm mới bệnh</button>
        <div class="form-nhap">
        <form action="add.php" method="GET">
            <table>
                <tr>
                    <td><label>Mã bệnh<label></td>
                    <td><input type="text" name="mabenh"/></td>
                </tr>
                <tr>
                    <td><label>Tên bệnh<label></td>
                    <td><input type="text" name="tenbenh"/></td>
                </tr>
                <tr>
                    <td><label>Mô tả<label></td>
                    <td><textarea name="mota" rows="15" cols="60"></textarea></td>
                </tr>
                <tr>
                    <td><label>Triệu chứng<label></td>
                    <td>
                        <select name="trieuchung[]" multiple>
                            <?php
                                $sql = "SELECT * FROM trieuchung";
                                $result = $connection->query($sql);
                                while(($row = $result->fetch_assoc()) !== null){
                                    echo"<option value='".$row['matrieuchung']."'>".$row['tentrieuchung']."</option>";
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr><td><input type="submit" value="Thêm"/></td></tr>
            </table>
        </form>
        </div>
    </body>
    <!-- add JS code -->
    <script src="./index.js"></script>
</html>
<?php
    // đóng kết nối CSDL
    $connection->close();
?>