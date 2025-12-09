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
    if($num){
        function isPrime($n){
            for ($i=2; $i < $n ; $i++) { 
                if($n % $i == 0){
                    return false;
                }
            }
            return true;
        }
    
        $a = isPrime($num);
        // echo "$a";
        if($a == true){
            echo "$num is a prime";
        }
        else {
            echo "$num is not a prime";
        }
    }
   
    $arr = [
        "email1@gmail.com"=>"password1",
        "email2@gmail.com" => "password2"
    ];
    $arr2 = [
        "email3@gmail.com"=>"password3",
        "email4@gmail.com" => "password4"
    ];

    $arr += $arr2;
    $result = json_encode($arr);
    echo "$result";
   

       
    ?> 
</body>
</html>