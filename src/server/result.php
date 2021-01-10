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
                            onchange="search(this.value);"/>
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
            // lấy dữ liệsu từ form 
            $str = $_GET['DSTrieuchung'];
            $dstrieuchung = explode(", ", $str);
            
            // thực hiện kết nối đến CSDL
            require 'connect.php';

            // viết câu truy vấn
            $sql = "SELECT tenloaibenh, GROUP_CONCAT(tentrieuchung SEPARATOR', ') AS 'trieuchung', mota 
                    FROM benh, chitietbenh, trieuchung 
                    WHERE benh.maloaibenh=chitietbenh.maloaibenh 
                    AND chitietbenh.matrieuchung=trieuchung.matrieuchung 
                    GROUP BY benh.maloaibenh;";

            // thực thi câu truy vấn
            $result = $connection->query($sql);
            $max = 0;
            $tenbenh = "";

            echo "<div class='container'>";
            echo "<h1>DANH SÁCH BỆNH</h1>";
            echo "<table id='result' class='table table-borderless'>";

            while(($row = $result->fetch_assoc()) !== null){ 
                $trieuchung = explode(", ", $row['trieuchung']);
                $match = compare($dstrieuchung, $trieuchung);
                
                if($match > $max){
                    $max = $match;

                    // lưu lại thông tin bệnh khớp nhất với các triệu chứng người dùng nhập vào
                    $tenbenh = $row['tenloaibenh'];
                   
                    // hiển thị thông tin bệnh
                    echo "<tr>";
                        echo "<th scope='row'>Chẩn đoán:</th>";
                        echo "<td>".$row['tenloaibenh']."</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<th scope='row'>Triệu chứng:</th>";
                        echo "<td>".$row['trieuchung']."</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<th scope='row'>Lời khuyên:</th>";
                        echo "<td>".$row['mota']."</td>";
                    echo "</tr>";                    
                }
            }
            echo "</table>";
            echo "</div>";
            
            /* Hàm so sánh hai mảng
            Đầu vào:
            - mảng 1: danh sách các triệu chứng người dùng nhập, ví dụ: $mang1 = [Sốt cao, Buồn nôn]
            - mảng 2: danh sách các triệu chứng lấy trong CSDL, ví dụ: $mang2 = [Sốt cao, Buồn nôn, Khó thở, Da khô, Đổ mồ hôi, Tiêu chảy, Tụt huyết áp, Nóng lạnh thân nhiệt, Rối loại ý thức, Mặt đỏ]
            
            Đầu ra: số triệu chứng giống nhau giữa hai mảng, ví dụ ở trên mảng 1 giống mảng hai hai triệu chứng là Sốt cao, Buồn nôn => trả về kết quả biến $count = 2
            */
            function compare($mang1, $mang2){
                $count = 0;
                for($i = 0; $i < count($mang1); $i++){
                    for($j = 0; $j < count($mang2); $j++){
                        $chuoi1 = $mang1[$i];
                        $chuoi2 = $mang2[$j];
                        if(strcmp(strtolower($chuoi1), strtolower($chuoi2)) == 0){
                            $count++;
                        }
                    }
                }
                return $count;
            }
            
            // hiển thị kết luận           
            echo "<div class='container'>";
                echo "<h1> KẾT LUẬN: ".$tenbenh."</h1>";
            echo "</div>";   

            // đóng kết nối CSDL
            $connection->close(); 
        ?>
    </body>
    <script src="../client/index.js"></script>
</html>