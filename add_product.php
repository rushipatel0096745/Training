<?php 
    session_start();
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
    // echo "products page";    
    require '../database/db_connect.php';
    // $products = [
    //     ["product_name" => "Product1", "category" => "category 1", "price" => 102.00, "image" => "https://picsum.photos/id/237/50/"],
    //     ["product_name" => "Product2", "category" => "category 2", "price" => 110.00, "image" => "https://picsum.photos/id/250/50/"],
    // ];

    // $product_name = "product 1";
    // $price = 100.23;
    // $compare_price = 150.23;
    // $image = "https://picsum.photos/id/237/50/";
    // $description = "description for product 1";

    // fetch all categories
    $cat_sql = "SELECT * FROM category order by c_id";
    $cat_stmt = $conn->prepare($cat_sql);
    $cat_stmt->execute();
    $categories = $cat_stmt->fetchAll(PDO::FETCH_ASSOC);

    // insert into product category table
    //$product_category = [1,2]; // contains category id
    
    $product_name = $price = $compare_price = $image = $description = "";
    $product_category = [];
    $p_nameErr = $catErr = $priceErr = $comparePriceErr = $descriptionErr = $imageErr = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $cats = $_POST["categories"];
        foreach($cats as $c){
            echo $c . "<br>";
        }

        if(empty($_POST["product_name"])){
            $p_nameErr = "Enter the product name";
        } else {
            $product_name = $_POST["product_name"]; 
        }
        if(empty($_POST["categories"])){
            $catErr = "select the category";
        } else {
            $product_category = $_POST["categories"];
        }
        if(empty($_POST["price"])){
            $priceErr = "Enter the price";
        } else {
            $price = (float)$_POST["price"]; 
        }
        if(empty($_POST["compare_price"])){
            $comparePriceErr = "Enter the compare price";
        } else {
            $compare_price = $_POST["compare_price"]; 
        }
        if(empty($_POST["image"])){
            $imageErr = "Enter the image url";
        } else {
            $image = $_POST["image"]; 
        }
        if(empty($_POST["description"])){
            $descriptionErr = "Enter the description";
        } else {
            $description = $_POST["description"]; 
        }


        if($p_nameErr == "" and $catErr == "" and $priceErr = "" and $comparePriceErr = "" and $imageErr = "" and $descriptionErr = "" ){
            // insert into product table
            $insert_product_sql = "INSERT INTO product (product_name, price, compare_price, image, description) VALUES (?,?,?,?,?)";
            $insert_product_stmt = $conn->prepare($insert_product_sql);
            $insert_product_stmt->execute([$product_name, floatval($price), floatval($compare_price), $image, $description]);
            $product_id = $conn->lastInsertId();
    
            foreach($product_category as $pc){
                // insert into product category table
                $insert_pc_sql = "INSERT INTO product_category (p_id, c_id) VALUES (?, ?)";
                $insert_pc_stmt = $conn->prepare($insert_pc_sql);
                $insert_pc_stmt->execute([$product_id, $pc]);
            }
        }

    }
?>

<!doctype html>
<html lang="en" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>
    <div class="container d-flex align-items-center justify-content-center vh-100"> 
                <div class="card">
                    <div class="card-header">
                        Add Product
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>" onsubmit="return submitHandler(event)">

                            <label for="product_name">Product name</label>
                            <input type="text" name="product_name" class="form-control mb-2 req">
                            <div class="text-danger"><?php echo $p_nameErr?></div>
                            
                            <label for="category">Categories</label>
                            <?php foreach($categories as $cat){?>
                                <div class="form-check mt-2">
                                    <input class="form-check-input req" type="checkbox" name="categories[]" value="<?php echo $cat["c_id"] ?>">
                                    <label class="form-check-label"><?php echo $cat["category_name"] ?></label>
                                </div>
                                <div class="text-danger"><?php echo $catErr?></div>
                            <?php }?>


                            <label for="price">Price</label>
                            <input type="text" name="price" class="form-control mb-2 req">
                            <div class="text-danger"><?php echo $priceErr?></div>


                            <label for="compare_price">Compare Price</label>
                            <input type="text" name="compare_price" class="form-control mb-2 req">
                            <div class="text-danger"><?php echo $comparePriceErr?></div>


                            <label for="image">Image url</label>
                            <input type="text" name="image" class="form-control mb-2 req">
                            <div class="text-danger"><?php echo $imageErr?></div>
                            

                            <label for="description">Description</label>
                            <textarea class="form-control req" name="description"></textarea>
                            <div class="text-danger"><?php echo $descriptionErr?></div>

                            <!-- <div class="text-danger"><?php  // echo $errMsg; ?></div> -->
                            <input type="submit" class="btn btn-primary mt-3"></input>
                        </form>
                    </div>
                </div>
    </div>
    <script></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>