<?php
require "common.php";
require "db_init.php";
//session_start();
make_header("Registrace");

//$db = mysqli_connect("localhost", "root", "", "iis");   // zatial tu je localhost databaza

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
    $birthdate = strtotime($_POST['birth_date']);

    //compute age from birth date
    $adjust = (date("md") >= date("md", $birthdate)) ? 0 : -1;
    $years = date("Y") - date("Y", $birthdate);
    $age = $years + $adjust;

     //INSERT udajov do tabulky
    $sql = "INSERT INTO KLIENT(rodne_cislo, login, heslo, jmeno, prijmeni, tel_cislo, ulice, mesto, vek) VALUES ('$personal_id', '$login', '$password', '$name', '$surname', '$tel_number', '$address', '$city', '$age')";
    if (mysqli_query($db, $sql)) {
        echo '<div class="registration">
                <h4>Jste uspesne zaregistrovan. Muzete se prihlasit</h4>
                <form action="login.php" method="post">
                    <label for="login">Login</label>
                    <input type="text" name="login" id="login"><br>
            
                    <label for="password">Heslo</label>
                    <input type="password" name="password" id="password"><br>
            
                    <input type="submit" name="login_btn" value="Přihlasit se">
                </form>
              </div>';
    } else {    //TODO error message handling using error_no(same name, duplicity and so on)
                //print out message to user and ask to try again
        echo "Error: " . $sql . "<br>" . mysqli_errno($db);
        echo '<div class="registration">
                <h4>Behem registrace vznikla chyba. Zkuste znovu.</h4>  //example of message
                <form action="registration.php" method="post">
                    <label for=login>Login*</label>
                    <input type="text" name="login" id="login" required><br>
            
                    <label for="password">Heslo*</label>
                    <input type="password" name="password" id="password" required><br>
            
                    <label for="personal_id">Rodné číslo*</label>
                    <input type="text" name="personal_id" id="personal_id" placeholder="123456/7890" required><br>
            
                    <label for="name">Jméno</label>
                    <input type="text" name="name" id="name"><br>
            
                    <label for="surname">Příjmení</label>
                    <input type="text" name="surname" id="surname"><br>
            
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email"><br>
            
            
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
              </div>';
    }
} else{
    echo '<div class="registration">
    <form action="registration.php" method="post">
        <label for=login>Login*</label>
        <input type="text" name="login" id="login" required><br>

        <label for="password">Heslo*</label>
        <input type="password" name="password" id="password" required><br>

        <label for="personal_id">Rodné číslo*</label>
        <input type="text" name="personal_id" id="personal_id" placeholder="123456/7890" required><br>

        <label for="name">Jméno</label>
        <input type="text" name="name" id="name"><br>

        <label for="surname">Příjmení</label>
        <input type="text" name="surname" id="surname"><br>

        <label for="email">E-mail</label>
        <input type="email" name="email" id="email"><br>


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
</div>';
}
?>

<?php
make_footer();
?>