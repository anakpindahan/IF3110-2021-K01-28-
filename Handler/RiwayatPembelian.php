<?php
    session_start();
        try {
            $db = new PDO('sqlite:../Databases/dorayakuy.db');
        } catch(PDOException $e){
            die("Error!" . $e->getMessage());   
        }
        $user = $_COOKIE["username"];
        if($_COOKIE["is_admin"] == 0){
            $sql= "SELECT dorayaki_name, price, counts, price*counts as total_harga, time, id_dorayaki from history join dorayaki on id_dorayaki = dorayaki.id where history.username = '$user' order by history.id";
            $res = $db->query($sql);
            $data = $res->fetchAll();
            $n_data = count($data);
        }
        else{
            $sql = "SELECT dorayaki_name, history.username,  is_admin, counts, time, id_dorayaki from history join user on history.username = user.username order by history.id";
            $res = $db->query($sql);
            $data = $res->fetchAll();
            $n_data = count($data);
            for ($i=0; $i<$n_data; $i++){
                if($data[$i][2]==0){
                    $data[$i][2] = "Pembelian";
                }
                else{
                    $data[$i][2] = "Update Stock";
                }

            }
            
        }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
    <link rel="stylesheet" href="HistoryStyle.css">
</head>
<body>
    <div class = "navbar">
        <div class="logo">
                <a class="brand" href="dashboard.php">Dorayakuy!</a>
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
    <div class = content>
        <h1>History</h1>

        <table id="hasil">
            <tr>
                <?php
                    if($_COOKIE["is_admin"] == 0){
                        echo '
                        <th> Varian Dorayaki </th>
                        <th> Harga </th>
                        <th> Jumlah dibeli </th>
                        <th> Total harga</th>
                        <th> Waktu Pembelian <th>
                        ';
                    }
                    else{
                        echo '
                        <th> Varian Dorayaki </th>
                        <th> Username </th>
                        <th> Tipe Pengubahan</th>
                        <th> Banyak Dorayaki</th>
                        <th> Waktu Pengubahan</th>
                        ';
                    }
                ?>
            </tr>
            <?php
                if ($_COOKIE["is_admin"] == 0){
                    for ($i=0; $i<$n_data; $i++){
                        echo '<tr>
                        <td>
                            <a href= "detailVariant.php?id='.$data[$i][5].'">'.$data[$i][0].'</a>
                        </td>';
                        for ($j=1; $j<5; $j++){
                            echo '
                            <td>'.$data[$i][$j].'</td>
                            ';
                        }
                        echo '</tr>';
                    }
                }
                else{
                    for ($i=0; $i<$n_data; $i++){
                        echo '<tr>
                        <td>
                            <a href= "detailVariant.php?id='.$data[$i][5].'">'.$data[$i][0].'</a>
                        </td>';;
                        for ($j=1; $j<5; $j++){
                            echo '
                            <td>'.$data[$i][$j].'</td>
                            ';
                        }
                        echo '</tr>';
                    }
                }
            ?>

        </table>
        <div id="controls"></div>
        <div id='cek'></div>
    </div>
    
    
</body>
<script>request_page(1)</script>
</html>
