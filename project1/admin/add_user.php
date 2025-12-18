<?php 

    // session_start();
    // include '../database/db_connect.php';

    // $first_name = $_POST['first_name'];
    // $last_name = $_POST['last_name'];
    // $phone_no = $_POST['phone_no'];
    // $email = $_POST['email'];   
    // $plain_password = $_POST['password'];
    // $role = $_POST['role'];
    // $err_msg = "";

    
    // $password_hash = password_hash($plain_password, PASSWORD_DEFAULT);
    // echo $first_name . " " . $last_name . " " . $phone_no . " " . $email . " " .  $plain_password . " " . $role . "$password_hash";

    // $checkEmailSql = "SELECT email FROM users WHERE email = :email";
    // $check_email_stmt = $conn->prepare($checkEmailSql);
    // $check_email_stmt->bindParam(":email", $email);
    // $check_email_stmt->execute();
    // $checkEmail = $check_email_stmt->fetchColumn();

    // if($checkEmail){
    //     $err_msg = "email is already in use";
    //     header("Location: dashboard.php");
    //     exit();
    // } else {
    //         try {
    //         $sql = "INSERT INTO users (first_name, last_name, phone_no, email, password_hash, user_role) VALUES (:first_name, :last_name, :phone_no, :email, :password_hash, :user_role)";
    //         $stmt = $conn->prepare($sql);
    //         $stmt->bindParam(':first_name', $first_name);
    //         $stmt->bindParam(':last_name', $last_name);
    //         $stmt->bindParam(':phone_no', $phone_no);
    //         $stmt->bindParam(':email', $email);
    //         $stmt->bindParam(':password_hash', $password_hash);
    //         $stmt->bindParam(':user_role', $role);
    //         $stmt->execute();
    //     } catch (PDOException $e) {
    //         echo $sql . "<br>" . $e->getMessage();
    //     }
    // }

    // header("Location: dashboard.php");
    // exit();

?>

<?php 
    session_start();
    include '../database/db_connect.php';

    $name = $_POST['name'];
    $email = $_POST['email'];   
    $plain_password = $_POST['password'];
    $role = $_POST['role'];
    $err_msg = "";

    
    $password_hash = password_hash($plain_password, PASSWORD_DEFAULT);
    echo $name .  " "  . $email . " " .  $plain_password . " " . $role . " ". "$password_hash";

    $checkEmailSql = "SELECT email FROM admin WHERE email = :email";
    $check_email_stmt = $conn->prepare($checkEmailSql);
    $check_email_stmt->bindParam(":email", $email);
    $check_email_stmt->execute();
    $checkEmail = $check_email_stmt->fetchColumn();

    if($checkEmail){
        $err_msg = "email is already in use";
        header("Location: dashboard.php");
        exit();
    } else {
            try {
            $sql = "INSERT INTO admin (name, email, password_hash, role_id) VALUES (:name, :email, :password_hash, :role_id)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password_hash', $password_hash);
            $stmt->bindParam(':role_id', $role);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }

    header("Location: dashboard.php");
    exit();
?>