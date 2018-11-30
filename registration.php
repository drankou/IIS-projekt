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
    

    //select for login
    $sql_l = "SELECT * FROM klient where login='$login'";
    //select for email
    $sql_e = "SELECT * FROM klient where email ='$email'";
    //select for personal id
    $sql_i = "SELECT * FROM klient where rodne_cislo = '$personal_id'";
    //result for earch select
    $res_l = mysqli_query($db,$sql_l) or die(mysqli_error($db));
    $res_e = mysqli_query($db,$sql_e) or die(mysqli_error($db));
    $res_i = mysqli_query($db,$sql_i) or die(mysqli_error($db));

    if(mysqli_num_rows($res_l) > 0){        
        header('location:registration.php?signup=login');     
    } else if (mysqli_num_rows($res_e) > 0){        
        header('location:registration.php?signup=email');        
    } else if (mysqli_num_rows($res_i) > 0) {        
        header('location:registration.php?signup=id');
    } else {



     //INSERT udajov do tabulky
     $sql = "INSERT INTO KLIENT(rodne_cislo, login, heslo, jmeno, prijmeni, tel_cislo, ulice, mesto, vek, email) VALUES ('$personal_id', '$login', '$password', '$name', '$surname', '$tel_number', '$address', '$city', '$age', '$email')";
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
            
                    <label for="email">E-mail*</label>
                    <input type="email" name="email" id="email" required><br>
            
            
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
}} else{
    // Warnings when personal id, email or login exist   
    $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];    
    if (strpos($url,'login') !== false) {         
         echo '<div class="isa_error">
                 <i class="fa fa-times-circle"></i>
                     Login je již zabraný </div>';
    }else if (strpos($url,'email') !== false) {         
         echo '<div class="isa_error">
                 <i class="fa fa-times-circle"></i>
                     Email je již registrovaný </div>';
    }else if (strpos($url,'id') !== false) {        
        echo '<div class="isa_error">
                 <i class="fa fa-times-circle"></i>
                     Rodné číslo je již registrováno </div>';
}    
     
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

        <label for="email">E-mail*</label>
        <input type="email" name="email" id="email" required><br>


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