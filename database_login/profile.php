<?php  
    include 'db_connection.php';

    $nameErr = $emailErr = $mobErr = $passwordErr = "";
            $name = "";
            $email = "";
            $mob = "";
            $user_password = "";
            $errMsg = "";
            $signUpErr = "";

            $emailCookie = $_COOKIE["login_user"];

            if($emailCookie){
                echo "$emailCookie";
                $checkEmailSql = "SELECT * from user WHERE email = :email";
                $checkEmailStmt = $conn->prepare($checkEmailSql);
                $checkEmailStmt->bindParam(':email', $emailCookie);
                $checkEmailStmt->execute();
                $userData = $checkEmailStmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($userData as $u){
                    $name = $u["username"];
                    $email = $u["email"];
                    $mob = $u["phone_no"];
                    $user_password = $u["password"];
                }

            } else {
                echo "user not logged in";
            }

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
                    try {
                        $updateUserSql = "UPDATE user SET username = :username, email = :email, phone_no = :mob, password = :password WHERE email='$email'";
                        $updateStmt = $conn->prepare($updateUserSql);
                        $updateStmt->bindParam(':username', $name);
                        $updateStmt->bindParam(':email', $email);
                        $updateStmt->bindParam(':mob', $mob);
                        $updateStmt->bindParam(':password', $user_password);
                        $updateStmt->execute();
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }   
                    setcookie("login_user", $email, time()+600, "/");
                }
                $conn = null;
            }
            else {
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
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <style>
    .pass {
        position: relative;
    }
    .show1 {
        position: absolute;
    }
  </style>
  <body>
    <div class="container d-flex align-items-center justify-content-center vh-100"> 
            <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
                <div class="row mb-3">
                    <label for="name" class="col-sm-3 col-form-label">Name </label>
                    <div class="col-sm-9">
                    <input type="text" name="name" class="form-control req" id="inputEmail3" disabled value="<?php echo "$name"; ?>">
                    <div id="" >
                        <span class="bs-danger"><?php echo "$nameErr"; ?></span>
                    </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                    <input type="email" name="email" class="form-control req" id="inputEmail3" disabled value="<?php echo "$email"; ?>">
                    <div id="" >
                        <span class="bs-danger"><?php echo "$emailErr"; ?></span>
                    </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="mob" class="col-sm-3 col-form-label">Phone no. </label>
                    <div class="col-sm-9">
                    <input type="tel" name="mob" class="form-control req" id="inputEmail3" disabled value="<?php echo "$mob"; ?>">
                    <div id="" >
                        <span class="bs-danger"><?php echo "$mobErr"; ?></span>
                    </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPassword3" class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                    <input type="password" name="user_password" class="form-control pass req" id="inputPassword3" disabled value="<?php echo "$user_password"; ?>">
                    <span class="show1" style="cursor: pointer;">show</span>
                    <div id="" >
                        <span class="bs-danger"><?php echo "$passwordErr"; ?></span>
                    </div>
                    </div>
                </div>

                <div id="" >
                        <span class="bs-danger"><?php echo "$signUpErr"; ?></span>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="submit" class="btn btn-primary edit">edit</button>

        </form>

    </div>

    <script>
        let editBtn = document.querySelector(".edit");
        let allFields = document.querySelectorAll(".req");
        let showBtn = document.querySelector(".show1");
        let pass = document.querySelector(".pass");

        
        editBtn.addEventListener("click", function(event){
            event.preventDefault();
            allFields.forEach((field) => {
                if(field.hasAttribute('disabled')){
                    field.removeAttribute('disabled')
                } else {
                    field.disabled = true
                }
            })
        })

        showBtn.addEventListener('click', function(event){
            event.preventDefault();
            if(pass.type == "password"){
                pass.type = "text"
                showBtn.innerHTML = "Hide";
            } else {
                pass.type = "password"
                showBtn.innerHTML = "show";
            }

        })
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>