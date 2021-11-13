<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel = "stylesheet" href= "tambahVarianStyle.css">
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

    <header> 
        <h1>Tambah Varian Dorayaki</h1>
    </header>

    <form class="add-form" method="POST" id="tambah-varian-form"  action="tambahVarian.php" enctype="multipart/form-data">
        <div class="label-input">
            <label id="nama-varian-label" for id="nama-varian">Nama Varian</label>
            <input
                   type="text"
                   name="nama-varian"
                   id="nama-varian"
                   placeholder="Masukkan nama varian yang akan ditambah"
                   class="add-input text-input"
                   required>
        </div>
        <div class="label-input">
            <label id="harga-varian-label" for id="harga-varian">Harga</label>
            <input 
                 type="number"
                 name="harga-varian"
                 id="harga-varian"
                 placeholder="Tulis harga varian tersebut"
                 class="add-input text-input"
                 required>
        </div>
        <div class="label-input">
            <label id="stok-awal-varian-label" for id="stok-awal-varian">Stok awal</label>
            <input 
                 type="number"
                 name="stok-awal-varian"
                 id="stok-awal-varian"
                 placeholder="Tulis stok awal varian tersebut"
                 class="add-input text-input"
                 required>
        </div>
        <div class="label-input">
            <label id="deskripsi-varian-label" for id="deskripsi-varian">Deskripsi</label>
            <textarea 
                id="deskripsi-varian" 
                name="deskripsi-varian" 
                placeholder="Deskripsikan varian dorayaki tersebut"
                class="add-input text-input"
                required>
            </textarea>
        </div>
        <div class="label-input">
            <label id="gambar-varian-label" for id="gambar-varian">Gambar varian</label>
            <input 
                type="file"
                name="gambar-varian"
                id="gambar-varian"
                class="add-input text-input"
                accept="image/*"
                required>
        </div>
       <div class="label-input">
            <input class="add-input" type="submit" id="tambah-varian" value="Tambah varian">
       </div>
    </form>
</body>
</html>
