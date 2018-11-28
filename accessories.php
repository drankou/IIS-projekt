<?php
require "common.php";
require "db_init.php";

make_header("Doplňky");
?>

<h2>Doplňky</h2>
<div class="filterContainer">
    DIFFERENT FILTERS WILL BE HERE
</div>


<div class="row">
    <?php
        $sql = "SELECT * FROM DOPLNEK";  //default - show all accessories
        get_products($db, $sql);
    ?>
</div>

<?php
make_footer();
?>
