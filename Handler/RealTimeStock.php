<?php
    try {
        $db = new PDO('sqlite:../Databases/dorayakuy.db');
    } catch(PDOException $e){
        die("Error!" . $e->getMessage());   
    }
    $id_dora = $_GET["id"];
    $stmt = "SELECT stock FROM DORAYAKI WHERE id = $id_dora";
    $stok = $db->query($stmt);
    $data = $stok->fetchAll();
    echo $data[0][0];
?>
