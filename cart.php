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

	$wasFound = false;
	$i = 0;
	//if the cart session variable is not set or cart array is empty
	if(!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1){
		// run if the cart is empty or not set
		$_SESSION["cart_array"] = array(1=> array("product_id" => $product_id, "quantity" => 1,
                                                  "name" => $product_name, "price" => $price));
	} else {
		// run if the cart has at least one item in it
		foreach($_SESSION["cart_array"] as $item){
			$i++;
			while (list($key, $value) = each($item)) {
				if ($key == "product_id" && $value == $product_id){
					// that item is in cart already so lets adjust its quantity using array_splice()
					array_splice($_SESSION["cart_array"], $i-1,1,
                        array(array("product_id" => $product_id, "name" => $product_name,
                            "price" => (int)$price * ((int)$item['quantity'] + 1), "quantity" => $item['quantity'] + 1)));
					$wasFound = true;
				}
			}
		}

		if($wasFound == false) {
			array_push($_SESSION["cart_array"], array("product_id" => $product_id, "quantity" => 1,
                "name" => $product_name, "price" => $price));
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
	$i = 0;
	$total_price = 0;
	foreach ($_SESSION["cart_array"] as $item) {
		$i++;
		$id = $item['product_id'];
        $product_name = $item['name'];
        $price = $item['price'];
        $total_price += $price;
        $quantity = $item['quantity'];
		$cartOutput = '<h2> Položka číslo'.$i.'</h2>
                       Nazev :"'.$product_name.'"<br/>
                       Cena :"'.$price.'"<br/>
                       Pocet :"'.$quantity.'ks"<br/>';
        echo $cartOutput;
	}
    echo 'Total price: '.$total_price.'<br/>';
}

// script (if user chooses to empty thier shopping cart)
if(isset($_GET['cmd']) && $_GET['cmd'] == "emptycart"){
	unset($_SESSION["cart_array"]);
    header("Location: /cart.php");
}

if (count($_SESSION['cart_array']) > 0){
    echo '<a align="left" href = "cart.php?cmd=emptycart">Vyprázdnit košík </a>';
}

make_footer();
?>