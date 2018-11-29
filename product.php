<?php
require "common.php";
require "db_init.php";

if (isset($_POST['image_x'], $_POST['image_y'])) {   //should be this way because of input type="image"
    $product_id = $_POST['product_id'];
    $image_src = $_POST['image_src'];
    $product_name = $_POST['product_name'];
    $size = $_POST['size'];
    $manufacter = $_POST['manufacter'];
    $material = $_POST['material'];
    $price = $_POST['price'];
    $manager = $_POST['manager'];
    $color = $_POST['color'];
}

make_header($product_name);
?>

<main class="product-container">
    <!-- Left Column / Headphones Image -->
    <div class="left-column">
        <img src="<?php echo $image_src?>" alt="<?php echo $product_name?>">
    </div>
    <!-- Right Column -->
    <div class="right-column">
        <!-- Product Description -->
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
            <!-- Product Pricing -->
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

                    <input type="submit" value="Přidat do košíku">
                </form>
            </div>
        </div>
</main>

<?php
make_footer();
?>
