<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 

        $errMsg = "";
        $nameErr = $emailErr = $passwordErr = $mobErr = "";
        $email = $name = $mob = $password = "";
        
        // retriving login cookie data 
        if(isset($_COOKIE["login_user"])){
            $loginCookieData = json_decode($_COOKIE["login_user"], true);
            foreach($loginCookieData as $k => $v){
                $email = $v["email"];
                $name = $v["name"];
                $mob = $v["mob"];
                $password = $v["password"];
            }   
        } else {
            $errMsg = "User is not logged in";
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $newName = $newEmail = $newMob = $newPassword = "";

            $oldName = $_POST["name"];
            $oldEmail = $_POST["email"];
            $oldMob = $_POST["mob"];
            $oldPassword = $_POST["password"];

            // name 
            if(empty($oldName)){
                $nameErr = "name is required";
            } else {
                $newName = $oldName;
            }
            // email
            if(empty($oldEmail)){
                $emailErr = "email is required";
            } else {
                $newEmail = $oldEmail;
            }
            // mob
            if(empty($oldMob)){
                $mobErr = "Phone no. is required";
            } else {
                $newMob = $oldMob;
            }
            // password
            if(empty($oldPassword)){
                $passwordErr = "Password is required";
            } else {
                $newPassword = $oldPassword;
            }

            if(isset($_COOKIE["users"])){
                $usersData = json_decode($_COOKIE["users"], true);

                echo "var_dump($usersData)";

                unset($usersData[$email]);

                $newUser = [
                    $email => [
                        "name" => $newName,
                        "email" => $newEmail,
                        "mob" => $newMob,
                        "password" => $newPassword
                    ]
                ];

                $usersData += $newUser;
                setcookie("users", json_encode($usersData), time()+600);
                setcookie("login_user", json_encode(($usersData)), time()+600);
            }

        }

    
    ?>
    <h1>Profile page</h1>
    
    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <label for="name">Name: </label>
        <input type="text" name="name" value="<?php echo "$name" ?>" disabled class="required">
        <span><?php echo "$nameErr" ?></span>

        <br>

        <label for="email">email: </label>
        <input type="email" name="email" value="<?php echo "$email" ?>" disabled class="required">
        <span><?php echo "$emailErr" ?></span>

        <br>

        <label for="mobile">Mobile: </label>
        <input type="tel" name="mob" value="<?php echo "$mob" ?>" disabled class="required">
        <span><?php echo "$mobErr" ?></span>

        <br>

        <label for="Password">Password: </label>
        <input type="password" name="password" value="<?php echo "$password" ?>" disabled class="required pass">
        <span class="show" style="cursor: pointer;">show</span>
        <span><?php echo "$passwordErr" ?></span>
        

        <br><br>
        <input type="submit" value="Submit">
        <button class="edit">Edit</button>
    </form>

    <script>
        let editBtn = document.querySelector(".edit");
        let allFields = document.querySelectorAll(".required");
        let showBtn = document.querySelector(".show");
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
</body>
</html>