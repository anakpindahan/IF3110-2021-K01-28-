<!DOCTYPE html>
<html lang="en">
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

    // Anggap ambil id varian dorayaki dari GET
    $id_dorayaki = intval($_GET['id']);
    $sql_stmt = "SELECT * FROM DORAYAKI WHERE id = $id_dorayaki";
    $info_dorayaki = $db->query($sql_stmt);
    $rows = $info_dorayaki->fetchAll();
    
    $row = $rows[0];
    $nama_varian = $row['name'];
    $deskripsi_varian = $row['desc'];
    $harga_varian = $row['price'];
    $stok_varian = $row['stock'];
    $gambar_varian_path = $row['image_path'];

    $sql_stmt = "WITH A AS (SELECT id_dorayaki, counts 
    FROM history JOIN user ON history.username = user.username WHERE is_admin = 0)
    SELECT sum(counts) FROM A WHERE id_dorayaki = $id_dorayaki";
    $info_dorayaki = $db->query($sql_stmt);
    $rows = $info_dorayaki->fetchAll();
    $row = $rows[0];
    $pembelian_varian = $row[0];
?>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="detailVariantStyle.css">
  <title> Detail-Varian-Dorayaki </title>
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
                        echo '<a href="TambahVarianForm.">Tambah varian</a>';
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

    <header> 
        <h1>Varian Dorayaki</h1>
    </header>


    <div class="variant-description" id="variant-description">
        <img 
            class="variant-image"
            src=<?php echo $gambar_varian_path?>
            alt=<?php echo $nama_varian?>
        >

        <div class="variant-texts">
            <p>Nama:  <?php echo $nama_varian?></p>
            <p>Deskripsi:  <?php echo $deskripsi_varian?></p>
            <p>Harga:  <?php echo $harga_varian?></p>
            <p>Stok:  <?php echo $stok_varian?></p>
            <p>Dorayaki terjual:  <?php echo $pembelian_varian?></p>
        </div>

        <?php
            if($_COOKIE["is_admin"] == 1){
                echo "
                <div class='button-group'>
                    <form method='post'>
                        <input type='submit' class='buy-button' name='delete-button' id='delete-button' value='Hapus'/>
                    </form>
                    <button type='submit' onclick = 'window.location.href =  \"BuyDorayaki.php?id=".$id_dorayaki . "\"' class = 'buy-button' id='edit-button'> Edit Stok </button>
                </div>
                ";
            } else {
                echo "
                <div class='button-group'>
                    <button onclick = 'window.location.href =  \"BuyDorayaki.php?id=".$id_dorayaki . "\"' class = 'buy-button' id='buy-button'> Beli </button>
                </div>";
            }

            if(isset($_POST['delete-button'])){
                confirm();
            }
            function confirm(){
                $id_dorayaki = $_GET['id'];
                echo str_replace(
                "idnya", $id_dorayaki,
                '<script type="text/javascript">
                    var id = idnya
                    confirmDelete();
                    function confirmDelete(){
                        var r = confirm("Apakah Anda yakin ingin menghapus varian dorayaki ini?");
                        if(r == true){
                            var txt = "delete_variant.php?id=" + id;
                            window.location.href = txt;
                        }
                    }
                </script>
                ');
            }
        ?>
    </div>


</body>

</html>




