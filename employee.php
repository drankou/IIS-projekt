<?php
require "common.php";
require "db_init.php";

make_header("Zaměstnanec");
?>


<?php
$allowed = array('jpg', 'jpeg', 'png', 'gif');


// INSERT costume not working
if (isset($_POST['register_cost'])) {      
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
                 	<i class="fa fa-times-circle"></i>
                     Uspesny upload obrazka </div>';
    		} else{
    			echo '<div class="isa_error">
                 <i class="fa fa-times-circle"></i>
                     Prilis velkej soubor </div>';
    		}
    	}

    } else {
    	echo '<div class="isa_error">
                 <i class="fa fa-times-circle"></i>
                     Nepodporovany typ souboru </div>';
    }
    $sql = "INSERT INTO KOSTYM(nazev, barva, velikost, material, cena, datum_vyroby, spravce, vyrobce, filepath, pocet_kusu) VALUES('$name', '$color', '$material', '$price', '$date', '$employee', '$maker', '$fileDestination', '$quantity')";

     if (mysqli_query($db, $sql)) {
     	 echo '<div class="isa_success">
                 <i class="fa fa-times-circle"></i>
                     Kostym byl uspesne pridan </div>';
     }
     else{
     	 echo '<div class="isa_error">
                 <i class="fa fa-times-circle"></i>
                     Nepodarilo se pridat kostym skuste to znova </div>';
     }

   

    }

// INSERT accessories not working
if (isset($_POST['register_acces'])) {      
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
    echo '<h2> Kostymy </h2>';
 	$sql = "SELECT * FROM KOSTYM";
	$result = mysqli_query($db,$sql) or die(mysqli_error($db));

if (mysqli_num_rows($result) > 0){
 echo '<table class="tbl-cart">
	 	<tr>
		<th width="10%"> ID kostymu </th>
		<th width="12%">  Nazev </th>
		<th> Vyrobce</th>
		<th> Spravce </th> 
		<th width="12%" > Pocet kusu </th> 
		<th width="10%">  Cena </th>
		<th width="10%"> Zmazat </th>
		</tr>';
        while($row = mysqli_fetch_array($result)) { ?>

        <tr> 
        <td><?php echo $row["id"]; ?></td>
        <td><?php echo $row["nazev"]; ?></td>
		<td><?php echo $row["vyrobce"]; ?></td>
		<td><?php echo $row["spravce"]; ?></td>
		<td><?php echo $row["pocet_kusu"]; ?></td>
		<td><?php echo $row["cena"]; ?></td>
		<td> <a href ="employee.php?cmd=remove_costume&id=<?php echo $row["id"];?>" class="btnRemoveAction"><img
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
 	$sql = "SELECT * FROM DOPLNEK";
	$result = mysqli_query($db,$sql) or die(mysqli_error($db));

if (mysqli_num_rows($result) > 0){
 echo '<table class="tbl-cart">
	 	<tr>
		<th width="10%"> ID doplnku </th>
		<th width="12%">  Nazev </th>
		<th> Vyrobce</th>
		<th> Spravce </th> 
		<th width="12%" > Pocet kusu </th> 
		<th width="10%">  Cena </th>
		<th> Kostym </th>
		<th width="10%"> Zmazat </th>
		</tr>';
        while($row = mysqli_fetch_array($result)) { ?>

        <tr> 
        <td><?php echo $row["id"]; ?></td>
        <td><?php echo $row["nazev"]; ?></td>
		<td><?php echo $row["vyrobce"]; ?></td>
		<td><?php echo $row["spravce"]; ?></td>
		<td><?php echo $row["pocet_kusu"]; ?></td>
		<td><?php echo $row["cena"]; ?></td>
		<td><?php echo $row["kostym"]; ?></td>

		<td> <a href ="employee.php?cmd=remove_accessiories&id=<?php echo $row["id"];?>" class="btnRemoveAction"><img
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
        	$sql = "DELETE FROM KOSTYM where id=$remove_id";
        	if (mysqli_query($db, $sql)){        		
        		header("Location: /employee.php?cmd=success");

        	} else {
        		echo '<div class="isa_error">
                 <i class="fa fa-times-circle"></i>
                     Nepodarilo sa odstranit kostym </div>';
        	}

        }

        // DELETE ACCESORIES
       if(isset($_GET['cmd']) && $_GET['cmd'] == "remove_accessiories"){
        	$remove_id = $_GET['id'];
        	$sql = "DELETE FROM DOPLNEK where id=$remove_id";
        	if (mysqli_query($db, $sql)){        		
        		header("Location: /employee.php");
        	} else {
        		echo '<div class="isa_error">
                 <i class="fa fa-times-circle"></i>
                     Nepodarilo sa odstranit kostym </div>';
        	}

        }







?>


<div class ="grid_10">
	<div class = "box round first">
		<h3> Pridat kostym </h3>
		<div class="block">
			<form name ="form1" action="" method="post" enctype="multipart/form-data">
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
						<td colspan="2" align="center"><input type ="submit" name= "register_cost" value="Pridat kostym"></td>
					</tr>	
				</table>
				</form>
		</div>
	</div>

</div>

<div class ="grid_10">
	<div class = "box round first">
		<h3> Pridat doplnek </h3>
		<div class="block">
			<form name ="form2" action="" method="post">
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
						<td colspan="2" align="center"><input type ="submit" name= "register_acces" value="Pridat Doplnek"></td>
					</tr>	
				</table>
			</form>
		</div>
	</div>


<?php
make_footer();

//    elseif ($_SESSION['user'] == "employee") {
//        //display all proccesed orders by employee
//        $login = $_SESSION['login'];
//        $sql = "SELECT * FROM ZAMESTNANEC WHERE login='$login'";
//
//        $result = mysqli_query($db, $sql);
//        $row = mysqli_fetch_array($result);
//        $employee_id = $row['id_zamestnance'];
//    }

?>
