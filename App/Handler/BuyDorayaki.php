<?php
    require_once 'Connect.php';
    $dorayaki = new App/Controller/Dorayaki();
    if(!isset($_COOKIE['username'])){
        header('Location: Authenticate.php')
    }
    $usercookie = $_COOKIE['username'];
    $searchUser =  mysqli_query($conn, "SELECT * FROM user WHERE username = '$usercookie'");
    $rows = mysqli_fetch_assoc($searchUser);
    $role = $row["is_admin"];
    $user = $row["username"];
    if($role != FALSE) {
        echo "Restricted";
        header('Location: dashboard.php');
    }
    $data = $dorayaki->readAll();
    $id_dora = mysqli_real_escape_string($conn, $_GET["id"]);
    $id_dora = intval($id_dora);
    $data = $data->detail($id_dora);
    $name = $data["name"];
    $desc = $data["desc"];
    $price = $data["price"];
    $stock = $data["stock"];
    $imgpath = $data["image_path"];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {      
        $message_err = "";
        $buy_amount = trim($_POST["amount"]);      
        $intosql =
        "INSERT INTO HISTORY(username, id_dorayaki, dorayaki_name, time, counts)
        VALUES($user, $id_dora, $name , NOW(), $buy_amount)";
  
        $intosql .=
        "UPDATE DORAYAKI
        SET stock = stock - $buy_amount WHERE id = $id_dora";
      
        if(mysqli_multi_query($conn, $intosql)){
          header('Location: HistoryPage.php');
          close();
        }
?>
<!DOCTYPE HTML>

<head>
    <title>Buy Dorayaki</title>
    <link rel="stylesheet" type="text/css" href="../style/BuyDorayaki.css">
    <script>
        var id = <?php echo $id_dora;?>;
    </script>
    <script src="../App/Handler/BuyDorayaki.js"></script>
    <script src="../App/Handler/UpdateDorayaki.js"></script>
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
    <form id = "BuyForm" method = "post">
        <h5>Amount to Buy : </h5>
        <div class = "BuyPage">
            <div class = "Amount">
                <button class = "AmountButtons" id="-Button" onclick = "decrement(e, <?php echo $price?>)"></button>
            </div>
            <div class ="AmountNum">
                <input type="number" name = "amount" id ="amount-buy-num" value = 1>
            </div>
            <div class= "Amount" style = "float: right;">
                <button class = "AmountButtons" id="+button" onclick = "increment(e, <?php echo $price ?>, <?php echo $amount ?>);">+</button>
            </div>
        </div>
        <div class = "TotalPrice">
            <h5>Total Price:</h5>
            <label id = "TotalPriceLabel">Rp </label>
            <label id = "TotalPriceLabelNum"><?php echo number_format($price, 2, ',', '.');?></label>
        </div>
</body>
</html>