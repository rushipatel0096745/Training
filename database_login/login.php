<?php  
    include 'db_connection.php';

    $nameErr = $emailErr = $mobErr = $passwordErr = "";
            
            $email = "";
            $user_password = "";
            $errMsg = "";
            $loginErr = "";

            // name
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                
                // email
                if (empty($_POST["email"])) {
                    $emailErr = "Email is required";
                } 
                else {
                    $email = $_POST["email"];
                } 
                //password
                if(empty($_POST["user_password"])) {
                    $passwordErr = "password is required";
                }
                else {
                    $user_password = $_POST['user_password'];
                }
               
                if($passwordErr == "" and $emailErr == ""){

                    $checkEmailSql = "SELECT * from user WHERE email = :email AND password = :password";
                    $checkEmailStmt = $conn->prepare($checkEmailSql);
                    $checkEmailStmt->bindParam(':email', $email);
                    $checkEmailStmt->bindParam(':password', $user_password);
                    $checkEmailStmt->execute();
                    $userData = $checkEmailStmt->fetchAll(PDO::FETCH_ASSOC);

                    if($userData){
                        foreach($userData as $u) {
                            $emailCookie = $u["email"];
                        }
                        setcookie("login_user", $emailCookie, time()+600, "/");
                        header("Location: profile.php"); 
                        exit;
                    } else {
                       $loginErr = "Invalid email or password";
                       setcookie("login_user", "",  time()-3600, "/");
                    }
                        $conn = null;
                }
                  
            } else {
                $passwordErr = "";
                $emailErr = "";
                $loginErr = "";
            }

?>



<!doctype html>
<html lang="en" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>
    <div class="container d-flex align-items-center justify-content-center vh-100"> 
            <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
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
                    <input type="password" name="user_password" class="form-control" id="inputPassword3">
                    <div id="" >
                        <span class="bs-danger"><?php echo "$passwordErr"; ?></span>
                    </div>
                    </div>
                </div>

                <div id="" >
                        <span class="bs-danger"><?php echo "$loginErr"; ?></span>
                </div>

                <button type="submit" class="btn btn-primary">Sign in</button>
        </form>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>