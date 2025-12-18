<?php 
    session_start();
    include '../database/db_connect.php';

    
    $email = $_POST["email"];
    $password = $_POST["password"];

    // $verify_password = password_verify()

    $sql = "SELECT admin_id from admin WHERE email = :email AND password_hash = :password";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $password);
    $stmt->execute();
    $res = $stmt->fetchColumn();

    if($res){
        $_SESSION["admin"] = $res;
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Incorrect Email or Passoword";
    }
    // $conn = null;
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>admin-login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>
  <div class="container d-flex align-items-center justify-content-center vh-100"> 
            <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>" target="_blank">
                <div class="row mb-3 text-center">
                    <h1>Login</h1>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                    <input type="email" name="email" class="form-control" id="inputEmail3">
                    <div id="" >
                        <span class="bs-danger"><?php echo "$emailErr"; ?></span>
                    </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPassword3" class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                    <input type="password" name="password" class="form-control" id="inputPassword3">
                    <div id="" >
                        <span class="bs-danger"><?php echo "$passwordErr"; ?></span>
                    </div>
                    </div>
                </div>

                <div id="" >
                        <span class="bs-danger"><?php echo "$loginErr"; ?></span>
                </div>
                <div class="row mb-3 justify-content-center text-center" style="margin-top: 30px;">
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </div>
        </form>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>