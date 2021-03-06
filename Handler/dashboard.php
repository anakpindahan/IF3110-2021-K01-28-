<?php

    if(!isset($_COOKIE["username"])){
        header("Location: login.html");
    }
    $user = $_COOKIE["username"];
    try {
            $db = new PDO('sqlite:../Databases/dorayakuy.db');
    } catch(PDOException $e){
        die("Error!" . $e->getMessage());   
    }
    $limit = 8;
    $sql= "WITH A as (select id_dorayaki, counts from history join user on history.username = user.username where is_admin = 0) 
    SELECT id_dorayaki, name, image_path from dorayaki join A on A.id_dorayaki = dorayaki.id 
    group by id_dorayaki 
    order by sum(counts) desc;
    LIMIT $limit";
    $res = $db->query($sql);
    $data = $res->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="DashboardStyle.css">
    <title>Document</title>
</head>
<body>
    <div class = "navbar">
        <div class="logo">
                <a class="brand" href="dashboard.php">Dorayakuy!</a>
        </div>
        <div class="search-bar">
            <form method="GET" action="HalamanPencarian.php">
                <input class="kotak-pencarian" type="text" name = "keyword" placeholder="cari dorayaki berdasarkan nama">
                <input type ="submit" value = "search">
            </form>
        </div>
        <div class = "user-type">
            <div class="tombol">
                <?php
                    if($_COOKIE["is_admin"] == 1){
                        echo '<a href="TambahVarianForm.php">Tambah varian</a>';
                        echo '<div>|</div>';
                        echo'<a href="RiwayatPembelian.php"> Riwayat pembelian</a>';
                    }
                    else{
                        echo'<a href="RiwayatPembelian.php"> Riwayat pembelian</a>';
                    }
                ?>

            </div>
            <div>
                |
            </div>

            <div class="tombol">
                <a href="login.html"> logout </a>
            </div> 
        </div>    
    </div>
    <div class = "content">
        <h1> Our Best Dorayaki </h1>
        <?php
            for($i=0; $i < 2; $i++){
                echo '<div class="row">';
                for($j=0; $j<4; $j++){
                    $k  = 4*$i + $j;
                    if($k < count($data)){
                        $gambar = $data[$k]["image_path"];
                        $nama = $data[$k]["name"];
                        $idx_dora = $data[$k]["id_dorayaki"];
                        echo '
                        <div class = "best_dora">
                            <a href = "detailVariant.php?id='.$idx_dora.'">
                                <img src='.$gambar.' alt= "gambar dorayaki">
                            </a>
                            <a href = "detailVariant.php?id='.$idx_dora.'">
                                <p>'.$nama.'</p>
                            </a>
                        </div>
                        ';
                    }
                }
                echo '</div>';

            }

        ?>
    </div>
    <div class = ""></div>
    
</body>
</html>
