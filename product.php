<?php
require "common.php";
require "db_init.php";

make_header("Product");


if (isset($_POST['image_x'], $_POST['image_y'])) {   //should be this way because of input type="image"
    $product_id = $_POST['product_id'];
    $image_src = $_POST['image_src'];
    $costume_name = $_POST['costume_name'];
    $size = $_POST['size'];
    $manufacter = $_POST['manufacter'];
    $material = $_POST['material'];
    $price = $_POST['price'];
    $manager = $_POST['manager'];
    $color = $_POST['color'];
}
?>

<main class="product-container">
    <!-- Left Column / Headphones Image -->
    <div class="left-column">
        <img src="<?php echo $image_src?>" alt="<?php echo $costume_name?>">
    </div>
    <!-- Right Column -->
    <div class="right-column">
        <!-- Product Description -->
        <div class="product-description">
            <h1><?php echo $costume_name?></h1>
            <div class="description-point">
                <span>Velikost: <?php echo $size?></span><br>
            </div>
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
                <a href="#"><input type="button" value="Přidat do košíku"></a>
            </div>
        </div>
</main>

<?php
make_footer();
?>
