<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--Bootstrap-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="../public/css/admin.css">

        <!-- Include Summernote CSS and JS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.js"></script>
        <title>Sửa thông tin bệnh</title>
    </head>
    <body>
        <?php
            // lấy mã bệnh từ bên trang admin.php truyền qua
            $maBenh = $_GET['maBenh'];

            // thực hiện kết nối đến CSDL
            require 'connect.php';

            // viết câu truy vấn lấy dữ liệu từ bảng benh
            $sql = "SELECT * FROM benh WHERE maloaibenh='$maBenh'";
            
            // thực thi câu truy vấn
            $result = $connection->query($sql);

            // lấy 1 dòng từ kết quả truy vấn trả về
            $row = $result->fetch_assoc();

            $mabenh = $row['maloaibenh'];
            $tenbenh = $row['tenloaibenh'];
            $mota = $row['mota'];

            // hiển thị dữ liệu cũ các dữ liệu trong CSDL vào form
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
                        echo "<textarea id='summernote' name='mt' class='form-control' rows='3' value='$mota'>".$mota."</textarea>";
                    echo "</div>";
        
                    echo "<label>Chọn triệu chứng</label>";
                    echo"<div class='vertical-scrollable'>";
                        echo "<div class='row'>";
                            $sql = "SELECT trieuchung.matrieuchung, trieuchung.tentrieuchung 
                                    FROM trieuchung, chitietbenh 
                                    WHERE trieuchung.matrieuchung=chitietbenh.matrieuchung
                                    AND chitietbenh.maloaibenh='$mabenh'";
                            $result = $connection->query($sql);
                            while(($row = $result->fetch_assoc()) !== null){
                                echo "<div class='col-sm-8'>
                                    <div class='form-group'>
                                        <input type='checkbox' name='tc[]' value='".$row['matrieuchung']."' checked/>
                                        <label>".$row['tentrieuchung']."</label>
                                    </div>
                                </div>";
                            }
                            
                            $sql = "SELECT * FROM trieuchung WHERE matrieuchung 
                                    NOT IN (SELECT trieuchung.matrieuchung 
                                            FROM trieuchung, chitietbenh 
                                            WHERE trieuchung.matrieuchung=chitietbenh.matrieuchung
                                            AND chitietbenh.maloaibenh='$mabenh')";

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
                        // trỏ tới trang handleModify.php ở trên bằng thuộc tính action 
                        echo"<td><input id='btn-sua' class='btn btn-secondary mr-md-2' type='submit' value='Sửa'/></td>";
                        // bắt sự kiện onclick ở dưới
                        echo"<td><button id='btn-boqua' class='btn btn-secondary mr-md-2' type='button'>Bỏ qua</button></td>";
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

            $(document).ready(function() {
                $('#summernote').summernote({
                    placeholder: 'Nhập mô tả bệnh...',
                    tabsize: 2,
                    height: 200,
                    minHeight: 100,
                    maxHeight: 300,
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontname', ['fontname']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']],
                    ],
                });
            });
        </script>
    </body>
</html>