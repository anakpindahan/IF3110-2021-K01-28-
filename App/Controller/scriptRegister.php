<?php
    try {
        $db = new PDO('sqlite:Databases/dorayaki_user.db');
    } catch(PDOException $e){
        die("Error!" . $e->getMessage());   
    }

    if (isset($_GET["user"])){
        $username = $_GET["user"];

        $sql = "SELECT COUNT(*) FROM users WHERE username = '$username'";
        $res = $db->query($sql);
        $count = $res->fetchColumn();

        if($count != 0){
            echo "#FF033E";
        }
    }
    if (isset($_GET["email"])){
        $email = $_GET["email"];

        $sql = "SELECT COUNT(*) FROM users WHERE email = '$email'";
        $res = $db->query($sql);
        $count = $res->fetchColumn();

        if($count != 0){
            echo "#FF033E";
        }
    }
    
?>