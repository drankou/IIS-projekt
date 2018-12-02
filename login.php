<?php
require "common.php";
require "db_init.php";
make_header("Přihlašení");
?>
<?php

	// PRIHLASENIE
	if (isset($_POST['login_btn'])) {
    	$login = $_POST['login'];
    	$password = $_POST['password'];		// tu treba hash heslo kvoli bezpecnosti       
    	$sql = "SELECT * FROM KLIENT WHERE login='$login' AND heslo='$password'";
    	$result = mysqli_query($db, $sql);
        $row = mysqli_fetch_array($result);

    	if (mysqli_num_rows($result) == 1) {
    		$_SESSION['login'] = $login;
    		$_SESSION['user'] = "client";
    		if ($row['login'] == "admin"){
                $_SESSION['user'] = "admin";
            }
    		$_SESSION['user_id'] = $row['rodne_cislo'];
    		header('location:index.php');
    	} else {
            $sql = "SELECT * FROM ZAMESTNANEC WHERE login='$login' AND heslo='$password'";
            $result = mysqli_query($db, $sql) or die (mysqli_error($db));
          	$row = mysqli_fetch_array($result);

            if (mysqli_num_rows($result) == 1) {
                $_SESSION['login'] = $login;
                $_SESSION['user'] = "employee";
                $_SESSION['user_id'] = $row['id_zamestnance'];
                header('location:index.php');
            }
       		 echo '<div class="isa_error">
                 <i class="fa fa-times-circle"></i>
                     Špatné meno nebo heslo </div>'; // tu nejake vyskakovacie okno ze zle prihlasenie
       	}
     
   	}

   	// ODHLASENIE   
	   	if (isset($_POST['logout_btn'])) {   		
	   		session_destroy();
	   		unset($_SESSION['login']);
	   		header('location:index.php');
	   		echo "<p>Úspěšně jste se odhlasil.</p>";
	   	}
    ?>

<?php
make_footer();
?>