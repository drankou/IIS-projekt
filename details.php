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
    $employee_id = 1; //maybe add function to randomly choose employee for processing order

    $sql = "INSERT INTO VYPUJCKA(suma, datum_pujceni, datum_vraceni, spravce, klient) 
    VALUES ('$total_price', '$rent_date', '$return_date', '$employee_id', '$client_id')";

    if (!mysqli_query($db, $sql)){
        echo("Error description: " . mysqli_error($db));
    }
    $order_id = mysqli_insert_id($db);  //get primary_key of last inserted row

    foreach ($_SESSION['cart_array'] as $item){
        $product_type = $item['type'];
        $product_id = $item['product_id'];
        if ($product_type == "costumes"){
            $sql = "INSERT INTO DODANI_KOSTYMU(vypujcka, kostym) VALUES ('$order_id', '$product_id')";
            if (!mysqli_query($db, $sql)){
                echo("Error description: " . mysqli_error($db));
            }
        }else if ($product_type == "accessories"){
            $sql = "INSERT INTO DODANI_DOPLNKU(vypujcka, doplnek) VALUES ('$order_id', '$product_id')";
            if (!mysqli_query($db, $sql)){
                echo("Error description: " . mysqli_error($db));
            }
        }
    }

    $_SESSION['cart_array'] = [];   //clear cart
}

if(isset($_SESSION['login'])) {
    if ($_SESSION['user'] == "client"){
        $id = $_SESSION['user_id'];

        $sql = "SELECT * FROM VYPUJCKA WHERE klient='$id'";
        $result = mysqli_query($db, $sql);

        if (mysqli_num_rows($result) > 0){
            echo '<table class="tbl-cart">
	 	<tr>
		<th> ID výpůjčky </th>
		<th> Datum výpůjčky </th>
		<th> Datum vracení </th>
		<th> Správce </th> 
		<th> Suma </th> 
		</tr>';
            while($row = mysqli_fetch_array($result)) {
                echo "<tr>
		<td>". $row["id_vypujcky"] ."</td>
		<td>". $row["datum_pujceni"]. "</td>
		<td>". $row["datum_vraceni"] . "</td>
		<td>". $row["spravce"] . "</td>
		<td>". $row["suma"]. "</td>
		</tr>";

            }
            echo "</table>";
        } else {
            echo '<p align ="center">Ještě jste si nic nepůjčili</p>';
        }
    } elseif ($_SESSION['user'] == "zamestnanec"){
        //display all proccesed orders by employee
        $login = $_SESSION['login'];
        $sql = "SELECT * FROM ZAMESTNANEC WHERE login='$login'";

        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_array($result);

        $employee_id = $row['id_zamestnance'];
    } elseif ($_SESSION['user'] == "admin"){
        //display list of employees
    }
}
else{
	echo '<p align="center">Ještě nejste přihlašený</p>';
}
?>


<?php
make_footer();
?>