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
            $errMsg = "";
            $existingUser = [];



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
                if(empty($_POST["password"])) {
                    $passwordErr = "password is required";
                }
                else {
                    $password = $_POST['password'];
                    // set_cookies("password", $_POST["password"]);
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
                        "email" => $email,
                        "password" => $password,
                        "name" => $name
                    ];
                    
                    if(!isset($_COOKIE["users1"])){
                        setcookie("users1", json_encode([$user]), time()+300);
                    }else{
                        $existingUser = json_decode($_COOKIE["users1"], true);

                        foreach ($existingUser as $item){
                                if($item["email"] === $email){
                                    $errMsg = "User already exist";
                                    break;
                                } else {
                                    $errMsg = "";
                                }
                            }
                        }

                        if($errMsg == ""){
                            $existingUser[] = [
                                "email" => $email,
                                "password" => $password,
                                "name" => $name
                            ];
                            setcookie("users1", json_encode($existingUser), time()+300);
                        }

                    }
                    
                }
               
            
            ?>

        <form  method="post" action="<?php echo $_SERVER["PHP_SELF"];?>" onsubmit="return submitHandler(event)" >
            <label for="name">Name: </label>
            <input type="text" name="name" class="required"> <?php echo "$nameErr" ?> 
            <div class="validation-error"></div> <br>

            <label for="email">Email: </label> 
            <input type="email" name="email" id="" class="required"><?php echo "$emailErr" ?> 
            <div class="validation-error"></div> <br>


            <label for="mobile">Phone no. </label>
            <input type="tel" name="mob" id="" class="required"><?php echo "$mobErr" ?>
            <div class="validation-error"></div> <br>


            <label for="password">Password: </label>
            <input type="password" name="password" id="" class="required"><?php echo "$passwordErr" ?>
            <div class="validation-error"></div> <br>

            <?php echo "$errMsg"; ?>

            <input type="submit" value="submit">

        </form>
        <script src="validation.js"></script>

    
</body>
</html>



