<?php 
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);

    require '../database/db_connect.php';
    // echo "products page";    
    // $products = [
    //     ["product_name" => "Product1", "category" => "category 1", "price" => 102.00, "image" => "https://picsum.photos/id/237/50/"],
    //     ["product_name" => "Product2", "category" => "category 2", "price" => 110.00, "image" => "https://picsum.photos/id/250/50/"],
    // ];

    // retrive all product details
    $sql = "
        SELECT P.product_name AS product_name, P.price AS price, P.compare_price AS compare_price, P.image AS image, P.description AS description, GROUP_CONCAT(C.category_name) AS 'categories'
        FROM product P 
        JOIN product_category PC ON P.p_id = PC.p_id 
        JOIN category C ON C.c_id = PC.c_id
        GROUP BY P.p_id
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $all_products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach($all_products as $p){
        echo "product name: " . "" .$p["product_name"];
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
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
                            <a class="nav-link active" aria-current="page" href="./dashboard.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="./products/products.php">Products</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <a href="../profile.php">
                        <button type="submit" class="btn btn-primary">Profile</button>
                    </a>
                    <a href="./logout.php">
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </a>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="row mt-3 mb-3">
                <div class="col col-md-9">
                    <h1>Products</h1>
                </div>
                <div class="col col-md-3">
                    <button class="btn btn-primary" onclick="window.location = './add_product.php'">Add Product</button>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-3">
                    <?php foreach($all_products as $p){?>
                        <div class="col">
                            <div class="card h-100">
                                <img src="<?php echo $p["image"] ?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $p["product_name"]; ?></h5>
                                    <p class="card-text"><strong>Categories:</strong> <?php echo $p["categories"]; ?></p>
                                    <p class="card-text"><strong>Description:</strong> <?php echo $p["description"]; ?></p>
                                    <p class="card-text"><strong>Price: </strong><?php echo $p["price"]; ?>&#8377  <span class="text-decoration-line-through"><?php echo $p["compare_price"]; ?>&#8377 </span></p>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>


  