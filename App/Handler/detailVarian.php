<!DOCTYPE html>
<html lang="en">
<?php
    $server = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'dorayakuy';

    $conn = mysqli_connect($server, $username, $password, $database);

    if(!$conn) {
        die("Connection failed!");
    }

    $dorayaki = new App\Controller\Dorayaki();
    if(!isset($_COOKIE['username'])){
        header('Location: Authenticate.php');
    }

    // Anggap ambil id varian dorayaki dari GET
    $id_dorayaki = $_GET['id'];
    $sql_stmt = "SELECT * FROM DORAYAKI WHERE id = $id_dorayaki";
    $info_dorayaki = mysqli_query($conn, $sql_stmt);
    $rows = mysqli_fetch_assoc($info_dorayaki);
    $row = $rows[0];
    $nama_varian = $row['name'];
    $deskripsi_varian = $row['desc'];
    $harga_varian = $row['price'];
    $stok_varian = $row['stock'];
    $gambar_varian_path = $row['image_path'];

    $sql_stmt = "SELECT count(counts) FROM HISTORY WHERE id_dorayaki = $id_dorayaki";
    $info_dorayaki = mysqli_query($conn, $sql_stmt);
    $row = $rows[0];
    $pembelian_varian = $row[0];
?>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="detailVarianStyle.css">
  <title> Deskripsi-Buku </title>
</head>

<body> 
    <header> 
        <h1>Varian Dorayaki</h1>
    </header>

    <div class="variant-description" id="variant-description">
        <img 
            class="variant-image"
            src=<?php echo $gambar_varian_path?>
            alt=<?php echo $nama_varian?>
        >

        <div class="variant-text">
            <p>"Nama: " <?php echo $nama_varian?></p>
            <p>"Deskripsi: " <?php echo $deskripsi_varian?></p>
            <p>"Harga: " <?php echo $harga_varian?></p>
            <p>"Stok: " <?php echo $stok_varian?></p>
            <p>"Pembelian: " <?php echo $pembelian_varian?></p>
        </div>

        <?php
            if($_COOKIE["is_admin"] == 1){
                echo '<button id="delete-button" type="button" onclick="alert(\'yakin ingin menghapus varian?\')">Hapus</button>'
                // TODO: Make button delete varian berfungsi
            } else {
                echo '<button id="buy-button" type="button" onclick="window.location.href=\'BuyDorayaki.php\'">Beli</button>'
            }
        ?>
    </div>


</body>

</html>




