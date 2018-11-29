<?php
require "common.php";
require "db_init.php";

make_header("Doplňky");
?>

<h2>Doplňky</h2>

<?php
    $max_price = isset($_POST['max-price']) ? $_POST['max-price'] : 3000;
    $min_price = isset($_POST['min-price']) ? $_POST['min-price'] : 0;

    filterContainer($min_price, $max_price, "accessories.php");
?>

<div class="row">
    <?php
        if (isset($_POST['search_btn'])){
            $max_price = $_POST['max-price'];
            $min_price = $_POST['min-price'];
            $sql = "SELECT * FROM DOPLNEK WHERE cena BETWEEN '$min_price' AND '$max_price'";
        }else {
            $sql = "SELECT * FROM DOPLNEK";  //default - show all accessories
        }
        get_products($db, $sql, "accessories");
    ?>
</div>

<?php
make_footer();
?>
