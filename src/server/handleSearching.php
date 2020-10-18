<?php 
    require 'connect.php';
    
    $content = $_GET['content'];
    
    $sql = "SELECT * FROM trieuchung WHERE tentrieuchung LIKE '$content%'";
    
    $result = $connection->query($sql);
    
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo $row['tentrieuchung'];
        }
    }
    else{
        echo "";
    }
    
    $connection->close();
?>