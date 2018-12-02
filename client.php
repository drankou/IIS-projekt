<?php
require "common.php";
require "db_init.php";

make_header("Historie");
?>
<h2> Seznam výpůjček</h2>
<?php

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
                $reservation_id = $row["id_vypujcky"];
                $reserve_date = $row["datum_pujceni"];
                $return_date = $row["datum_vraceni"];
                $employee_id = $row["spravce"];
                $total_price = $row["suma"];

                $sql = "SELECT jmeno,prijmeni FROM ZAMESTNANEC WHERE id_zamestnance = $employee_id";
                $tmp_result = mysqli_query($db, $sql);
                $tmp_row = mysqli_fetch_array($tmp_result);
                $employee_name = $tmp_row['jmeno'].' '.$tmp_row['prijmeni'];

                echo "<tr>
                        <td>". $reservation_id ."</td>
                        <td>". $reserve_date ."</td>
                        <td>". $return_date ."</td>
                        <td>". $employee_name ."</td>
                        <td>". $total_price ."</td>
                      </tr>";

            }
            echo "</table>";
        } else {
            echo '<p align ="center">Ještě jste si nic nepůjčili</p>';
        }
    }
}
else{
	echo '<p align="center">Ještě nejste přihlašený</p>';
}
?>


<?php
make_footer();
?>