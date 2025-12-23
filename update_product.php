<?php
    session_start();

?>

<?php 
    $product_id = intval($_GET["p_id"]);

    
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
    require '../database/db_connect.php';
    echo "product_id: " . " " . $product_id;

    // fetch all categories
    $cat_sql = "SELECT * FROM category order by c_id";
    $cat_stmt = $conn->prepare($cat_sql);
    $cat_stmt->execute();
    $categories = $cat_stmt->fetchAll(PDO::FETCH_ASSOC);

    // fetch the current value
    $curre_sql = "SELECT * FROM product WHERE p_id = ?";
    $curr_stmt = $conn->prepare($curre_sql);
    $curr_stmt->execute([$product_id]);
    $current_data = $curr_stmt->fetchAll(PDO::FETCH_ASSOC);

    // echo var_dump($current_data) . "<br>";
    $product_name = $price = $compare_price = $image = $description = "";
    $existing_category = [];

    $exist_cat_sql = "SELECT c_id FROM product_category WHERE p_id = ?";
    $exist_cat_stmt = $conn->prepare($exist_cat_sql);
    $exist_cat_stmt->execute([$product_id]);
    $exist_cat = $exist_cat_stmt->fetchAll(PDO::FETCH_ASSOC);
   
    foreach($exist_cat as $c){
        $existing_category[] = $c["c_id"];
    }

    // echo var_dump($existing_category);

    foreach($current_data as $cd){
        $product_name = $cd["product_name"];
        $price = $cd["price"];
        $compare_price = $cd["compare_price"];
        $image = $cd["image"];
        $description = $cd["description"]; 
    }

    // echo "product name: " . $current_data[0]["product_name"];
    
    $p_nameErr = $catErr = $priceErr = $comparePriceErr = $descriptionErr = $imageErr = "";


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $p_id = intval($_POST["p_id"]);

        echo "p_id: " . $p_id;
        // foreach($cats as $c){
        //     echo $c . "<br>";
        // }

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

        echo "product name: " . $product_name . "<br>";
        echo "product price: " . $price . "<br>";
        echo "product cprice: " . $compare_price . "<br>";
        echo "product image: " . $image . "<br>";
        echo "product description: " . $description . "<br>";
        echo var_dump($product_category);


        if($p_nameErr == "" and $catErr == "" and $priceErr == "" and $comparePriceErr == "" and $imageErr == "" and $descriptionErr == "" and empty($p_id)){

            try {
                // upadate into products table
                $update_sql = "UPDATE product SET product_name = ?, price = ?, compare_price = ?, image = ?, description = ? WHERE p_id = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->execute([$product_name, floatval($price), floatval($compare_price), $image, $description, $p_id]);
    
                // delete exisiting categories for product in product_category table
                $delete_sql = "DELETE FROM product_category WHERE p_id = ?";
                $delete_stmt = $conn->prepare($delete_sql);
                $delete_stmt->execute([$p_id]);
    
                // insert new selected categories
                foreach($product_category as $pc){
                    // insert into product category table
                    echo "pc: " . $pc;  
                    $insert_pc_sql = "INSERT INTO product_category (p_id, c_id) VALUES (?, ?)";
                    $insert_pc_stmt = $conn->prepare($insert_pc_sql);
                    $insert_pc_stmt->execute([$p_id, intval($pc)]);
                }
    
                $_SESSION["success"] = "Product updated successfully";
                header("Location: products.php");
                exit();
            } catch (PDOException $e) {
                echo "<br>" . $e->getMessage();
            }
        }
    }
?>


<!doctype html>
<html lang="en" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>
    <div class="container d-flex align-items-center justify-content-center vh-100"> 
                <div class="card">
                    <div class="card-header">
                        Update Product
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>" onsubmit="return submitHandler(event)">

                            <label for="product_name">Product name</label>
                            <input type="text" name="product_name" class="form-control mb-2 req" value="<?php echo $product_name ?>">
                            <div class="text-danger"><?php echo $p_nameErr?></div>
                            
                            <label for="category">Categories</label>
                            <?php foreach($categories as $cat){?>
                                <div class="form-check mt-2">
                                    <input class="form-check-input req" type="checkbox" name="categories[]" 
                                            value="<?php echo $cat["c_id"] ?>" <?php echo in_array($cat["c_id"], $existing_category) ? 'checked' : ' ';?>>
                                    <label class="form-check-label"><?php echo $cat["category_name"] ?></label>
                                    <div class="text-danger"><?php echo $catErr?></div>
                                </div>
                            <?php }?>

                            <label for="price">Price</label>
                            <input type="text" name="price" class="form-control mb-2 req" value="<?php echo $price ?>">
                            <div class="text-danger"><?php echo $priceErr?></div>


                            <label for="compare_price">Compare Price</label>
                            <input type="text" name="compare_price" class="form-control mb-2 req" value="<?php echo $compare_price ?>">
                            <div class="text-danger"><?php echo $comparePriceErr?></div>


                            <label for="image">Image url</label>
                            <input type="text" name="image" class="form-control mb-2 req" value="<?php echo $image ?>">
                            <div class="text-danger"><?php echo $imageErr?></div>
                            

                            <label for="description">Description</label>
                            <textarea class="form-control req" name="description"><?php echo $description ?></textarea>
                            <div class="text-danger"><?php echo $descriptionErr?></div>

                            <!-- <div class="text-danger"><?php  // echo $errMsg; ?></div> -->
                            <input type="hidden" name="p_id" value="<?php echo $product_id ?>">
                            <input type="submit" class="btn btn-primary mt-3"></input>
                        </form>
                    </div>
                </div>
    </div>
    <script src="validation.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>