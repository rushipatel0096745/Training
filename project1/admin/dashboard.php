<?php  
    session_start();
    if(!isset($_SESSION["admin"])){
        header("Location: login.php");
        exit();
    }

?>

<?php 
    include '../database/db_connect.php';

    $all_users_sql = "SELECT * FROM users";
    $all_users_stmt = $conn->prepare($all_users_sql);
    $all_users_stmt->execute();

    $all_users = $all_users_stmt->fetchAll(PDO::FETCH_ASSOC);


    // inserting user


    




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
   
  </style>
  <body>
    <div class="container-fluid p-0 m-0">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="./profile.php">Home</a>
                        </li>
                    </ul>
                </div>
                <a href="./logout.php">
                    <button type="submit" class="btn btn-primary">Logout</button>
                </a>
            </div>
        </nav>

        <!-- users tables -->

        <div class="container mt-5">
            <div class="row mb-3">
                <div class="col-md-10">
                    <h4>Users table</h4>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#addUser">Add User</button>
                </div>
            </div>

            <!-- Insert Modal -->
            <div class="modal modal-lg fade" id="addUser" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="./add_user.php" method="post" class="row g-3">
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">First name</label>
                            <input type="text" name="first_name" class="form-control" id="">
                        </div>
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Last name</label>
                            <input type="text" name="last_name" class="form-control" id="">
                        </div>
                        <div class="col-md-6">
                            <label for="phone_no" class="form-label">Phone no</label>
                            <input type="text" name="phone_no" class="form-control" id="">
                        </div>
                        <div class="col-md-5">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" name="email" class="form-control" id="">
                        </div>
                        <div class="col-md-5">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="">
                        </div>
                        <div class="col-md-2">
                            <label for="role" class="form-label">Select role</label>
                            <select class="form-select form-select mb-3" name="role">
                                <option value="user">user</option>
                                <option value="staff">staff</option>
                                <option value="accounts">accounts</option>
                                <option value="manager">manager</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
            </div>
            <table class="table table-striped mb-3">
                <thead>
                    <tr>
                        <th scope="col">user_id</th>
                        <th scope="col">First name</th>
                        <th scope="col">Last name</th>
                        <th scope="col">Phone no</th>
                        <th scope="col">email</th>
                        <th scope="col">Role</th>
                        <th scope="col">action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>9846587859</td>
                        <td>email@gmail.com</td>
                        <td>uers</td>
                        <td>
                            <div class="row" style="width: 180px;">
                                <div class="col-sm-6">
                                    <button type="button" class="btn btn-outline-success">Update</button>
                                </div>
                                <div class="col-sm-6">
                                    <button type="button" class="btn btn-outline-danger">Delete</button>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <?php 
                    foreach($all_users as $u){
                    ?>
                    <tr>
                        <td><?php echo $u["user_id"]; ?></td>
                        <td><?php echo $u["first_name"]; ?></td>
                        <td><?php echo $u["last_name"]; ?></td>
                        <td><?php echo $u["phone_no"]; ?></td>
                        <td><?php echo $u["email"]; ?></td>
                        <td><?php echo $u["user_role"]; ?></td>
                        <td><button>Update</button></td>
                        <td>
                            <div class="row">
                                <div class="col-sm-6">
                                    <button type="button" class="btn btn-outline-success">Update</button>
                                </div>
                                <div class="col-sm-6">
                                    <button type="button" class="btn btn-outline-danger">Delete</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php 
                    }?>
                </tbody>
            </table>
        </div>
       
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>