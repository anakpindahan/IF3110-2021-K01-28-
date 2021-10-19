<?php
    if (isset($_GET["keyword"]) && isset($_GET["pn"])){
        $key = $_GET["keyword"];
        $pn = $_GET["pn"];
        $rpp = $_GET["rpp"];
        $last = $_GET["last"];
        try {
            $db = new PDO('sqlite:Databases/database.db');
        } catch(PDOException $e){
            die("Error!" . $e->getMessage());   
        }

        if ($pn < 1){
            $pn = 1;
        }
        if ($pn>$last){
            $pn = $last;
        }

        $limit = ' LIMIT '.($pn - 1)*$rpp.', '.$rpp;
        $sql= "SELECT name, desc, price, stock, image_path from dorayaki where name like '%$key%' $limit";
        $res = $db->query($sql);
        $data = $res->fetchAll();

        $page_data = "";
        for($i=0; $i < count($data); $i++){
            $page_data.= $data[$i]["image_path"].'|'.$data[$i]["name"].'|'.$data[$i]["desc"].'|'.$data[$i]["price"].'|'.$data[$i]["stock"].'||';
        }

        echo $page_data;
    }
?>