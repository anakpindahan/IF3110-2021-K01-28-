<?php
    try {
        $db = new PDO('sqlite:../Databases/dorayakuy.db');
    } catch(PDOException $e){
        die("Error!" . $e->getMessage());   
    }
    $id_dorayaki = $_GET['id'];
    $sql_stmt = "DELETE FROM HISTORY WHERE id_dorayaki = $id_dorayaki";
    $update = $db->query($sql_stmt);
    $sql_stmt = "DELETE FROM DORAYAKI WHERE id = $id_dorayaki";
    $update = $db->query($sql_stmt);
    header('Location: dashboard.php');
?>