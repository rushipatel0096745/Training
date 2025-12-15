<?php  
    include 'db_connection.php';

    $nameErr = $emailErr = $mobErr = $passwordErr = "";
            $name = "";
            $email = "";
            $mob = "";
            $user_password = "";
            $errMsg = "";
            $signUpErr = "";

            // name
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // name
                if (empty($_POST["name"])) {
                    $nameErr = "Name is required";
                } else {
                    $name = $_POST["name"];
                }               
                // email
                if (empty($_POST["email"])) {
                    $emailErr = "Email is required";
                } 
                else {
                    $email = $_POST["email"];
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $emailErr = "Invalid email format";
                    }
                } 
                //password
                if(empty($_POST["user_password"])) {
                    $passwordErr = "password is required";
                }
                else {
                    $user_password = $_POST['user_password'];
                }
                // mobile
                if(empty($_POST["mob"])){
                    $mobErr = "Phone no is required";
                }
                else {
                    $mob = $_POST['mob'];
                }
                if($nameErr == "" and $mobErr == "" and $passwordErr == "" and $emailErr == ""){

                    $checkEmailSql = "SELECT email from user WHERE email = :email";
                    $checkEmailStmt = $conn->prepare($checkEmailSql);
                    $checkEmailStmt->bindParam(':email', $email);
                    $checkEmailStmt->execute();
                    $dbEmail = $checkEmailStmt->fetchAll(PDO::FETCH_ASSOC);

                    if($dbEmail){
                        $signUpErr = "user already exist";
                    } else {
                        try {
                         // prepare sql and bind parameters
                        $stmt = $conn->prepare("INSERT INTO user (username, email, phone_no, `password`)
                        VALUES (:username, :email, :phone_no, :password)");
                        $stmt->bindParam(':username', $name);
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':phone_no', $mob);
                        $stmt->bindParam(':password', $user_password);

                        // insert a row
                        $name = $name;
                        $email = $email;
                        $mob = $mob;
                        $user_password = $user_password;
                        $stmt->execute();

                        echo "New records created successfully";
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }   
                    }
                        $conn = null;
                }
                  
            } else {
                $nameErr = "";
                $passwordErr = "";
                $emailErr = "";
                $mobErr = "";
                $signUpErr = "";
            }

?>



<!doctype html>
<html lang="en" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>
    <div class="container d-flex align-items-center justify-content-center vh-100"> 
            <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
                <div class="row mb-3">
                    <label for="name" class="col-sm-3 col-form-label">Name: </label>
                    <div class="col-sm-9">
                    <input type="text" name="name" class="form-control" id="inputEmail3">
                    <div id="" >
                        <span class="bs-danger"><?php echo "$nameErr"; ?></span>
                    </div>
                    </div>
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
                    <label for="mob" class="col-sm-3 col-form-label">Phone no. </label>
                    <div class="col-sm-9">
                    <input type="tel" name="mob" class="form-control" id="inputEmail3">
                    <div id="" >
                        <span class="bs-danger"><?php echo "$mobErr"; ?></span>
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
                        <span class="bs-danger"><?php echo "$signUpErr"; ?></span>
                </div>

                <button type="submit" class="btn btn-primary">Sign in</button>
        </form>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>