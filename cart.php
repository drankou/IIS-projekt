<?php
require "common.php";
require "db_init.php";

make_header("Košík");
?>
<h1 align="center"> Košík </h1>


<?php
// Script for shopping cart
if(isset($_POST['pid'])){
	$pid = $_POST['pid'];
	$wasFound = false;
	$i = 0;
	//if the cart session variable is not set or cart array is empty
	if(!isset($_SESSION["cart_array"]) || count(["cart_array"]) < 1){

		// run if the cart is empty or not set
		$_SESSION["cart_array"] = array(1=> array("id_kostymu" => $pid, "quantity" => 1));
	} else {
		// run if the cart has at least one item in it
		foreach($_SESSION["cart_array"] as $each_item){
			$i++;
			while (list($key, $value) = each($each_item)) {
				if ($key == "id_kostymu" && $value == $pid){
					// that item is in cart already so lets adjust its quantity using array_splice()
					array_splice($_SESSION["cart_array"], $i-1,1, array(array("id_kostymu" => $pid, "quantity" => $each_item['quantity'] +1)));
					$wasFound = true;
				} // close if
			} // close while
		} // close foreach

		if($wasFound == false) {
			array_push($_SESSION["cart_array"], array("id_kostymu" => $pid, "quantity" => 1));
		}
	}
}
?>

<?php
//script for render the cart for the user to view
$cartOutput = "";
if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1){
	$cartOutput = "<h2 align 'center'> Košík je prázdný</h2>";
} else {
	$i = 0;
	foreach ($_SESSION["cart_array"] as $each_item) {
		$i++;
		$id_kostymu = $each_item['id_kostymu'];
		$sql = mysql_query("SELECT * FROM KOSTYM WHERE id= '$id_kostymu' LIMIT 1");
		while ($row = mysql_fetch_array($sql)) {
			$costume_name = $row["nazev"];
			$price = $row["cena"];
		}
		$cartOutput = "<h2> Položka číslo $i</h2>";
		$cartOutput = "ID kostymu:" . $each_item['id_kostymu']. "<br/>";
		$cartOutput = "Nazev kostymu:" . $costume_name. "<br/>";
		$cartOutput = "Cena kostymu:" . $price. "<br/>";		
	}
}
?>

<?php
// script (if user chooses to empty thier shopping cart)
if(isset($_GET['cmd']) && $_GET['cmd'] == "emptycart"){
	unset($_SESSION["cart_array"]);
}
?>

<?php echo $cartOutput; ?>
<a align="left" href = "cart.php?cmd=emptycart">Vyprázdnit košík </a>

<?php
make_footer();
?>