<?php
require "common.php";
require "db_init.php";
make_header("Košík");
echo '<h1 align="center"> Košík </h1>';
// Script for shopping cart
if(isset($_POST['product_id'])){
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $image_src = $_POST['image_src'];
    $product_type = $_POST['product_type'];
    $wasFound = false;
    $i = 0;
    //if the cart session variable is not set or cart array is empty
    if(!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1){
        // run if the cart is empty or not set
        $_SESSION["cart_array"] = array(0=> array("product_id" => $product_id, "quantity" => 1, "type" => $product_type,
                                                  "name" => $product_name, "price" => $price, "image" => $image_src));
    } else {
        // run if the cart has at least one item in it
        foreach($_SESSION["cart_array"] as $item){
            $i++;
            while (list($key, $value) = each($item)) {
                if ($key == "product_id" && $value == $product_id){
                    // that item is in cart already so lets adjust its quantity and price using array_splice()
                    array_splice($_SESSION["cart_array"], $i-1,1,
                        array(array("product_id" => $product_id, "name" => $product_name, "image" => $image_src, "type" => $product_type,
                            "price" => (int)$price * ((int)$item['quantity'] + 1), "quantity" => $item['quantity'] + 1)));
                    $wasFound = true;
                }
            }
        }
        if($wasFound == false) {
            array_push($_SESSION["cart_array"], array("product_id" => $product_id, "quantity" => 1, "type" => $product_type,
                "name" => $product_name, "price" => $price, "image" => $image_src));
        }
    }
}
if (count($_SESSION['cart_array']) == 0){
    echo '<h3 align="left"> Košík je prázdný </h3>';
}
//script for render the cart for the user to view
$cartOutput = "";
if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1){
    $cartOutput = "<h2 align='center'> Košík je prázdný</h2>";
} else {
    echo '<table class="tbl-cart">
            <tbody>
            <tr>
                <th>Název</th>
                <th width="20%">ID produktu</th>
                <th width="20%">Počet kusu</th>
                <th width="15%">Cena</th>
                <th width="5%">Smazat</th>       
            </tr>';
    $i = 0;
    $total_price = 0;
    foreach ($_SESSION["cart_array"] as $item) {
        $i++;
        $id = $item['product_id'];
        $product_name = $item['name'];
        $price = $item['price'];
        $total_price += $price;
        $quantity = $item['quantity'];
        ?>
        <tr>
<!--            <img src="--><?php //echo $item["image_src"]; ?><!--" class="cart-item-image"/>-->
            <td><?php echo $item["name"]; ?></td>
            <td><?php echo $id; ?></td>
            <td><?php echo $item["quantity"]; ?></td>
            <td><?php echo $item["price"]." kč"; ?></td>
            <td><a href="cart.php?cmd=remove_item&id=<?php echo $item["product_id"]; ?>" class="btnRemoveAction"><img
                            src="images/icons/icon-delete.png" alt="Remove Item"/></a></td>
        </tr>
        <?php
    }
    ?>
            </tbody>
        </table>
<!--        echo 'Total price: ' . $total_price . '<br/>';-->
        <div class="cart-total-price">
            <span>Celková suma: <?php echo $total_price;?> kč</span>
        </div>
    <?php if(isset($_SESSION['login'])) { ?>
        <div class="cart-date-range">
            <form method="post" action="reservation.php">
                <label for="rent_date">Datum půjčení</label>
                <input type="date" name="rent_date" id="rent_date" value="<?php echo date("Y-m-d"); ?>"><br>
                <label for="return_date">Datum vrácení</label>
                <input type="date" name="return_date" id="return_date" value="<?php echo date("Y-m-d"); ?>"><br>
                <input type="number" name="total_price" value="<?php echo $total_price ?>" hidden>

                <input type="submit" name="reserve-btn" value="Objednat">
            </form>
        </div>

        <?php
    }
}
// script (if user chooses to empty their shopping cart)
if(isset($_GET['cmd']) && $_GET['cmd'] == "empty_cart"){
    //unset($_SESSION["cart_array"]);
    $_SESSION["cart_array"] = array();
    header("Location: cart.php");
}elseif (isset($_GET['cmd']) && $_GET['cmd'] == "remove_item"){
    $remove_id = $_GET['id'];
    $i = 0;
    foreach($_SESSION["cart_array"] as $item){
        if ($item['product_id'] == $remove_id){
            $key = array_search($item, $_SESSION["cart_array"]);
            if ($item['quantity'] > 1) {
//
                $quantity = $_SESSION["cart_array"][$key]["quantity"];
                $price = $_SESSION["cart_array"][$key]["price"];
                $_SESSION["cart_array"][$key]["quantity"] -= 1;
                $_SESSION["cart_array"][$key]["price"] = $price/$quantity * $_SESSION["cart_array"][$key]["quantity"] ;
            }else{
                if (count($_SESSION['cart_array']) == 1){
                    $_SESSION["cart_array"] = array();
                }else{
                    unset($_SESSION["cart_array"][$key]);
                }
            }
            header("Location: cart.php");
        }
    }
}
if (count($_SESSION['cart_array']) > 0){
    ?>
    <div class="cart-btn-container">
        <div class="cart-clear-btn">
            <a href = "cart.php?cmd=empty_cart"><button type="button">Vyprázdnit košík</button></a>
        </div>
    </div>
<?php
}
mysqli_close($db);
make_footer();
?>