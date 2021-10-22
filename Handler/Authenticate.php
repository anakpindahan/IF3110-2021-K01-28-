<?php

try {
    $db = new PDO('sqlite:../Databases/dorayaki_user.db');
} catch(PDOException $e){
    die("Error!" . $e->getMessage());   
}

$password_valid = false;
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$stmt = $db->prepare('SELECT password, is_admin FROM users WHERE username = ?');
$stmt->execute(array($username));
$row = $stmt->fetch();
if($row) {
    $password_valid = password_verify($password, $row[0]);
} 

if(! $password_valid){
    $errors[] = 'Wrong password or username';
} else {
    setcookie('username', $username, time() + (86400 * 2), '/');
    setcookie('is_admin', $is_admin, time() + (86400 * 2), '/');
}
?>

