<?php
require "common.php";
require "db_init.php";
//session_start();
make_header("Registrace");

$db = mysqli_connect("localhost", "root", "", "iis");   // zatial tu je localhost databaza

// z formulara na citanie udajov
if (isset($_POST['register_btn'])) {      
    $login = ($_POST['login']);
    $password = ($_POST['password']);    
    $personal_id = ($_POST['personal_id']);
    $name = ($_POST['name']);
    $email = ($_POST['email']);
    $surname = ($_POST['surname']);
    $tel_number = ($_POST['tel_number']);
    $city = ($_POST['city']);
    $address = ($_POST['address']);
    $day1 = strtotime($_POST['birth_date']);
    $day2 = date('Y-m-d', $day1);        
    echo $day2;

    // INSERT udajov do tabulky
    $sql = "INSERT INTO klient(rodne_cislo, jmeno, prijmeni, login, heslo, tel_cislo, ulice, mesto, vek) VALUES ('$personal_id', '$name', '$surname', '$login', '$password', '$tel_number', '$address', '$city', '$day2')";
    mysqli_query($db,$sql);       
}


?>

<div class="registration">
    <form action="registration.php" method="post">
        <label for=login>Login*</label>
        <input type="text" name="login" id="login"><br>

        <label for="password">Heslo*</label>
        <input type="password" name="password" id="password"><br>

        <label for="personal_id">Rodné číslo*</label>
        <input type="text" name="personal_id" id="personal_id"><br>

        <label for="name">Jméno</label>
        <input type="text" name="name" id="name"><br>

        <label for="email">E-mail</label>
        <input type="email" name="email" id="email"><br>

        <label for="surname">Příjmení</label>
        <input type="text" name="surname" id="surname"><br>

        <label for="tel_number">Tel. číslo</label>
        <input type="tel" name="tel_number" id="tel_number"><br>

        <label for="city">Město</label>
        <input type="text" name="city" id="city"><br>

        <label for="address">Adresa</label>
        <input type="text" name="address" id="address"><br>

        <label for="birth_date">Datum narození</label>
        <input type="date" name="birth_date" id="birth_date"><br>

        <input type="submit" name="register_btn" value="Zaregistrovat se">
    </form>
</div>



<?php
make_footer();
?>