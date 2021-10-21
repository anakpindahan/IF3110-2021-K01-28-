<?php
    require_once 'Connect.php';
    $dorayaki = new App\Controller\Dorayaki();
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
    $buy_amount = 0;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {      
        $message_err = "";
        $buy_amount = trim($_POST["amount"]);
        $buy_amount * $price      
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
{TODO : Page}