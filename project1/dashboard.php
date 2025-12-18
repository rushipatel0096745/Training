<?php  
    // session_start();
    // if(!isset($_SESSION["admin"])){
    //     header("Location: login.php");
    //     exit();
    // }

?>

<?php 
    include './database/db_connect.php';

    $all_admin_users_sql = "SELECT a.admin_id AS admin_id, a.name AS name, a.email AS email, r.role_name AS role FROM admin a JOIN roles r ON a.role_id = r.role_id";
    $all_admin_users_stmt = $conn->prepare($all_admin_users_sql);
    $all_admin_users_stmt->execute();
    $all_admin_users = $all_admin_users_stmt->fetchAll(PDO::FETCH_ASSOC);

    $rolesSql = "SELECT * FROM roles";
    $role_stmt = $conn->prepare($rolesSql);
    $role_stmt->execute();
    $roles = $role_stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!doctype html>
<html lang="en" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
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

        <?php if(isset($_SESSION["success"])){ ?>
                <div class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                        <?php echo $_SESSION["success"]; 
                            unset($_SESSION["success"]);
                        ?>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
        <?php }?>
        

        <!-- admin tables -->

        <div class="container mt-5">
            <div class="row mb-3">
                <div class="col-md-10">
                    <h4>Admin table</h4>
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
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" name="email" class="form-control" id="">
                            </div>
                            <div class="col-md-5">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="">
                            </div>
                            <div class="col-md-2">
                                <label for="role" class="form-label">Select role</label>
                                <select name="role" id="" class="form-select form-select mb-3">
                                    <?php  foreach($roles as $r){?>
                                        <option value="<?php echo $r["role_id"] ?>"><?php echo $r["role_name"] ?></option>
                                    <?php }?>
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

            <!-- delete modal -->
            <div class="modal modal-lg fade" id="deleteUser" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Delete User</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Do you want to delete the user?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cencel</button>
                            <button type="button" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- update modal -->
            <div class="modal modal-lg fade" id="updateUser" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="./update_user.php" method="post" class="row g-3">
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
                        <th scope="col">admin_id</th>
                        <th scope="col">name</th>
                        <th scope="col">email</th>
                        <th scope="col">Role</th>
                        <th scope="col">action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach($all_admin_users as $u){
                    ?>
                    <tr>
                        <td><?php echo $u["admin_id"]; ?></td>
                        <td><?php echo $u["name"]; ?></td>
                        <td><?php echo $u["email"]; ?></td>
                        <td><?php echo $u["role"]; ?></td>
                        <td>
                            <div class="row" style="width: 180px;">
                                <div class="col-sm-6">
                                    <button type="button" class="btn btn-outline-success" onclick="updateUser(<?php echo $u["admin_id"]; ?>)">Update</button>
                                </div>
                                <div class="col-sm-6">
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="" onclick="deleteUser(<?php echo $u["admin_id"]; ?>)">Delete</button>
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

    <script>
        function deleteUser(admin_id){
            console.log("admin_id: ", admin_id);
            if (confirm("Do you want to delete the user ?")){
                window.location = './delete_user.php?id='+admin_id;
            }else {
                return 
            }
        }

        function updateUser(admin_id){
            window.location = './update_user.php?id='+admin_id;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html> 