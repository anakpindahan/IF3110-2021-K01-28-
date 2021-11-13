<?php
    if(!isset($_COOKIE['username'])){
        header('Location: Authenticate.php');
    }
    $user = $_COOKIE["username"];
    try {
            $db = new PDO('sqlite:../Databases/dorayakuy.db');
    } catch(PDOException $e){
        die("Error!" . $e->getMessage());   
    }
    // $temp = "SELECT * FROM USER WHERE username = $user";
    // $userdata = $db->query($temp);
    // $role = $userdata["is    _admin"];
    // Anggap ambil id varian dorayaki dari GET
    $id_dora = $_GET['id'];
    $sql_stmt = "SELECT * FROM DORAYAKI WHERE id = $id_dora";
    $info_dorayaki = $db->query($sql_stmt);
    $rows = $info_dorayaki->fetchAll();
    $data = $rows[0];
    $name = $data["name"];
    $desc = $data["desc"];
    $price = $data["price"];
    $stock = $data["stock"];
    $imgpath = $data["image_path"];
?>
<!DOCTYPE HTML>

<head>
    <title>Buy Dorayaki</title>
    <link rel="stylesheet" href="BuyDorayaki.css">
    <script>
        var id = <?php echo $id_dora;?>;
    </script>
    <script src="BuyDorayaki.js"></script>
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

    <div class="variant-description">
        <img class = "dorayaki_img" src="<?php echo $imgpath?>">
        <div class = "DorayakiDetails">
            <h3>Nama Varian: <?php echo $name?></h3>
            <div class="Sebaris">
                <p class="label"> Harga Satuan:</p>
                <p id="hargaSatuan"><?php echo $price?></p>
            </div>
            <div class="Sebaris">
                <p class="label">Deskripsi:</p>
                <p><?php echo $desc?></p>
            </div>
            <div class = "Sebaris">
                <p class="label">Stock: </p>
                <p id="BatasStok"> <?php echo $stock?></p>
            </div>
            <div id = "BuyForm">
                <?php
                    if ($_COOKIE['is_admin'] == 0){
                        echo "<h5>Amount to Buy : </h5>";
                    }
                    else{
                        echo "<h5>Masukkan Banyaknya Dorayaki Ini Yang Tersedia : </h5>";
                    }
                ?>
                <div class = "BuyPage">
                    <div class = "Amount">
                        <button class = "AmountButtons" id="-Button" onclick = "minus()">-</button>
                    </div>
                    <div class ="AmountNum">
                        <input type="number" name = "amount" id ="amount-buy-num" value = 1 oninput = <?php if($_COOKIE['is_admin'] == 0){echo "updateTotalHarga()";}?>>
                    </div>
                    <div class= "Amount">
                        <button class = "AmountButtons" id="+button" onclick = "<?php if($_COOKIE['is_admin'] == 0){echo "plus()";} else{echo "plusAdmin()";}?>">+</button>
                    </div>
                </div>
                <div class = "TotalPrice">
                    <?php
                        if ($_COOKIE['is_admin'] == 0){
                            echo '<h5 id="totalPriceText">Total Price:</h5>
                            <h5 id = "TotalPriceLabelNum">'
                            .$price.
                            '</h5>';
                        }
                    ?>
                </div>
                <button id="BuyButton" class = "BuyButton" onclick = "buyy()">
                    <?php 
                        if ($_COOKIE['is_admin'] == 0){
                            echo "Buy";
                        }
                        else{
                            echo "Edit Stock";
                        }
                    ?>
                </button>
                <label id="pesanPembelian" for="BuyButton"></label>
            </div>
        </div>
        
    </div>
        
        
        <script>
            function buyy(){
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("pesanPembelian").innerHTML = this.responseText;
                    }
                };
                xhttp.open("POST", "UpdateStock.php", true);
                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp.send("id=" + <?php echo $id_dora?> +"&stokDibeli="+ document.getElementById("amount-buy-num").value.toString());
            }

            function realTimeUpdateStock(){
                var xhttp = new XMLHttpRequest();
                xhttp.open("GET", "RealTimeStock.php?id="+<?php echo $id_dora?>, true);
                xhttp.send();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("BatasStok").innerHTML = xhttp.responseText;
                    }
                };
                setTimeout(realTimeUpdateStock, 2000);
            }
            realTimeUpdateStock();
        </script>
</body>
</html>

