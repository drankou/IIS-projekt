<?php
require "common.php";
require "db_init.php";

make_header("Admin");
echo "<h2> Informace o zamestnancoch </h2>";
?>


<?php

// Select all employee
$sql = "SELECT * FROM zamestnanec";
$result = mysqli_query($db,$sql) or die(mysqli_error($db));

if (mysqli_num_rows($result) > 0){
 echo '<table class="tbl-cart">
	 	<tr>
		<th width="10%"> ID zamestanca </th>
		<th width="12%">  Jmeno </th>
		<th> Prijmeni</th>
		<th> Login </th>
		<th> pozice </th> 
		<th width="12%" > telefon </th> 
		<th width="10%">  vyhodit </th>
		</tr>';
        while($row = mysqli_fetch_array($result)) { ?>

        <tr> 
        <td><?php echo $row["id_zamestnance"]; ?></td>
		<td><?php echo $row["jmeno"]; ?></td>
		<td><?php echo $row["prijmeni"]; ?></td>
		<td><?php echo $row["login"]; ?></td>
		<td><?php echo $row["pozice"]; ?></td>
		<td><?php echo $row["telefon"]; ?></td>
		<td> <a href ="admin.php?cmd=remove_employee&id= <?php echo $row["id_zamestnance"];?>" class="btnRemoveAction"><img
                            src="images/icons/icon-delete.png" alt="Remove Employee"/></a></td>
		</tr>


		<?php
            }
            echo "</table>";
        }
        else {
        	echo '<p> Nejsou uz zamestnanci</p>';
        }

		// remove employee
        if(isset($_GET['cmd']) && $_GET['cmd'] == "remove_employee"){
        	$remove_id = $_GET['id'];
        	$sql = "DELETE FROM zamestnanec where id_zamestnance=$remove_id";
        	if (mysqli_query($db, $sql)){
        		echo '<div class="isa_success">
                 <i class="fa fa-times-circle"></i>
                     Podarilo sa odstranit zamestnanca </div>';
                     header("Location: /admin.php?cmd=success");

        	} else {
        		echo '<div class="isa_error">
                 <i class="fa fa-times-circle"></i>
                     Nepodarilo sa odstranit zamestnanca </div>';
        	}

        }

 // ADD employee
	 if (isset($_POST['register_emplo'])) {      
	    $name = ($_POST['add_name']);
	    $surname = ($_POST['add_surname']);    
	    $position = ($_POST['add_position']);
	    $login = ($_POST['add_login']);
	    $password = ($_POST['add_password']);
	    $number = ($_POST['add_telnumber']); 
		
	    $sql_l = "SELECT * FROM zamestnanec where login='$login'";
	    $res_l = mysqli_query($db,$sql_l) or die(mysqli_error($db));
		if(mysqli_num_rows($res_l) > 0){     
		echo '<div class="isa_error">
	                 <i class="fa fa-times-circle"></i>
	                     Login je již zabraný </div>';           
	    }    
	   else {
	    $sql = "INSERT INTO zamestnanec(jmeno, prijmeni, pozice, telefon, login, heslo) VALUES ('$name', '$surname', '$position', '$number', '$login', '$password')";
	    if (mysqli_query($db, $sql)) {
	    	     	 echo '<div class="isa_success">
	                 <i class="fa fa-times-circle"></i>
	                     Zamestnanec uspesne pridan </div>';
	                     header("Location: /admin.php");
	     } else {   
	     			echo '<div class="isa_error">
	                 <i class="fa fa-times-circle"></i>
	                     Nepodarilo sa priat zamestnanca skuste to znova </div>';  	

	    	 }
	    	    	
	    } 
	      
	}


      

?>

<div class ="grid_10">
	<div class = "box round first">
		<h3> Pridat zamestnanca </h3>
		<div class="block">
			<form name ="form1" action="" method="post">
				<table>
					<tr>
						<td>Jmeno*</td>
						<td><input type="text" name="add_name" required> </td>
					</tr>
					<tr>
						<td>Prijmeni*</td>						
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
						<td colspan="2" align="center"><input type ="submit" name= "register_emplo" value="Pridat Zamestnanca"></td>
					</tr>	
				</table>
			</form>
		</div>
	</div>

<?php
make_footer();
?>