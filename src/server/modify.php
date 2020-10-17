<?php
    // lấy mã bệnh từ bên trang admin.php truyền qua
    $maBenh = $_GET['maBenh'];
    // echo $maBenh;

    // thực hiện kết nối đến CSDL
    require 'connect.php';

    // viết câu truy vấn lấy dữ liệu từ bảng benh
    $sql = "SELECT * FROM benh";

    // thực thi câu truy vấn
    $result = $connection->query($sql);

    // lấy 1 dòng từ kết quả truy vấn trả về
    $row = $result->fetch_assoc();

    $mabenh = $row['maloaibenh'];
    $tenbenh = $row['tenloaibenh'];
    $mota = $row['mota'];

    // xuất ngược các dữ liệu trong CSDL vào form
    echo "<div id='container'>";
        echo "<div id='header'>";
            echo "<h1> Sửa sản phẩm </h1>";
        echo "</div>"; // end div header

        echo "<div id='content'>";
            echo "<table>";
                echo "<form action='handleModify.php' method='GET'";
                    echo "<tr>";
                        echo "<td><input type='hidden' name='mabenh' value='$mabenh'></td>";
                    echo "</tr>";

                    echo "<tr>";
                        echo "<td><label>Tên bệnh</label></td>";
                        echo"<td><input type='text' name='tenbenh' value='$tenbenh'></td>";
                    echo "</tr>";
                    
                    echo "<tr> ";
                        echo "<td><label>Mô tả</label></td>";
                        echo "<td> <textarea rows='15' cols='60' name='mota'>".$mota."</textarea></td>";
                    echo "</tr>";
                    
                    echo "<tr>";
                        echo "<td><label>Triệu chứng<label></td>";
                        echo "<td>";
                            echo "<select name='trieuchung[]' multiple>";
                                $sql = "SELECT * FROM trieuchung";
                                $result = $connection->query($sql);
                                while(($row = $result->fetch_assoc()) !== null){
                                    echo"<option value='".$row['matrieuchung']."'>".$row['tentrieuchung']."</option>";
                                }
                            echo "</select>";
                        echo "</td>";
                    echo "</tr>";

                    echo "<tr> ";
                        echo"<td><input type='submit' value='Sửa'></td>";
                    echo "</tr>";
                echo "</form>";
            echo "</table>";
        echo "</div>"; // end div content
    echo "</div>"; // end div container

    // đóng kết nối CSDL
    $connection->close();
?>