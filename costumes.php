<?php
require "common.php";
require "db_init.php";

make_header("Kostýmy");
?>

<h2>Kostýmy</h2>
<div class="filterContainer">
    DIFFERENT FILTERS WILL BE HERE
</div>

<div class="row">
    <?php
    $sql = "SELECT * FROM KOSTYM";  //default - show all costumes
    get_products($db, $sql);
    ?>

</div>


<?php
make_footer();
?>

