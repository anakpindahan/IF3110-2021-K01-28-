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

    $nama_varian = $_POST['nama-varian'];
    $harga_varian = $_POST['harga-varian'];
    $stok_awal_varian = $_POST['stok-awal-varian'];
    $deskripsi_varian = $_POST['deskripsi-varian'];
    $file_gambar = $_FILES['gambar-varian'];

    // Pindahkan gambar ke folder database
    $upload_dir = '../Databases/images/';
    if($file_gambar['error'] == UPLOAD_ERR_OK){
        $tmp_name = $file_gambar['tmp_name'];
        $file = $file_gambar['name'];
        $path = pathinfo($file);
        $file_name = $path['filename'];
        $extension = $path['extension'];
        $target_path = $upload_dir . $file_name . '.' . $extension;
        move_uploaded_file($tmp_name, $target_path);
        
        $sql_stmt = $db->prepare("INSERT INTO DORAYAKI(name, desc, price, stock, image_path)
        VALUES(?, ?, ?, ?, ?)");
        if($sql_stmt->execute(array($nama_varian, $deskripsi_varian, $harga_varian, $stok_awal_varian, $target_path))){
            echo "<script type='text/javascript'>alert('Varian berhasil ditambahkan');</script>";
            header('Location: TambahVarianForm.php');
        } else {
            echo "<script type='text/javascript'>alert('Varian gagal ditambahkan');</script>";
            header('Location: TambahVarianForm.php');
        }
    } else {
        echo "<script type='text/javascript'>alert('Tidak ada gambar yang diunggah');</script>";
        header('Location: TambahVarianForm.php');
    }





?>
