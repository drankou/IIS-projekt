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
//        db query to get all costumes
//        iterate through costumes and echo html code
//        <div class="column nature">
//        <div class="content">
//            <img src="/images/bart.jpg" alt="Bart" style="width:100%">
//            <h4>Bart Simpson</h4>
//        </div>
//    </div>
//        where src,alt,h4 will change depends on picture
    ?>
    <div class="column">
        <div class="content">
            <img src="/images/costumes/bart.jpg" alt="Bart" style="width:100%">
            <h4>Bart Simpson</h4>
        </div>
    </div>
    <div class="column">
        <div class="content">
            <img src="/images/costumes/kostra.jpg" alt="Kostra" style="width:100%">
            <h4>Kostra</h4>
        </div>
    </div>
    <div class="column">
        <div class="content">
            <img src="/images/costumes/shrek.jpg" alt="Shrek" style="width:100%">
            <h4>Shrek</h4>
        </div>
    </div>
    <div class="column">
        <div class="content">
            <img src="/images/costumes/jahodka.jpg" alt="Jahodka" style="width:100%">
            <h4>Jahodka</h4>
        </div>
    </div>
    <div class="column nature">
        <div class="content">
            <img src="/images/costumes/mimon.jpg" alt="Mimon" style="width:100%">
            <h4>Mimon</h4>
        </div>
    </div>
    <div class="column">
        <div class="content">
            <img src="/images/costumes/carman.jpg" alt="Carman" style="width:100%">
            <h4>Carman</h4>
        </div>
    </div>
</div>


<?php
make_footer();
?>

