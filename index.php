<?php
require "common.php";
require "db_init.php";

make_header("Uvodní strana");
?>

<p>Obsah uvodni stranky.</p>


<?php
mysqli_close($db);
make_footer();
?>

