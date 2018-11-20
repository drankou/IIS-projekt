<?php
require "common.php";

make_header("Přihlašení");
?>
<?php
    $login = $_POST['login'];
    $password = $_POST['password'];

    if ($login == 'admin' && $password == 'admin'){
        echo "<p>Login successful</p>";
        $_SESSION['user'] = $login;
    } else {
        echo "<p>Incorrect login</p>";
    }
    ?>

<?php
make_footer();
?>