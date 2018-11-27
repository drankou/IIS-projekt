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
    $result = mysqli_query($db, $sql);


    if (mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            $costume_name = $row["nazev"];
            $price = $row["cena"];
            $image = $row["filepath"];

            echo '<div class="column">
                    <div class="content">
                        <img src='.$image.' alt='.$costume_name.'style="width:100%">
                        <div class="product_info">
                            <h4>'.$costume_name.'</h4>
                            <h4>Cena: '.$price.'</h4>
                        </div>
                    </div>
                  </div>';
        }
    }else{
        echo 'Sorry, no costumes available.';
    }
    ?>

</div>


<?php
make_footer();
?>

