<?php
    $user = $_COOKIE["username"];
    $is_admin = $_COOKIE["is_admin"];
    try {
        $db = new PDO('sqlite:../Databases/dorayakuy.db');
    } catch(PDOException $e){
        die("Error!" . $e->getMessage());   
    }
    // Anggap ambil id varian dorayaki dari POST
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
    $date = date('Y-m-d H:i:s');

    if($is_admin == 0){
        $stmt = $db->prepare("UPDATE DORAYAKI SET name=?,desc=?,price=?,stock=?,image_path=? WHERE id=?");
        $stmt->execute(array($name,$desc,$price,$stock - $val,$imgpath, $id_dora));
        $query = "INSERT into HISTORY (username, id_dorayaki, dorayaki_name, time, counts) values ('$user', '$id_dora', '$name', '$date', '$val')";
        $statement = $db->prepare($query);
        if($statement->execute()){
            echo "Success";
        }
        else{
            echo "terjadi error";
        }
    }
    else{
        $stmt = $db->prepare("UPDATE DORAYAKI SET name=?,desc=?,price=?,stock=?,image_path=? WHERE id=?");
        $stmt->execute(array($name,$desc,$price,$val,$imgpath, $id_dora));
        $query = "INSERT into HISTORY (username, id_dorayaki, dorayaki_name, time, counts) values ('$user', '$id_dora', '$name', '$date', '$val-$stock')";
        $statement = $db->prepare($query);
        if($statement->execute()){
            echo "Success";
        }
        else{
            echo "terjadi error";
        }  
    }
    
?>
