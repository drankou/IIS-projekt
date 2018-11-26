<?php
require "common.php";
//session_start();
make_header("Přihlašení");
?>
<?php
	// lokalna databaza
	$db = mysqli_connect("localhost", "root", "", "iis");


	// PRIHLASENIE
	if (isset($_POST['login_btn'])) {
    	$login = $_POST['login'];
    	$password = $_POST['password'];		// tu treba hash heslo kvoli bezpecnosti
    	$sql = "SELECT * FROM klient WHERE login = '$login' AND heslo = '$password'";  		
	
    	$result = mysqli_query($db, $sql);    	

    	if (mysqli_num_rows($result) == 1) {
    		$_SESSION['message'] = "Si prihlaseny";
    		$_SESSION['login'] = $login;
    		header('location:index.php');    		 		 		
       	} else{
       		echo '<p>Zle meno alebo heslo</p>';   // tu nejake vyskakovacie okno ze zle prihlasenie

       	}
     
   	}

   	// ODHLASENIE   
	   	if (isset($_POST['logout_btn'])) {   		
	   		session_destroy();
	   		unset($_SESSION['login']);
	   		header('location:index.php');
	   		echo "<p>Uspesne si sa odhlasil</p>";
	   	}
   	


   	
	


  /*  if ($login == 'admin' && $password == 'admin'){
        echo "<p>Login successful</p>";
        $_SESSION['user'] = $login;
    } else {
        echo "<p>Incorrect login</p>";
    }*/

    ?>

<?php
make_footer();
?>