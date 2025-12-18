<?php 
    session_start();
    include '../database/db_connect.php';
    $admin_id = $_GET["id"];
    try {
        $sql = "DELETE FROM admin WHERE admin_id = :admin_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":admin_id", $admin_id);
        $stmt->execute();

        // echo "user id" . $user_id . " " . "record deleted";
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    header("Location: dashboard.php");
    exit();
?>