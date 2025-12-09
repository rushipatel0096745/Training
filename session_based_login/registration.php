<?php 
    session_start();
    // var_dump($_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registration</title>
        </head>
        <style>
            .validation-error {
                color: red;
            }
        </style>
        <body>
        <?php 
            $nameErr = $emailErr = $mobErr = $passwordErr = "";
            $name = "";
            $email = "";
            $mob = "";
            $password = "";


            // function set_session_variables($k, $v){
            //     $_SESSION[$k] = $v;
            // }

            // name
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // name
                if (empty($_POST["name"])) {
                    $nameErr = "Name is required";
                   
                } else {
                    $name = $_POST["name"];
                    // set_session_variables("name", $_POST["name"]);
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
                    // else {
                    //     // set_session_variables("email", $email);
                    //     $_SESSION["email"] = $_POST["email"];

                    // }
                } 
                //password
                if(empty($_POST["password"])) {
                    $passwordErr = "password is required";
                }
                else {
                    $password = $_POST['password'];
                    // set_session_variables("password", $_POST["password"]);
                    // $_SESSION["password"] = $_POST["password"];
                }
                // mobile
                if(empty($_POST["mob"])){
                    $mobErr = "Phone no is required";
                }
                else {
                    $mob = $_POST['mob'];
                }

                if($nameErr == "" and $mobErr == "" and $passwordErr == "" and $emailErr == ""){
                    
                    $user = [
                        $email => $password
                    ];
                    
                    if(!isset($_SESSION["users"])){
                        // setcookie("users", json_encode($user), time()+300);
                        $_SESSION["users"] = json_encode($user);
                    }else{
                        $existingUser = json_decode($_SESSION["users"], true);

                        foreach($existingUser as $k => $v) {
                            if($k === $_POST["email"]) {
                                $errMsg = "User already exist";
                                break;
                            }
                        }

                        if($errMsg == ""){
                            $existingUser += $user;
                            // setcookie("users", json_encode($existingUser), time()+300);
                            $_SESSION["users"] = json_encode($existingUser);
                        }


                    }
                    
                }
            }

            ?>

        <form  method="post" action="<?php echo $_SERVER["PHP_SELF"];?>" onsubmit="return submitHandler(event)" >
            <label for="name">Name: </label>
            <input type="text" name="name" class="required"> 
            <div class="validation-error"><?php echo "$nameErr" ?> </div> <br>

            <label for="email">Email: </label> 
            <input type="email" name="email" id="" class="required">
            <div class="validation-error"><?php echo "$emailErr" ?> </div> <br>

            <label for="mobile">Phone no. </label>
            <input type="tel" name="mob" id="" class="required">
            <div class="validation-error"><?php echo "$mobErr" ?></div> <br>

            <label for="password">Password: </label>
            <input type="password" name="password" id="" class="required">
            <div class="validation-error"><?php echo "$passwordErr" ?></div> <br>


            <input type="submit" value="submit">

        </form>
        <script src="validation.js"></script>

    
</body>
</html>



