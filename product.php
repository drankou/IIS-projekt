<?php
require "common.php";
require "db_init.php";

if (isset($_POST['image_x'], $_POST['image_y'])) {   //should be this way because of input type="image"
    $product_id = $_POST['product_id'];
    $product_type = $_POST["product_type"];
    $image_src = $_POST['image_src'];
    $product_name = $_POST['product_name'];
    $manufacter = $_POST['manufacter'];
    $material = $_POST['material'];
    $price = $_POST['price'];
    $size = $_POST['size'];
    $manager = $_POST['manager'];
    $color = $_POST['color'];
    $quantity = $_POST['quantity'];

    $sql = "SELECT * FROM VYROBCE WHERE id_vyrobce='$manufacter'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result);
    if (mysqli_num_rows($result) == 1) {
        $manufacter = $row['nazev_firmy'];
    }

}

make_header($product_name);
?>

<main class="product-container">
    <div class="left-column">
        <img src="<?php echo $image_src?>" alt="<?php echo $product_name?>">
    </div>
    <div class="right-column">
        <div class="product-description">
            <h1><?php echo $product_name?></h1>
            <?php
                if ($size != null) {
                    echo '<div class="description-point">
                            <span>Velikost:',$size,'</span><br>
                          </div>';
                }
            ?>
            <div class="description-point">
                <span>Vyrobce: <?php echo $manufacter?></span><br>
            </div>
            <div class="description-point">
                <span>Material: <?php echo $material?></span><br>
            </div>
             <div class="description-point">
                <span>Počet dostupných kusů: <?php echo $quantity?></span><br>
            </div>
            <?php
                if ($product_type == "costumes"){
            ?>
                    <div class="related-products">
                        <?php get_related_products($db,$product_id)?>
                    </div>
            <?php
                } ?>
            <div class="product-price">
                <span>Cena: <?php echo $price?> kč</span>
            </div>
            <div class="cart-btn">
                <form action="cart.php" method="post">
                    <input type="text" name="price" value="<?php echo $price?>" hidden>
                    <input type="text" name="color" value="<?php echo $color?>" hidden>
                    <input type="text" name="product_name" value="<?php echo $product_name?>" hidden>
                    <input type="text" name="product_id" value="<?php echo $product_id?>" hidden>
                    <input type="text" name="manufacter" value="<?php echo $manufacter?>" hidden>
                    <input type="text" name="size" value="<?php echo $size?>" hidden>
                    <input type="text" name="manager" value="<?php echo $manager?>" hidden>
                    <input type="text" name="material" value="<?php echo $material?>" hidden>
                    <input type="text" name="image_src" value="<?php echo $image_src?>" hidden>
                    <input type="text" name="product_type" value="<?php echo $product_type?>" hidden>
                    <input type="text" name="quantity" value= "<?php echo $quantity?>" hidden>

                    <input type="submit" value="Přidat do košíku">
                </form>
            </div>
        </div>
</main>

<?php
mysqli_close($db);
make_footer();
?>
