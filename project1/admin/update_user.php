<?php 

    session_start();
    include '../database/db_connect.php';

    $admin_id = $_GET["id"];
    echo $admin_id;

    try {
        $rolesSql = "SELECT * FROM roles";
        $role_stmt = $conn->prepare($rolesSql);
        $role_stmt->execute();
        $roles = $role_stmt->fetchAll(PDO::FETCH_ASSOC);

        // current user old data 
        $currentDataSql = "SELECT * FROM admin WHERE admin_id = :admin_id";
        $currentDataStmt = $conn->prepare($currentDataSql);
        $currentDataStmt->bindParam(":admin_id", $admin_id);
        $currentDataStmt->execute();
        $currentData = $currentDataStmt->fetchAll(PDO::FETCH_ASSOC);

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            // uopdating data
            $name = $_POST["name"];
            $email = $_POST["email"];
            $role = $_POST["role"];
            $id = $_POST["id"];

            // echo "<br>" . "admin id" . " " . $admin_id . "<br>";
            // echo "name" . " " . $name. "<br>";
            // echo "email" . " " . $email. "<br>";
            // echo "role_id" . " " . $role. "<br>";



            try {
                $updateSql = "UPDATE admin SET name = :name_, email = :email, role_id = :role_ WHERE admin_id = :admin_id";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bindParam(":name_", $name);
                $updateStmt->bindParam(":email", $email);
                $updateStmt->bindParam(":role_", $role);
                $updateStmt->bindParam(":admin_id", $id);
                $updateStmt->execute();    
            } catch (PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }

            $_SESSION["success"] = "Record updated succesfully";
            header("Location: dashboard.php");
            exit();

        }
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    foreach($currentData as $u){
        $oldName = $u["name"];
        $oldEmail = $u["email"];
        $oldRole = $u["role_id"];
    }
?>


<!doctype html>
<html lang="en" data-bs-theme="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>update user</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    </head>
    <body>
        <div class="container d-flex align-items-center justify-content-center vh-100"> 
            <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" class="row">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" value="<?php echo $oldName ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">email</label>
                    <input type="text" class="form-control" name="email" value="<?php echo $oldEmail ?>" id="">
                </div>   
                <div class="mb-3">
                    <label for="role" class="form-label">Select role</label>
                        <select name="role" class="form-select form-select mb-3">
                                <?php  foreach($roles as $r){?>
                                    <option <?php if($r["role_id"] == $oldRole) echo "selected"; ?> value="<?php echo $r["role_id"] ?>"><?php echo $r["role_name"] ?>
                                </option>
                                <?php }?>
                        </select>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <input type="hidden" name="id" value="<?php echo $admin_id ?>">
            </form>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>
