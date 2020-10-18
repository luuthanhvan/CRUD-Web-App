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
            $str = $_GET['DSTrieuchung'];
            // echo $str;

            require 'connect.php';

            $sql = "SELECT tenloaibenh, GROUP_CONCAT(tentrieuchung SEPARATOR', ') AS 'trieuchung', mota 
                    FROM benh, chitietbenh, trieuchung 
                    WHERE benh.maloaibenh=chitietbenh.maloaibenh 
                    AND chitietbenh.matrieuchung=trieuchung.matrieuchung 
                    GROUP BY tenloaibenh;";

            $result = $connection->query($sql);
            $max = 0;
            $tenbenh = "";
            $mota = "";

            while(($row = $result->fetch_assoc()) !== null){
                // echo $row['trieuchung'];
                $percent = compareStrings($str, $row['trieuchung']);
                if($percent > $max){
                    $max = $percent;
                    $tenbenh = $row['tenloaibenh'];
                    $mota = $row['mota'];
                }
            }
            
            function compareStrings($s1, $s2) {
                //one is empty, so no result
                if (strlen($s1)==0 || strlen($s2)==0) {
                    return 0;
                }
            
                //replace none alphanumeric charactors
                //i left - in case its used to combine words
                $s1clean = preg_replace("/[^A-Za-z0-9-]/", ' ', $s1);
                $s2clean = preg_replace("/[^A-Za-z0-9-]/", ' ', $s2);
            
                //remove double spaces
                while (strpos($s1clean, "  ")!==false) {
                    $s1clean = str_replace("  ", " ", $s1clean);
                }
                while (strpos($s2clean, "  ")!==false) {
                    $s2clean = str_replace("  ", " ", $s2clean);
                }
            
                //create arrays
                $ar1 = explode(" ",$s1clean);
                $ar2 = explode(" ",$s2clean);
                $l1 = count($ar1);
                $l2 = count($ar2);
            
                //flip the arrays if needed so ar1 is always largest.
                if ($l2>$l1) {
                    $t = $ar2;
                    $ar2 = $ar1;
                    $ar1 = $t;
                }
            
                //flip array 2, to make the words the keys
                $ar2 = array_flip($ar2);
            
            
                $maxwords = max($l1, $l2);
                $matches = 0;
            
                //find matching words
                foreach($ar1 as $word) {
                    if (array_key_exists($word, $ar2))
                        $matches++;
                }
            
                return ($matches / $maxwords) * 100;    
            }

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