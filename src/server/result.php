<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--Bootstrap-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" href="../public/css/admin.css"/>
        <title>Kết quả tìm kiếm</title>
    </head>
    <body>
        <div id="container-result">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a id="title" class="navbar-brand" href="../client/home.html">Bách khoa y tế</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <form name="form-search" action="result.php" method="GET" class="form-inline my-2 my-lg-0" onsubmit="return validateForm()">
                        <input name="DSTrieuchung" id="input-search" class="form-control rounded-pill" type="search" 
                            placeholder="Nhập triệu chứng, ví dụ: ho, sổ mũi, nhức đầu"
                            onchange="search(this.value);" onfocus="this.onchange();"
                            onpaste="this.onchange();" oninput="this.onchange();"/>
                        <input class="btn btn-outline-info rounded-pill border-light" type="submit" value="Tìm kiếm"/>
                    </form>
                </div>
            </nav>
            <div>
            <!-- các thẻ p trống, mục đích là để dùng JS điền tự động các thông báo lỗi từ việc người dùng nhập vào form-->
                <div><p class="text-center" id="showContent"></p></div>
                <div><p class="text-center" id="emptyError"></p></div>
            </div>
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
            echo "<div class='container'>";
                echo "<table id='result' class='table table-borderless'>";
                    echo "<tr>";
                        echo "<th scope='row'>Chẩn đoán:</th>";
                        echo "<td>".$tenbenh."</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<th scope='row'>Lời khuyên:</th>";
                        echo "<td>".$mota."</td>";
                    echo "</tr>";
                echo "</table>";
            echo "</div>";

            // đóng kết nối CSDL
            $connection->close();
        ?>
    </body>
    <script src="../client/index.js"></script>
</html>