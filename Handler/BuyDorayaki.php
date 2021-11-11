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
    <!-- <link rel="stylesheet" type="text/css" href="../style/BuyDorayaki.css"> -->
    <script>
        var id = <?php echo $id_dora;?>;
    </script>
    <script src="../App/Handler/BuyDorayaki.js"></script>
</head>
<body>
    <div class = "BuyImage">
        <img class = "dorayaki_img" src="../<?php echo $imgpath?>"> </img>
    </div> 
    <div class = "DorayakiDetails">
        <h3><?php echo $name?></h3>
        <h4>Price : <?php echo $price?></h4>
        <h4>Description</h4>
        <p><?php echo $desc?></p>
    </div>
    <div id = "BuyForm">
        <h5>Amount to Buy : </h5>
        <div class = "BuyPage">
            <div class = "Amount">
                <button class = "AmountButtons" id="-Button" onclick = "decrement(e, <?php echo $price?>)"></button>
            </div>
            <div class ="AmountNum">
                <input type="number" name = "amount" id ="amount-buy-num" value = 1>
            </div>
            <div class= "Amount" style = "float: right;">
                <button class = "AmountButtons" id="+button" onclick = "increment(e, <?php echo $price ?>, <?php echo $stock ?>);">+</button>
            </div>
        </div>
    </div>
        <div class = "TotalPrice">
            <h5>Total Price:</h5>
            <label id = "TotalPriceLabel">Rp </label>
            <label id = "TotalPriceLabelNum">
                <?php echo number_format($price, 2, ',', '.')?>
            </label>
        </div>
        <button class = "BuyButton" onclick = "buyy()"></button>
        <script>
            function buyy(){
                console.log(3);
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        console.log(this.responseText);
                    }
                };
                xhttp.open("POST", "UpdateStock.php", true);
                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp.send("id=" + <?php echo $id_dora?> +"&stokDibeli="+ document.getElementById("amount-buy-num").value.toString());
            }

        </script>
</body>
</html>
//
