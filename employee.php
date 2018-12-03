<?php
require "common.php";
require "db_init.php";

make_header("Zaměstnanec");
?>


<?php
if(isset($_GET['status']) && $_GET['status'] == "success") {
    echo '<div class="isa_success">Polozka uspesne smazana</div>';
} elseif (isset($_GET['status']) && $_GET['status'] == "returned"){
    echo '<div class="isa_success">Zbozi uspesne vraceno</div>';
}
$allowed = array('jpg', 'jpeg', 'png', 'gif');

// COSTUMES TABLE
echo '<h2> Vypujcky </h2>';
$employee_id = $_SESSION['user_id'];
$sql = "SELECT * FROM VYPUJCKA WHERE spravce = $employee_id ORDER BY id_vypujcky DESC";
$result = mysqli_query($db,$sql) or die(mysqli_error($db));

if (mysqli_num_rows($result) > 0){
    echo '<table class="tbl-cart">
	 	<tr>
		<th width="10%"> ID výpůjčky </th>
		<th width="30%">  Datum půjčení </th>
		<th width="30%"> Datum vrácení</th>
		<th width="20%"> Klient(login)</th>  
		<th width="10%">  Suma </th>
		<th> Akceptována </th>
		<th> Zboží vráceno </th>
		<th> Přijmout platbu </th>
		<th> Potvrdit vrácení</th>
		</tr>';
    while($row = mysqli_fetch_array($result)) {
        $reservation_id = $row["id_vypujcky"];
        $reserve_date =  $row["datum_pujceni"];
        $return_date = $row["datum_vraceni"];
        $client_id = $row["klient"];
        $total_price = $row["suma"];
        $accepted = $row["accepted"];
        $returned = $row["returned"];
        $accepted = $accepted == 1 ? "Ano" : "Ne";
        $returned = $returned == 1 ? "Ano" : "Ne";

        $sql = "SELECT * FROM KLIENT WHERE rodne_cislo ='$client_id'";
        $tmp_result = mysqli_query($db, $sql);
        $row = mysqli_fetch_array($tmp_result);
        $client = $row['login'];
        ?>
        <tr>
            <td><?php echo $reservation_id; ?></td>
            <td><?php echo $reserve_date; ?></td>
            <td><?php echo $return_date; ?></td>
            <td><?php echo $client; ?></td>
            <td><?php echo $total_price; ?></td>
            <td><?php echo $accepted; ?></td>
            <td><?php echo $returned; ?></td>
            <?php
                if ($accepted == "Ano"){
                    echo '<td>-</td>';
                }else{
                    echo '<td> <a href ="employee.php?cmd=accept&id='.$reservation_id.'" class="btnRemoveAction"><img
                            src="images/icons/icon-accept.png" alt="Accept reservation"/></a></td>';
                }

                if ($returned == "Ano" || $accepted == "Ne"){
                    echo '<td>-</td>';
                }else{
                    echo '<td><a href ="employee.php?cmd=return&id='.$reservation_id.'" class="btnRemoveAction"><img
                                src="images/icons/icon-return.png" alt="Return product"/></a></td>';
                }
            ?>

        </tr>
        <?php
    }
    echo "</table>";
}
else {
    echo '<p> Nejsou žádné výpůjčky</p>';
}

if (isset($_GET['cmd']) && $_GET['cmd'] == "accept"){
    $reservation_id = $_GET['id'];
    $sql = "UPDATE VYPUJCKA SET accepted=1 WHERE id_vypujcky='$reservation_id'";
    if (!mysqli_query($db, $sql)){
        echo '<div class="isa_error">Chyba</div>';
    }
    header("location:employee.php");
}

if (isset($_GET['cmd']) && $_GET['cmd'] == "return"){
    $reservation_id = $_GET['id'];

    $sql = "SELECT * FROM VYPUJCKA WHERE id_vypujcky='$reservation_id'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result);
    $return_date = strtotime($row['datum_vraceni']);
    $today = time();

    $date_diff = floor(($today - $return_date) / (60 * 60 * 24));

    if ($date_diff > 0){
        //pokuta
        $sql = "UPDATE VYPUJCKA SET pokuta=50*$date_diff WHERE id_vypujcky='$reservation_id'";
        if (!mysqli_query($db, $sql)){
            echo '<div class="isa_error">Chyba</div>';
        }
    }
    //compare return_date vs today
    //if > then pokuta = 5%*cena * days
    //else pokuta = 0


    $sql = "UPDATE VYPUJCKA SET returned=1 WHERE id_vypujcky='$reservation_id'";
    if (!mysqli_query($db, $sql)){
        echo '<div class="isa_error">Chyba</div>';
    }

    //Returning accessory quantity
    $sql = "SELECT doplnek,pocet_kusu FROM DODANI_DOPLNKU WHERE vypujcka='$reservation_id'";
    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)) {
            $product_id = $row["doplnek"];
            $quantity = $row['pocet_kusu'];

            $sql = "UPDATE DOPLNEK SET pocet_kusu=pocet_kusu + '$quantity' WHERE id='$product_id'";
            if (!mysqli_query($db, $sql)){
                echo '<div class="isa_error">Chyba</div>';
            }
        }
    }

    //Returning costume quantity
    $sql = "SELECT kostym,pocet_kusu FROM DODANI_KOSTYMU WHERE vypujcka='$reservation_id'";
    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)) {
            $product_id = $row["kostym"];
            $quantity = $row['pocet_kusu'];

            $sql = "UPDATE KOSTYM SET pocet_kusu=pocet_kusu + '$quantity' WHERE id='$product_id'";
            if (!mysqli_query($db, $sql)){
                echo '<div class="isa_error">Chyba </div>';
            }
        }
    }

    //header("location:employee.php?status=returned");
}


	// COSTUMES TABLE
    echo '<h2> Kostýmy </h2>';
    $employee_id = $_SESSION['user_id'];
 	$sql = "SELECT * FROM KOSTYM WHERE spravce = $employee_id";
 	$result = mysqli_query($db,$sql) or die(mysqli_error($db));

if (mysqli_num_rows($result) > 0){
 echo '<table class="tbl-cart">
	 	<tr>
		<th width="10%"> ID kostýmu </th>
		<th width="15%">  Název </th>
		<th width="30%"> Výrobce</th>
		<th width="20%"> Správce </th> 
		<th width="5%" > Počet kusu </th> 
		<th width="10%">  Cena </th>
		<th width="5%"> Smazat </th>
		</tr>';
        while($row = mysqli_fetch_array($result)) {
            $product_id = $row["id"];
            $name =  $row["nazev"];
            $manufacter = $row["vyrobce"];
            $employee_id = $row['spravce'];
            $quantity = $row["pocet_kusu"];
            $price = $row["cena"];

            $sql = "SELECT jmeno,prijmeni FROM ZAMESTNANEC WHERE id_zamestnance='$employee_id'";
            $tmp_result = mysqli_query($db, $sql);
            $row = mysqli_fetch_array($tmp_result);
            $employee_name = $row['jmeno'].' '.$row['prijmeni'];
            if ($employee_name == " "){
                $employee_name = "Undefined";
            }

            $sql = "SELECT * FROM VYROBCE WHERE id_vyrobce='$manufacter'";
            $tmp_result = mysqli_query($db, $sql);
            if (!$tmp_result){
                echo '<div class="isa_error">
                     Chyba </div>';
            }
            $row = mysqli_fetch_array($tmp_result);
            $firm = $row['nazev_firmy'].'('.$row['stat_firmy'].')';
            if ($firm == '()'){
                $firm = "Unknown";
            }

            ?>
        <tr> 
        <td><?php echo $product_id; ?></td>
        <td><?php echo $name; ?></td>
		<td><?php echo $firm; ?></td>
		<td><?php echo $employee_name; ?></td>
		<td><?php echo $quantity; ?></td>
		<td><?php echo $price; ?></td>
		<td> <a href ="employee.php?cmd=remove_costume&id=<?php echo $product_id;?>"><img
                            src="images/icons/icon-delete.png" alt="Remove Costume"/></a></td>
		</tr>
		<?php
            }
            echo "</table>";
        }
        else {
        	echo '<p> Nejsou žádné kostýmy</p>';
        }


	// ACCESSIORIES TABLE
    echo '<h2> Doplňky </h2>';
 	$sql = "SELECT * FROM DOPLNEK WHERE spravce=$employee_id";
	$result = mysqli_query($db,$sql) or die(mysqli_error($db));

if (mysqli_num_rows($result) > 0){
 echo '<table class="tbl-cart">
	 	<tr>
		<th width="10%"> ID doplňku </th>
		<th width="15%">  Název </th>
		<th width="30"> Výrobce</th>
		<th width="20"> Správce </th> 
		<th width="5%" > Počet kusu </th> 
		<th width="10%">  Cena </th>
		<th width="5%"> Kostým </th>
		<th width="5%"> Smazat </th>
		</tr>';
        while($row = mysqli_fetch_array($result)) {
            $product_id = $row["id"];
            $name =  $row["nazev"];
            $manufacter = $row["vyrobce"];
            $employee_id = $row['spravce'];
            $quantity = $row["pocet_kusu"];
            $price = $row["cena"];
            $related_costume = $row['kostym'];

            $sql = "SELECT jmeno,prijmeni FROM ZAMESTNANEC WHERE id_zamestnance='$employee_id'";
            $tmp_result = mysqli_query($db, $sql);
            $row = mysqli_fetch_array($tmp_result);
            $employee_name = $row['jmeno'].' '.$row['prijmeni'];
            if ($employee_name == " "){
                $employee_name = "Undefined";
            }

            $sql = "SELECT * FROM VYROBCE WHERE id_vyrobce='$manufacter'";
            $tmp_result = mysqli_query($db, $sql);
            $row = mysqli_fetch_array($tmp_result);
            $firm = $row['nazev_firmy'].'('.$row['stat_firmy'].')';
            if ($firm == '()'){
                $firm = "Unknown";
            }
            ?>

        <tr> 
        <td><?php echo $product_id; ?></td>
        <td><?php echo $name; ?></td>
		<td><?php echo $firm; ?></td>
		<td><?php echo $employee_name; ?></td>
		<td><?php echo $quantity; ?></td>
		<td><?php echo $price; ?></td>
		<td><?php echo $related_costume; ?></td>

		<td> <a href ="employee.php?cmd=remove_accessiories&id=<?php echo $product_id;?>" class="btnRemoveAction"><img
                            src="images/icons/icon-delete.png" alt="Remove Accessories"/></a></td>
		</tr>
		<?php
            }
            echo "</table>";
        }
        else {
        	echo '<p> Nejsou žádné doplňky</p>';
        }

        // DELETE COSTUME

        if(isset($_GET['cmd']) && $_GET['cmd'] == "remove_costume"){
        	$remove_id = $_GET['id'];
        	$sql = "DELETE FROM KOSTYM WHERE id='$remove_id'";
            $result = mysqli_query($db, $sql);
        	if ($result){
        		header("Location: employee.php?status=success");
        	} else {
        		echo '<div class="isa_error">
                     Nepodarilo sa odstranit kostým </div>';
        	}

        }

        // DELETE ACCESORIES
       if(isset($_GET['cmd']) && $_GET['cmd'] == "remove_accessiories"){
        	$remove_id = $_GET['id'];
        	$sql = "DELETE FROM DOPLNEK where id=$remove_id";
        	if (mysqli_query($db, $sql)){        		
        		header("Location: employee.php?status=success");
        	} else {
        		echo '<div class="isa_error">
                     Nepodarilo sa odstranit doplňek </div>';
        	}
        }


// INSERT costume working, file is uploaded to server using http post
if (isset($_POST['add_costume'])) {
    $name = ($_POST['add_cost_name']);
    $color = ($_POST['add_cost_color']);
    $material = ($_POST['add_cost_material']);
    $size = ($_POST['add_cost_size']);
    $price = ($_POST['add_cost_price']);
    $date = ($_POST['add_cost_date']);
    $employee = ($_POST['add_cost_manager']);
    $maker = ($_POST['add_cost_maker']);
    $quantity = ($_POST['add_cost_quantity']);

    $fileName =$_FILES['file']['name'];
    $fileError =$_FILES['file']['error'];
    $fileSize =$_FILES['file']['size'];

    $fileExt = strtolower(end(explode('.', $fileName)));

    if(in_array($fileExt, $allowed)){
        if($fileError === 0){
            if($fileSize < 1000000){
                $fileNameNew = uniqid('',true).".".$fileExt;
                $target_dir = "images/costumes/";
                $target_file = $target_dir . basename($fileNameNew);

                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    echo '<div class="isa_success">The file '. basename($_FILES["file"]["name"]) . 'has been uploaded.</div>';
                }
            } else{
                echo '<div class="isa_error">Příliš velkej soubor </div>';
            }
        }
    } else {
        echo '<div class="isa_error">Nepodporovaný typ souboru </div>';
    }
    $sql = "INSERT INTO KOSTYM(nazev, barva, velikost, material, cena, datum_vyroby, spravce, vyrobce, filepath, pocet_kusu) VALUES('$name', '$color', '$size', '$material', '$price', '$date', '$employee', '$maker', '$target_file', '$quantity')";

    if (mysqli_query($db, $sql)) {
        echo '<div class="isa_success">Kostym byl úspěšně přidán </div>';
    }
    else{
        echo '<div class="isa_error">Nepodařilo se pridat kostým, skuste to znovu </div>';
    }
}


// INSERT accessories not working
if (isset($_POST['add_accessory'])) {
    $name = $_POST['add_acces_name'];
    $color = $_POST['add_acces_color'];
    $material = $_POST['add_acces_material'];
    $size = $_POST['add_acces_size'];
    $price = $_POST['add_acces_price'];
    $date = $_POST['add_acces_date'];
    $employee = $_POST['add_acces_manager'];
    $maker = $_POST['add_acces_make'];
    $quantity = $_POST['add_acces_quantity'];
    $related_costume = $_POST['add_acces_costum'];

    $fileName =$_FILES['file']['name'];
    $fileError =$_FILES['file']['error'];
    $fileSize =$_FILES['file']['size'];

    $fileExt = strtolower(end(explode('.', $fileName)));

    if(in_array($fileExt, $allowed)){
        if($fileError === 0){
            if($fileSize < 1000000){
                $fileNameNew = uniqid('',true).".".$fileExt;
                $target_dir = "images/accessories/";
                $target_file = $target_dir . basename($fileNameNew);

                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    echo '<div class="isa_success">The file '. basename($_FILES["file"]["name"]) . 'has been uploaded.</div>';
                }
            } else{
                echo '<div class="isa_error">Příliš velkej soubor </div>';
            }
        }
    } else {
        echo '<div class="isa_error">Nepodporovaný typ souboru </div>';
    }

    $sql = "INSERT INTO DOPLNEK(nazev, barva, material, cena, datum_vyroby, spravce, vyrobce, filepath, pocet_kusu, kostym) VALUES('$name', '$color', '$material', '$price', '$date', '$employee', '$maker', '$target_file', '$quantity', $related_costume)";

    if (mysqli_query($db, $sql)) {
        echo '<div class="isa_success">Doplněk byl úspěšně přidán </div>';
    }
    else{
        echo '<div class="isa_error">Nepodařilo se pridat doplněk, skuste to znovu </div>';
    }
}




?>
<div class="add-product-container">
    <div class="add-item">
        <h3> Přidat kostým </h3>
        <form name ="form1" action="employee.php" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Název kostymu</td>
                    <td><input type="text" name="add_cost_name" required> </td>
                </tr>
                <tr>
                    <td>Barva</td>
                    <td><input type="text" name="add_cost_color" required> </td>
                </tr>
                <tr>
                    <td>Velikost</td>
                    <td><input type="text" name="add_cost_size" required> </td>
                </tr>
                <tr>
                    <td>Material</td>
                    <td><input type="text" name="add_cost_material" required> </td>
                </tr>
                <tr>
                    <td>Cena</td>
                    <td><input type="text" name="add_cost_price" required> </td>
                </tr>
                <tr>
                    <td>Datum výroby</td>
                    <td><input type="date" name="add_cost_date" required> </td>
                </tr>
                <tr>
                    <td>Správce</td>
                    <td><input type="text" name="add_cost_manager" required> </td>
                </tr>
                <tr>
                    <td>Výrobce</td>
                    <td><input type="text" name="add_cost_maker" required> </td>
                </tr>
                <tr>
                    <td>Obrázek</td>
                    <td><input type="file" name="file" id="add_cost_img" required> </td>
                </tr>
                <tr>
                    <td>Počet kusu</td>
                    <td><input type="text" name="add_cost_quantity" required> </td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><input type ="submit" name="add_costume" value="Pridat kostym"></td>
                </tr>
            </table>
        </form>
    </div>
    <div class="add-item">
        <h3> Pridat doplněk </h3>
        <form name ="form2" action="employee.php" method="post">
            <table >
                <tr>
                    <td>Název doplňku</td>
                    <td><input type="text" name="add_acces_name" required> </td>
                </tr>
                <tr>
                    <td>Barva</td>
                    <td><input type="text" name="add_acces_color" required> </td>
                </tr>
                <tr>
                    <td>Velikost</td>
                    <td><input type="text" name="add_acces_size" required> </td>
                </tr>
                <tr>
                    <td>Material</td>
                    <td><input type="text" name="add_acces_material" required> </td>
                </tr>
                <tr>
                    <td>Cena</td>
                    <td><input type="text" name="add_acces_price" required> </td>
                </tr>
                <tr>
                    <td>Datum výroby</td>
                    <td><input type="date" name="add_acces_date" required> </td>
                </tr>
                <tr>
                    <td>Správce</td>
                    <td><input type="text" name="add_acces_manager" required> </td>
                </tr>
                <tr>
                    <td>Výrobce</td>
                    <td><input type="text" name="add_acces_maker" required> </td>
                </tr>
                <tr>
                    <td>Přiřazení ke kostýmu</td>
                    <td><input type="text" name="add_acces_costum" required> </td>
                </tr>
                <tr>
                    <td>Obrázek</td>
                    <td><input type="file" name="add_acces_img" required> </td>
                </tr>
                <tr>
                    <td>Počet kusu</td>
                    <td><input type="text" name="add_acces_quantity" required> </td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><input type ="submit" name="add_accessory" value="Pridat Doplněk"></td>
                </tr>
            </table>
        </form>
    </div>
</div>



<?php
mysqli_close($db);
make_footer();
?>
