<?php 
    session_start();
    include './database/db_connect.php';

    $rolesSql = "SELECT * FROM roles";
    $role_stmt = $conn->prepare($rolesSql);
    $role_stmt->execute();
    $roles = $role_stmt->fetchAll(PDO::FETCH_ASSOC);
    // $conn = null;

    $email = $_POST["email"];
    $plain_password = $_POST["password"];
    $role = $_POST["role"];

    $sql = "SELECT email, password_hash FROM admin WHERE email = :email AND role_id = :role";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":role", $role);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if($result) {
        foreach($result as $r) {
            $verify_password = password_verify($plain_password, $r["password_hash"]);
        }
        if($verify_password){
            $_SESSION["admin"] = $res;
            header("Location: dashboard.php");
            exit();
        } else {
            echo "email or password is incorrect";
        }
    } else {
        echo "email or password is incorrect";
    }
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
                <div class="row mb-3">
                    <label for="role" class="form-label col-sm-3">Select role</label>
                    <div class="col-sm-9">
                        <select name="role" id="" class="form-select form-select mb-3">
                            <?php  foreach($roles as $r){?>
                                <option value="<?php echo $r["role_id"] ?>"><?php echo $r["role_name"] ?></option>
                            <?php }?>
                        </select>
                    </div>
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