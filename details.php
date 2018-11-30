<?php
require "common.php";
require "db_init.php";

make_header("Historie");
?>
<h2> Seznam výpůjček</h2>
<?php

if(isset($_SESSION['login'])) {		
	$id = $_SESSION['id'];

$sql = "SELECT * FROM vypujcka where klient = '$id'";
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
}
else {
		echo '<p align ="center">Ještě jste si nic nepůjčili</p>';
	}
}
else{
	echo '<p align="center">Ještě nejste přihlašený</p>';
}
?>


<?php
make_footer();
?>