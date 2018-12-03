<?php
require "common.php";
require "db_init.php";

make_header("Historie");
?>
    <h2> Seznam výpůjček</h2>
<?php

if (isset($_POST['reserve-btn'])){
    $client_id = $_SESSION['user_id'];
    $total_price = $_POST['total_price'];
    $rent_date = $_POST['rent_date'];
    $return_date = $_POST['return_date'];

    $employees = [];
    $sql = "SELECT * FROM ZAMESTNANEC";
    $result = mysqli_query($db, $sql);
    while($row = mysqli_fetch_array($result)){
        array_push($employees, $row['id_zamestnance']);
    }

    $employee_id = $employees[array_rand($employees)];

    $sql = "INSERT INTO VYPUJCKA(suma, datum_pujceni, datum_vraceni, spravce, klient) 
    VALUES ('$total_price', '$rent_date', '$return_date', '$employee_id', '$client_id')";

    if (!mysqli_query($db, $sql)){
        echo("Error description: " . mysqli_error($db));
        echo '<div class="isa_error">
                <p>Omlouváme se, nastala interní chyba. Zkuste znovu pozdějí</p>
              </div>';
    }
    $order_id = mysqli_insert_id($db);  //get primary_key of last inserted row

    foreach ($_SESSION['cart_array'] as $item){
        $product_type = $item['type'];
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        if ($product_type == "costumes"){
            $sql = "INSERT INTO DODANI_KOSTYMU(vypujcka, kostym, pocet_kusu) VALUES ('$order_id', '$product_id', '$quantity')";
            if (!mysqli_query($db, $sql)){
                echo '<div class="isa_error">
                     Chyba </div>';
            }

            $sql = "UPDATE KOSTYM SET pocet_kusu=pocet_kusu -'$quantity' WHERE id='$product_id'";
            if (!mysqli_query($db, $sql)){
                echo '<div class="isa_error">
                     Chyba </div>';
            }
        }else if ($product_type == "accessories"){
            $sql = "INSERT INTO DODANI_DOPLNKU(vypujcka, doplnek, pocet_kusu) VALUES ('$order_id', '$product_id', '$quantity')";
            if (!mysqli_query($db, $sql)){
                echo '<div class="isa_error">
                     Chyba </div>';;
            }
            $sql = "UPDATE DOPLNEK SET pocet_kusu=pocet_kusu -'$quantity' WHERE id='$product_id'";
            if (!mysqli_query($db, $sql)){
                echo '<div class="isa_error">
                     Chyba </div>';
            }
        }
    }

    $_SESSION['cart_array'] = [];   //clear cart
}

echo '<div class="isa_success">
        Objednávka proběhla úspěšně
      </div>';

echo '<div>
    <a href="client.php"><button>Prohlédnout seznam rezervaci</button></a>
</div>';
?>


<?php
mysqli_close($db);
make_footer();
?>