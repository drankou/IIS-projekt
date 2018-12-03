<?php
require "common.php";
require "db_init.php";

make_header("Uvodní strana");
?>

<div class="homepage">
<img src="images/icons/homepage.jpg" alt="Homepage">
<p>Vítejte v půjčovně kostýmů. V Brně sídlí již od roku 1985.
    Jedná se o nejstarší půjčovnu kostýmů v Brně. V naší půjčovně najdete nejnovější a trendy kostýmy.
    Stejně si u nás můžete půjčit také doplňky ke kostýmům jako například masku, meč a podobně.
    V současnosti máme i informačný systém pro pohodlnou rezervaci z domova.
    Tak neváhejte a zpestřete vaši oslavu kostýmem!.</p>
</div>	

<?php
mysqli_close($db);
make_footer();
?>

