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

    $nama_varian = $_POST['nama-varian'];
    $harga_varian = $_POST['harga-varian'];
    $stok_awal_varian = $_POST['stok-awal-varian'];
    $deskripsi_varian = $_POST['deskripsi-varian'];
    $file_gambar = $_FILES['gambar-varian'];

    // Pindahkan gambar ke folder database
    $upload_dir = 'App/Database/images';
    if($file_gambar['error'] == UPLOAD_ERR_OK){
        $tmp_name = $file_gambar['tmp_name'];
        $name = basename($file_gambar['name']);
        move_uploaded_file($tmp_name, '$upload_dir/$name');
        
        $sql_stmt = 
        "INSERT INTO DORAYAKI(name, desc, price, stock, image_path)
        VALUES($nama_varian, $deskripsi_varian, $harga_varian, $stok_awal_varian, '$upload_dir/$name')";
        if(mysqli_query($conn, $sql_stmt)){
            echo 'Varian berhasil ditambahkan';
            header('Location: TambahVarian.html');
        } else {
            echo 'Varian gagal ditambahkan';
            header('Location: TambahVarian.html');
        }
    } else {
        echo "Tidak ada gambar yang diunggah";
        header('Location: TambahVarian.html');
    }





?>