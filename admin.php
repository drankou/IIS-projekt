<?php
require "common.php";
require "db_init.php";

make_header("Admin");
echo "<h2> Informace o zaměstnancích </h2>";
?>


<?php

if (isset($_GET['removed']) && $_GET['removed'] == "true"){
    echo '<div class="isa_success">Zaměstnanec úspěsně odstraněn</div>';
}


// Select all employee
$sql = "SELECT * FROM ZAMESTNANEC";
$result = mysqli_query($db,$sql) or die(mysqli_error($db));

if (mysqli_num_rows($result) > 0){
 echo '<table class="tbl-cart">
	 	<tr>
		<th width="10%"> ID zamestnance </th>
		<th width="12%">  Jméno </th>
		<th> Příjmení</th>
		<th> Login </th>
		<th> Pozice </th> 
		<th width="12%" > Telefon </th> 
		<th width="10%">  Vyhodit </th>
		</tr>';
        while($row = mysqli_fetch_array($result)) { ?>

        <tr> 
        <td><?php echo $row["id_zamestnance"]; ?></td>
		<td><?php echo $row["jmeno"]; ?></td>
		<td><?php echo $row["prijmeni"]; ?></td>
		<td><?php echo $row["login"]; ?></td>
		<td><?php echo $row["pozice"]; ?></td>
		<td><?php echo $row["telefon"]; ?></td>
		<td> <a href ="admin.php?cmd=remove_employee&id=<?php echo $row["id_zamestnance"];?>" class="btnRemoveAction"><img
                            src="images/icons/icon-delete.png" alt="Remove Employee"/></a></td>
		</tr>


		<?php
            }
            echo "</table>";
        }
        else {
        	echo '<p> Nejsou žádný zaměstnanci</p>';
        }

		// remove employee
        if(isset($_GET['cmd']) && $_GET['cmd'] == "remove_employee"){
        	$remove_id = $_GET['id'];
        	$sql = "DELETE FROM ZAMESTNANEC where id_zamestnance=$remove_id";
        	if (mysqli_query($db, $sql)){
        	    header("Location: admin.php?removed=true");
        	} else {               
        		echo '<div class="isa_error">Nepodarilo se odstranit zamestnance </div>';
        	}
        }

 // ADD employee
	 if (isset($_POST['add_employee'])) {
	    $name = ($_POST['add_name']);
	    $surname = ($_POST['add_surname']);    
	    $position = ($_POST['add_position']);
	    $login = ($_POST['add_login']);
	    $password = ($_POST['add_password']);
	    $number = ($_POST['add_telnumber']); 
		
	    $sql_l = "SELECT * FROM ZAMESTNANEC where login='$login'";
	    $res_l = mysqli_query($db,$sql_l) or die(mysqli_error($db));
		if(mysqli_num_rows($res_l) > 0){     
		echo '<div class="isa_error">
	                     Login je již zabraný </div>';           
	    }    
	   else {
	    $sql = "INSERT INTO ZAMESTNANEC(jmeno, prijmeni, pozice, telefon, login, heslo) VALUES ('$name', '$surname', '$position', '$number', '$login', '$password')";
	    if (mysqli_query($db, $sql)) {
	    	     	 echo '<div class="isa_success">Zamestnanec uspesne pridan </div>';
	                     header("Location: admin.php");
	    } else {
	     			echo '<div class="isa_error">Nepodarilo sa priat zamestnanca skuste to znova </div>';
	    	 }
	    }
	}
?>
		<div class="add-employee">
            <h3> Přidat zaměstnance </h3>
			<form name ="form1" action="admin.php" method="post">
				<table>
					<tr>
						<td>Jméno*</td>
						<td><input type="text" name="add_name" required> </td>
					</tr>
					<tr>
						<td>Příjmení*</td>						
						<td><input type="text" name="add_surname" required> </td>
					</tr>
					<tr>
						<td>Pozice*</td>						
						<td><input type="text" name="add_position" required> </td>
					</tr>
					<tr>
						<td>Login*</td>						
						<td><input type="text" name="add_login" required> </td>
					</tr>
					<tr>
						<td>Heslo*</td>						
						<td><input type="password" name="add_password" required> </td>
					</tr>
					<tr>
						<td>Telefon</td>						
						<td><input type="text" name="add_telnumber" placeholder="+421987654321"> </td>
					</tr>					
					<tr>
						<td colspan="2" align="center"><input type ="submit" name="add_employee" value="Přidat Zaměstnance"></td>
					</tr>	
				</table>
			</form>
		</div>

<?php
mysqli_close($db);
make_footer();
?>