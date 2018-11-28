<?php
require "common.php";
require "db_init.php";

make_header("Product");
?>

<main class="product-container">
    <!-- Left Column / Headphones Image -->
    <div class="left-column">
        <img data-image="black" src="<?php echo $_GET["image"]?>" alt="<?php echo $_GET["name"]?>">
    </div>
    <!-- Right Column -->
    <div class="right-column">
        <!-- Product Description -->
        <div class="product-description">
            <h1><?php echo $_GET["name"]?></h1>
            <div class="description-point">
                <span>Velikost: <?php echo $_GET["size"]?></span><br>
            </div>
            <div class="description-point">
                <span>Vyrobce: <?php echo $_GET["manufacter"]?></span><br>
            </div>
            <div class="description-point">
                <span>Material: <?php echo $_GET["material"]?></span><br>
            </div>
            <!-- Product Pricing -->
            <div class="product-price">
                <span>Cena: <?php echo $_GET["price"]?> kč</span>
            </div>
            <div class="cart-btn">
                <a href="#"><input type="button" value="Přidat do košíku"></a>
            </div>
        </div>
</main>

<?php
make_footer();
?>
