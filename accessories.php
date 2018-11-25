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
            <img src="/images/accessories/mec.jpg" alt="Mec" style="width:100%">
            <h4>Meč</h4>
        </div>
    </div>
    <div class="column">
        <div class="content">
            <img src="/images/accessories/gloves.jpg" alt="Gloves" style="width:100%">
            <h4>Gloves</h4>
        </div>
    </div>
    <div class="column">
        <div class="content">
            <img src="/images/accessories/long_gloves.jpg" alt="Long Gloves" style="width:100%">
            <h4>Long Gloves</h4>
        </div>
    </div>
    <div class="column">
        <div class="content">
            <img src="/images/accessories/koruna.jpg" alt="Koruna" style="width:100%">
            <h4>Koruna</h4>
        </div>
    </div>
    <div class="column nature">
        <div class="content">
            <img src="/images/accessories/mask.jpg" alt="Maska" style="width:100%">
            <h4>Maska</h4>
        </div>
    </div>
</div>

<?php
make_footer();
?>
