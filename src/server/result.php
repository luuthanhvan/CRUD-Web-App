<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kết quả tìm kiếm</title>
    </head>
    <body>
        <div>
            <form action="result.php" method="GET">
               <label>Bách khoa y tế</label>
               <input type="search" name="DSTrieuchung"/>
               <input type="submit" value="Tìm kiếm"/>
            </form>
        </div>
        <?php
            // lấy dữ liệu từ form 
            $str = $_GET['DSTrieuchung'];

            // thực hiện kết nối đến CSDL
            require 'connect.php';

            // viết câu truy vấn
            $sql = "SELECT tenloaibenh, GROUP_CONCAT(tentrieuchung SEPARATOR', ') AS 'trieuchung', mota 
                    FROM benh, chitietbenh, trieuchung 
                    WHERE benh.maloaibenh=chitietbenh.maloaibenh 
                    AND chitietbenh.matrieuchung=trieuchung.matrieuchung 
                    GROUP BY tenloaibenh;";

            // thực thi câu truy vấn
            $result = $connection->query($sql);
            $max = 0;
            $tenbenh = "";
            $mota = "";

            // chọn ra bệnh có % khớp các triệu chứng với các triệu chứng của người dùng nhập vào
            while(($row = $result->fetch_assoc()) !== null){
                // echo $row['trieuchung'];
                $percent = compareStrings($str, $row['trieuchung']);
                if($percent > $max){
                    $max = $percent;
                    $tenbenh = $row['tenloaibenh'];
                    $mota = $row['mota'];
                }
            }
            
            // hàm kiểm tra 2 chuỗi, trả về % độ khớp giữa 2 chuỗi
            function compareStrings($s1, $s2) {
                // nếu chuỗi rỗng thì return 0
                if (strlen($s1)==0 || strlen($s2)==0) {
                    return 0;
                }
            
                // thay thế các ký tự không phải chữ và số
                $s1clean = preg_replace("/[^A-Za-z0-9-]/", ' ', $s1);
                $s2clean = preg_replace("/[^A-Za-z0-9-]/", ' ', $s2);
            
                // loại bỏ các double space
                while (strpos($s1clean, "  ")!==false) {
                    $s1clean = str_replace("  ", " ", $s1clean);
                }
                while (strpos($s2clean, "  ")!==false) {
                    $s2clean = str_replace("  ", " ", $s2clean);
                }
            
                // tách các chuỗi ra thành các sub-string sau đó lưu vào mảng
                $ar1 = explode(" ",$s1clean);
                $ar2 = explode(" ",$s2clean);
                $l1 = count($ar1);
                $l2 = count($ar2);
            
                // hoán đổi 2 mảng để mảng 1 có số phần tử luôn hớn hơn mảng 2.
                if ($l2>$l1) {
                    $t = $ar2;
                    $ar2 = $ar1;
                    $ar1 = $t;
                }
            
                // lật mảng 2, để biến các từ (value) thành các key
                $ar2 = array_flip($ar2);
                
                $maxwords = max($l1, $l2);
                $matches = 0;
            
                // tìm các từ khớp nhau
                foreach($ar1 as $word) {
                    if (array_key_exists($word, $ar2))
                        $matches++;
                }
            
                return ($matches / $maxwords) * 100;    
            }
            
            // hiển thị thông tin tìm kiểm
            echo "<table>";
                echo "<tr>";
                    echo "<th>Chẩn đoán:</th>";
                    echo "<td>".$tenbenh."</td>";
                echo "</tr>";


                echo "<tr>";
                    echo "<th>Lời khuyên:</th>";
                    echo "<td>".$mota."</td>";
                echo "</tr>";
            echo "</table>";

            // đóng kết nối CSDL
            $connection->close();
        ?>
    </body>
</html>