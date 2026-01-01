<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION["login_user_id"])) {
    header("Location: ./login.php");
    exit();
} else {
    $user_id = $_SESSION["login_user_id"];
}
require_once __DIR__ . "../../constants.php";
require __DIR__ . '../../database/db_connect.php';


// fetching all cart items
$cart_items = $_SESSION["cart"] ?? [];

if (empty($cart_items)) {
    $products = [];
} else {
    $all_product_ids = array_keys($cart_items);
    $placeholder = array_fill(0, count($all_product_ids), "?");
    $placeholder = implode(",", $placeholder);

    $product_sql = "SELECT * FROM product WHERE p_id IN ($placeholder)";
    $product_stmt = $conn->prepare($product_sql);
    $product_stmt->execute($all_product_ids);
    $products = $product_stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($products as &$product) {
        $product["quantity"] = $cart_items[$product["p_id"]];
        $product["subtotal"] = $product["quantity"] * $product["price"];
    }

    $product_json = json_encode($products);

    echo var_dump($product_json);

}


?>


<script>
    // const plus = document.getElementsByClassName("plus");
    //     const minus = document.getElementsByClassName("minus");
    //     const quantity = document.getElementsByClassName("quantity");

    //     console.log(plus);


    //     plus.addEventListener('click', function(event) {
    //         event.preventDefault();
    //         let num = Number(quantity.textContent);
    //         quantity.textContent = num + 1;
    //     })

    //     minus.addEventListener('click', function(event) {
    //         event.preventDefault();
    //         let num = Number(quantity.textContent);
    //         quantity.textContent = num - 1;
    //     })

    //     quantity.addEventListener('change', function(){
    //         setTimeout(() => {
    //             const formData = new FormData();
    //             formData.append("quantity", Number(quantity.textContent));
    //             formData.append("product_id", )

    //             const req = new XMLHttpRequest();
    //             req.open("POST", "./cart/update_cart.php");
    //             req.send(formData);
    //         }, 1000);
    //     })
</script>

<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<style>
    .dropdown-submenu {
        position: relative;
    }

    .dropdown-submenu>.dropdown-menu {
        top: 0;
        left: 100%;
        margin-left: .1rem;
    }

    .dropdown-submenu:hover>.dropdown-menu {
        display: block;
    }
</style>

<body>

    <div class="container-fluid m-0 p-0">
        <!-- navbar -->
        <!-- <nav class="navbar navbar-expand-lg bg-body-tertiary mb-3">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                        <a class="nav-link" href="#">Features</a>
                        <a class="nav-link" href="#">Pricing</a>
                        <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                    </div>
                </div>
            </div>
        </nav> -->

        <?php require '../user/components/user_navbar.php'; ?>

        <!-- listing all products -->
        <div class="products container">
            <div class="row">
                <div class="col-7">
                    <div class="row mt-3 mb-3">
                        <div class="col col-md-8">
                            <h1>Cart Items</h1>
                        </div>
                    </div>
                    <?php if (empty($products)) { ?>
                        <div>
                            No products in the cart
                        </div>
                    <?php } else { ?>
                        <?php foreach ($products as $p) { ?>
                            <div class="card mb-3" style="max-width: 540px;">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="<?php echo $p["image"] ?>" class="img-fluid rounded-start h-100" alt="..." width="200px">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <!-- <input type="checkbox" class="selcted_product" name="selected_product" checked> -->
                                            <h5 class="card-title"><?php echo $p["product_name"] ?></h5>
                                            <p class="card-text">Price : <?php echo $p["price"] ?></p>
                                            <p class="card-text">Quantity :
                                                <button class="btn btn-primary btn-sm plus" data-id="<?php echo $p["p_id"] ?>">&plus;</button>
                                                <span id="quantity-<?php echo $p["p_id"] ?>"><?php echo $p["quantity"] ?></span>
                                                <button class="btn btn-primary btn-sm minus" data-id="<?php echo $p["p_id"] ?>">&minus;</button>
                                            </p>
                                            <p class="card-text">Subtotal : <span id="subtotal-<?php echo $p["p_id"] ?>"><?php echo $p["subtotal"] ?></span></p>
                                            <button class="btn btn-primary" onclick="remove_product(event, <?php echo $p['p_id'] ?>)">Remove Product</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>

                </div>
                <div class="col-5">
                    <div class="row mt-3 mb-3">
                        <div class="col col-md-6">
                            <h3>Total</h3>
                        </div>
                        <div class="col col-md-6">
                            <button class="btn btn-sm btn-primary" onclick="clear_cart(event)">Clear cart</button>
                        </div>
                    </div>
                    <div class="row">
                        <h4 id="total">
                            <?php
                            $sum = 0;
                            foreach ($products as $p) {
                                $sum += $p["subtotal"];
                            }
                            echo $sum;
                            ?>
                        </h4>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-success" onclick="checkout(event)">checkout</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- </div> -->



    <script>
        console.log(document.querySelectorAll(".plus, .minus"));
        document.querySelectorAll('.plus, .minus').forEach((btn) => {
            btn.addEventListener('click', function() {
                let action = btn.classList.contains("plus") ? "increase" : "decrease";

                const product_id = btn.dataset.id;

                let formData = new FormData();
                formData.append("action", action);
                formData.append("product_id", product_id);

                const req = new XMLHttpRequest();
                req.open("POST", "./cart/update_cart.php");
                req.send(formData);

                req.addEventListener("load", function() {
                    const data = JSON.parse(this.responseText);
                    console.log(data);
                    if (data.quantity == 0) {
                        location.reload();
                    }
                    document.getElementById(`quantity-${product_id}`).textContent = data.quantity;
                    document.getElementById(`subtotal-${product_id}`).textContent = data.product_total;
                    document.getElementById(`total`).textContent = data.total;
                })
            })
        })


        function remove_product(event, product_id) {

            let formData = new FormData();
            formData.append("product_id", product_id);

            const req = new XMLHttpRequest();
            req.open("POST", "./cart/remove_item_cart.php");
            req.send(formData);

            req.addEventListener("load", function() {
                location.reload();
                alert("Product removed from cart");
            })
        }

        function clear_cart(event) {
            const req = new XMLHttpRequest();
            req.open("GET", "./cart/clear_cart.php");
            req.send();

            req.addEventListener("load", function() {
                location.reload();
                alert("cart is empty");
            })
        }


        function checkout(event) {
            event.preventDefault();
            const req = new XMLHttpRequest();


            // req.open("POST", "./checkout.php");
            // req.send();
            // req.addEventListener('load', function(){
            //     console.log("object");
            // })

            req.open("POST", "./checkout/checkout.php", true);
            req.setRequestHeader('Content-Type', 'application/json');
            req.addEventListener('load', function(){
                window.location = "./checkout/checkout.php";
            })
            req.send(<?php echo $product_json; ?>);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>