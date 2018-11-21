<?php
require "common.php";
require "db_init.php";

make_header("Registrace");
?>

<div class="registration">
    <form action="registration.php" method="post">
<<<<<<< HEAD
        <label for="personal_id">Rodné číslo</label>
=======
        <label for=login>Login*</label>
        <input type="text" name="login" id="login"><br>

        <label for="password">Heslo*</label>
        <input type="password" name="password" id="password"><br>

        <label for="personal_id">Rodné číslo*</label>
>>>>>>> master
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

        <input type="submit" value="Zaregistrovat se">
    </form>
</div>



<?php
make_footer();
?>
