<?php 

    include '../database/db_connect.php';

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_no = $_POST['phone_no'];
    $email = $_POST['email'];   
    $plain_password = $_POST['password'];
    $role = $_POST['role'];

    
    $password_hash = password_hash($plain_password, PASSWORD_DEFAULT);
    echo $first_name . " " . $last_name . " " . $phone_no . " " . $email . " " .  $plain_password . " " . $role . "$password_hash";

    try {
        $sql = "INSERT INTO users VALUES (:first_name, :last_name, :phone_no, :email, :password_hash, :user_role)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':phone_no', $phone_no);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password_hash', $password_hash);
        $stmt->bindParam(':user_role', $role);
        $stmt->execute();
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    
    header("Location: dashboard.php");
    exit();



?>