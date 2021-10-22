<?php
    //$user = $_COOKIE["username"];
    try {
        $db = new PDO('sqlite:../Databases/dorayakuy.db');
    } catch(PDOException $e){
        die("Error!" . $e->getMessage());   
    }
    // Anggap ambil id varian dorayaki dari GET
    $id_dora = $_POST['id'];
    $val = $_POST['stokDibeli'];
    $val = intval($val);
    $sql_stmt = "SELECT * FROM DORAYAKI WHERE id = $id_dora";
    $info_dorayaki = $db->query($sql_stmt);
    $rows = $info_dorayaki->fetchAll();
    $data = $rows[0];
    $name = $data["name"];
    $desc = $data["desc"];
    $price = $data["price"];
    $stock = $data["stock"];
    $imgpath = $data["image_path"];
    $stmt = $db->prepare("UPDATE DORAYAKI SET name=?,desc=?,price=?,stock=?,image_path=? WHERE id=?");
    $stmt->execute(array($name,$desc,$price,$stock - $val,$imgpath, $id_dora));
    echo "Success";
?>
