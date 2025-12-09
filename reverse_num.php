<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">
        <input type="number" name="num">
        <input type="submit" value="submit">
    </form>
    <?php 
    $num = $_REQUEST["num"];
    echo "number $num" . "<br>";
    function rev_num($n){
        $rev = 0;
        while ($n !== 0) {
            $rem = $n  % 10;
            $rev = $rev*10 + $rem;
            $n = (int) $n / 10;
        }
        return $rev/10;
    }

    $res = rev_num($num);
    if($res){
        echo "$res";
    }

  // $user = [
                //     "email"=> $email,
                //     "password"=> $password,
                //     "name"=> $name
                // ];
    
                // $user_data = json_encode($user); // converted to json
                // $checkCookie = isset($_COOKIE["users"]);
    
                // if(!isset($_COOKIE["users"])){
                //     setcookie("users", $user_data, time() + (60 * 5));
                // }
                // else {
                //     $users_arr = json_decode($_COOKIE["users"], true); //gives users arr in php
                //     $users_arr = $user; //updating user_arr in php
                //     setcookie("users", json_encode($users_arr), time() + (60 * 5), "/"); //set cookies after updated array which converted to json 
                //     // if($users_arr[$email] === $user[$email]){
                //     //     $errMsg = "User already exist";
                //     // } else {
                //     //     $users_arr = $user; //updating user_arr in php
                //     //     setcookie("users", json_encode($users_arr), time() + (60 * 5), "/"); //set cookies after updated array which converted to json 
                //     // }
                // }



    ?> 
</body>
</html>