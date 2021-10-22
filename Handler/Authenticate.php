<?php

try {
    $db = new PDO('sqlite:../Databases/dorayakuy.db');
} catch(PDOException $e){
    die("Error!" . $e->getMessage());   
}

$password_valid = false;
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$stmt = $db->prepare('SELECT password, is_admin FROM USER WHERE username = ?');
$stmt->execute(array($username));
$row = $stmt->fetch();
$is_admin = "";
if($row) {
    $is_admin = $row[1];
    $password_valid = password_verify($password, $row[0]);
} 

if(! $password_valid){
    $errors[] = 'Wrong password or username';
} else {
    setcookie('username', $username, time() + (86400 * 2), '/');
    setcookie('is_admin', $is_admin, time() + (86400 * 2), '/');
    header('Location: dashboard.php');
}
?>

