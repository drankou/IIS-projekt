<?php
require "common.php";
require "db_init.php";

make_header("Zaměstnanec");
?>


<?php
if(isset($_GET['cmd']) && $_GET['cmd'] == "success") {
    echo '<div class="isa_success">
                     Polozka uspesne smazana</div>';
}
$allowed = array('jpg', 'jpeg', 'png', 'gif');


// INSERT costume not working
if (isset($_POST['add_costume'])) {
    $name = ($_POST['add_cost_name']);
    $color = ($_POST['add_cost_color']);    
    $material = ($_POST['add_cost_material']);
    $size = ($_POST['add_cost_size']);
    $price = ($_POST['add_cost_price']);
    $date = ($_POST['add_cost_date']);
    $employee = ($_POST['add_cost_manager']);
    $maker = ($_POST['add_cost_maker']);
   // $img= ($_POST['add_cost_img']);
    $quantity = ($_POST['add_cost_quantity']);
   
    $fileName =$_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['name'];
    $fileError =$_FILES['file']['error'];
    $fileSize =$_FILES['file']['size'];

    $fileExt = explode('.', $fileName);
    $filesActualExt = strtolower(end($fileExt));    

    if(in_array($filesActualExt, $allowed)){
    	if($fileError === 0){
    		if($fileSize < 1000000){
    			$fileNameNew = uniqid('',true).".".$filesActualExt;
    			
    			echo $fileTmpName;  
    			echo "\n";			

    			$fileDestination = 'images/costumes/'.$fileNameNew;
    			echo $fileDestination;
    			move_uploaded_file($fileTmpName, $fileDestination);
    			echo '<div class="isa_success">
                 	Uspesny upload obrazka </div>';
    		} else{
    			echo '<div class="isa_error">
                     Prilis velkej soubor </div>';
    		}
    	}

    } else {
    	echo '<div class="isa_error">
                 Nepodporovany typ souboru </div>';
    }
    $sql = "INSERT INTO KOSTYM(nazev, barva, velikost, material, cena, datum_vyroby, spravce, vyrobce, filepath, pocet_kusu) VALUES('$name', '$color', '$material', '$price', '$date', '$employee', '$maker', '$fileDestination', '$quantity')";

     if (mysqli_query($db, $sql)) {
     	 echo '<div class="isa_success">
                     Kostym byl uspesne pridan </div>';
     }
     else{
     	 echo '<div class="isa_error">
                     Nepodarilo se pridat kostym skuste to znova </div>';
     }
}

// INSERT accessories not working
if (isset($_POST['add_accessory'])) {
    $name = ($_POST['add_acces_name']);
    $color = ($_POST['add_acces_color']);    
    $material = ($_POST['add_acces_material']);
    $size = ($_POST['add_acces_size']);
    $price = ($_POST['add_acces_price']);
    $date = ($_POST['add_acces_date']);
    $employee = ($_POST['add_acces_manager']);
    $maker = ($_POST['add_acces_make']);
    $img= ($_POST['add_acces_img']);
    $quantity = ($_POST['add_acces_quantity']);

    $fileName =$_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['name'];
    $fileError =$_FILES['file']['error'];
    $fileSize =$_FILES['file']['size'];

    $fileExt = explode('.', $fileName);
    $filesActualExt = strtolower(end($fileExt));
}

// COSTUMES TABLE
echo '<h2> Vypujcky </h2>';
$employee_id = $_SESSION['user_id'];
$sql = "SELECT * FROM VYPUJCKA WHERE spravce = $employee_id";
$result = mysqli_query($db,$sql) or die(mysqli_error($db));

if (mysqli_num_rows($result) > 0){
    echo '<table class="tbl-cart">
	 	<tr>
		<th width="10%"> ID vypujcky </th>
		<th width="30%">  Datum pujceni </th>
		<th width="30%"> Datum vraceni</th>
		<th width="20%"> Klient(login)</th>  
		<th width="10%">  Suma </th>
		<th> Akceptovana </th>
		<th> Prijmout platbu </th>
		</tr>';
    while($row = mysqli_fetch_array($result)) {
        $reservation_id = $row["id_vypujcky"];
        $reserve_date =  $row["datum_pujceni"];
        $return_date = $row["datum_vraceni"];
        $client_id = $row["klient"];
        $total_price = $row["suma"];
        $accepted = $row["accepted"];
        $accepted = $accepted == 1 ? "Ano" : "Ne";

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
            <?php
                if ($accepted == "Ano"){
                    echo '<td>-</td>';
                }else{
                    echo '<td> <a href ="employee.php?cmd=accept&id='.$reservation_id.'" class="btnRemoveAction"><img
                            src="images/icons/icon-accept.png" alt="Accept reservation"/></a></td>';
                }
            ?>

        </tr>
        <?php
    }
    echo "</table>";
}
else {
    echo '<p> Nejsou zadne vypujcky</p>';
}

if (isset($_GET['cmd']) && $_GET['cmd'] == "accept"){
    $reservation_id = $_GET['id'];
    $sql = "UPDATE VYPUJCKA SET accepted=1 WHERE id_vypujcky='$reservation_id'";
    if (!mysqli_query($db, $sql)){
        echo("Error description: " . mysqli_error($db));
    }
    header("location:employee.php");
}


	// COSTUMES TABLE
    echo '<h2> Kostymy </h2>';
    $employee_id = $_SESSION['user_id'];
 	$sql = "SELECT * FROM KOSTYM WHERE spravce = $employee_id";
 	$result = mysqli_query($db,$sql) or die(mysqli_error($db));

if (mysqli_num_rows($result) > 0){
 echo '<table class="tbl-cart">
	 	<tr>
		<th width="10%"> ID kostymu </th>
		<th width="15%">  Nazev </th>
		<th width="30%"> Vyrobce</th>
		<th width="20%"> Spravce </th> 
		<th width="5%" > Pocet kusu </th> 
		<th width="10%">  Cena </th>
		<th width="5%"> Zmazat </th>
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
                echo("Error description: " . mysqli_error($db));
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
		<td> <a href ="employee.php?cmd=remove_costume&id=<?php echo $product_id;?>" class="btnRemoveAction"><img
                            src="images/icons/icon-delete.png" alt="Remove Costume"/></a></td>
		</tr>
		<?php
            }
            echo "</table>";
        }
        else {
        	echo '<p> Nejsou zadne kostymy</p>';
        }


	// ACCESSIORIES TABLE
    echo '<h2> Doplnky </h2>';
 	$sql = "SELECT * FROM DOPLNEK WHERE spravce=$employee_id";
	$result = mysqli_query($db,$sql) or die(mysqli_error($db));

if (mysqli_num_rows($result) > 0){
 echo '<table class="tbl-cart">
	 	<tr>
		<th width="10%"> ID doplnku </th>
		<th width="15%">  Nazev </th>
		<th width="30"> Vyrobce</th>
		<th width="20"> Spravce </th> 
		<th width="5%" > Pocet kusu </th> 
		<th width="10%">  Cena </th>
		<th width="5%"> Kostym </th>
		<th width="5%"> Zmazat </th>
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
        	echo '<p> Nejsou zadne doplnky</p>';
        }

        // DELETE COSTUME

        if(isset($_GET['cmd']) && $_GET['cmd'] == "remove_costume"){
        	$remove_id = $_GET['id'];
        	$sql = "DELETE FROM KOSTYM WHERE id='$remove_id'";
            $result = mysqli_query($db, $sql);
        	if ($result){
        		header("Location: /employee.php?cmd=success");
        	} else {
        		echo '<div class="isa_error">
                     Nepodarilo sa odstranit kostym </div>';
        	}

        }

        // DELETE ACCESORIES
       if(isset($_GET['cmd']) && $_GET['cmd'] == "remove_accessiories"){
        	$remove_id = $_GET['id'];
        	$sql = "DELETE FROM DOPLNEK where id=$remove_id";
        	if (mysqli_query($db, $sql)){        		
        		header("Location: /employee.php?cmd=success");
        	} else {
        		echo '<div class="isa_error">
                     Nepodarilo sa odstranit kostym </div>';
        	}
        }






?>

		<h3> Pridat kostym </h3>
		<div class="add-item">
			<form name ="form1" action="employee.php" method="post" enctype="multipart/form-data">
				<table>
					<tr>
						<td>Nazev kostymu</td>
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
						<td>Datum vyroby</td>						
						<td><input type="date" name="add_cost_date" required> </td>
					</tr>
					<tr>
						<td>Spravce</td>						
						<td><input type="text" name="add_cost_manager" required> </td>
					</tr>	
					<tr>
						<td>Vyrobce</td>						
						<td><input type="text" name="add_cost_maker" required> </td>
					</tr>
					<tr>
						<td>Obrazok</td>						
						<td><input type="file" name="file" id="add_cost_img" required> </td>
					</tr>	
					<tr>
						<td>Pocet kusov</td>						
						<td><input type="text" name="add_cost_quantity" required> </td>
					</tr>
					<tr>
						<td colspan="2" align="center"><input type ="submit" name="add_costume" value="Pridat kostym"></td>
					</tr>	
				</table>
				</form>
		</div>

		<h3> Pridat doplnek </h3>
		<div class="add-item">
			<form name ="form2" action="employee.php" method="post">
				<table >
					<tr>
						<td>Nazev kostymu</td>
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
						<td>Datum vyroby</td>						
						<td><input type="date" name="add_acces_date" required> </td>
					</tr>
					<tr>
						<td>Spravce</td>						
						<td><input type="text" name="add_acces_manager" required> </td>
					</tr>	
					<tr>
						<td>Vyrobce</td>						
						<td><input type="text" name="add_acces_maker" required> </td>
					</tr>
					<tr>
						<td>Priradenie ku kostymu</td>						
						<td><input type="text" name="add_acces_costum" required> </td>
					</tr>
					<tr>
						<td>Obrazok</td>						
						<td><input type="file" name="add_acces_img" required> </td>
					</tr>	
					<tr>
						<td>Pocet kusov</td>						
						<td><input type="text" name="add_acces_quantity" required> </td>
					</tr>
					<tr>
						<td colspan="2" align="center"><input type ="submit" name="add_accessory" value="Pridat Doplnek"></td>
					</tr>	
				</table>
			</form>
		</div>


<?php
make_footer();
?>
