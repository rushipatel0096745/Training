<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
    <?php
        $emailErr = $passwordErr = $loginErr = "";
        $email = $password = "";

        // function get_cookies($k){
        //     return $_COOKIE[$k];
        // }

        // $emailCookie = get_cookies("email");
        // $passwordCookie = get_cookies("password");
        $flag = false;
        $text = "";

        $users = json_decode($_COOKIE["users"], true);


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // email
            if (empty($_POST["email"])) {
                $emailErr = "Email is required";
            } 
            else {
                $email = $_POST["email"];
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email format";
                }
            }
            
            // password
            if (empty($_POST["password"])) {
                $passwordErr = "Password is required";
            } 
            else {
                $password = $_POST["password"];
            }

                // foreach($users as $e => $p){
                //     echo "$e => $p" . "<br>";
                //     if($e === $email and $p === $password){
                //         $flag = true;
                //         break;
                //     }
                //     else {
                //         $flag = false;
                //         $text = "Incorrect email or password";
                //     }
                // }

               // $userArr = [
                    //     "a@gmail.com" => [
                    //         "name" => "a",
                    //         "mob" => "moba",
                    //         "pass" => "passa"
                    //     ],
                    //     "b@gmail.com" => [
                    //         "name" => "b",
                    //         "mob" => "mobb",
                    //         "pass" => "passb"
                    //     ]
                    // ];

            
            foreach($users as $e => $p){
                if($e === $email and $p["password"] === $password){
                    $flag = true;
                    $user = [
                        $email => [
                            "name" => $p["name"],
                            "mob" => $p["mob"],
                            "password" => $p["password"],
                            "email" => $p["email"]
                        ]
                    ];
                    setcookie("login_user", json_encode($user), time()+60);
                    break;
                }
                else {
                    $flag = false;
                    $text = "Incorrect email or password";
                }
            }

            if($flag == true){
                header("Location: profile.php"); 
                $text = "";
                exit;
            }
        }
        
    ?>
    
    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" onsubmit="return submitHandler(event)">
        <label for="email" >Email</label>
        <input type="email" name="email" class="required" value="<?php $email?>"><?php echo "$emailErr" ?>
        <div class="validation-error"></div><br>
        <label for="password">Password</label>
        <input type="password" name="password" class="required" value="<?php $password?>"><?php echo "$passwordErr" ?>
        <div class="validation-error"></div><br><br>
        <span><?php echo "$text"?></span>
        <br>
        <input type="submit" value="submit">
    </form>
    <?php 
    echo "$emailCookie" . " " . "$passwordCookie";
    ?> 

    <script>
        function submitHandler(event) {
            const requiredFields = document.querySelectorAll('.required')
            let flag = false

            requiredFields.forEach((field) => {
                if(field.type == "email"){
                    const nextEle = field.nextElementSibling;
                    if (field.value === "") {
                        if (nextEle) {
                            nextEle.textContent = "email is required";
                            flag = false
                        }
                    } else {
                        nextEle.textContent = ""
                        flag = true
                    }
                }

                if(field.type == "password"){
                    const nextEle = field.nextElementSibling;
                    if (field.value === "") {
                        if (nextEle) {
                            nextEle.textContent = "Password is required";
                            flag = false
                        }
                    } else {
                        nextEle.textContent = ""
                        flag = true
                    }
                }
            })

            if(flag == true){
                return true
            } else {
                return false
            }
        }

    </script>
</body>
</html>