<?php

	//starting the session
	session_start();
 
	//database connection
	try {
        $db = new PDO('sqlite:Databases/dorayaki_user.db');
    } catch(PDOException $e){
        die("Error!" . $e->getMessage());   
    }
 
    // Setting variables
    $email = $_POST["email"];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashedPass = password_hash($password, PASSWORD_DEFAULT);

    // Insertion Query
    $query = "INSERT INTO users (email, username, password, is_admin) VALUES('$email', '$username', '$hashedPass', 0)";
    $stmt = $db->prepare($query);

    // Check if the execution of query is success
    if($stmt->execute()){
        //redirecting to the index.php 
        header('location: ..\tugas-besar-1-Login\App\Controller\login.html');
    }
 

?>