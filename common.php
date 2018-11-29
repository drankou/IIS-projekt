<?php
//session_start();
function make_header($title)
{
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="css/styles.css">
        <title><?php echo $title;?></title>
    </head>
    <body>
    <div class="container">
        <div class="header">
                <div class="name">
                    <a href="index.php">Půjčovna kostýmů</a>
                </div>
                <div class="logins">
                    <a href="cart.php">Košík</a>
                    <div class="login-container">
                        <?php
                            session_start();
                            if(isset($_SESSION['login'])) {
                                echo '<form action="login.php" method="post">
                                        <p class=login-status">'; echo "Ahoj, ", $_SESSION['login']; echo '</p>
                                        <input type="submit" name="logout_btn" value="Odhlasit se">';
                                }
                            else {
                                echo '<form action="login.php" method="post">
                                        <label for="login">Login</label>
                                        <input type="text" name="login" id="login"><br>

                                        <label for="password">Heslo</label>
                                        <input type="password" name="password" id="password"><br>

                                        <input type="submit" name="login_btn" value="Přihlasit se">';
                            }
                        ?>                      
                        </form>
                    </div>
                    <a href="registration.php">Zaregistrovat se</a>
                </div>
        </div>
        <div class="nav">
            <ul>
                <li><a href="index.php">Úvodní strana</a></li>
                <li><a href="costumes.php">Kostýmy</a></li>
                <li><a href="accessories.php">Doplňky</a></li>
                <li><a href="#">Obchodní podmínky</a></li>
                <li><a href="#">Kontakty</a></li>
            </ul>
        </div>
    <?php
}
function make_footer()
{
    ?>
        <footer>
            <div class="footer">
                <p>IIS 2018</p>
                <p>&copy; Aliaksandr Drankou & Roman Čabala</p>
            </div>

        </footer>
    </div>
    </body>
    </html>
    <?php
}

function get_products($db, $sql){
    $result = mysqli_query($db, $sql);


    if (mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            $product_id = $row["id"];
            $costume_name = $row["nazev"];
            $price = $row["cena"];
            $image = $row["filepath"];
            $color = $row["barva"];
            $manufacter = $row["vyrobce"];
            $material = $row["material"];
            $manager = $row["spravce"];
            $size = $row["velikost"];

            echo '<div class="column">
                    <div class="content">
                        <form action="product.php" method="post">
                            <input type="text" name="price" value="'.$price.'" hidden>
                            <input type="text" name="color" value="'.$color.'" hidden>
                            <input type="text" name="costume_name" value="'.$costume_name.'" hidden>
                            <input type="text" name="product_id" value="'.$product_id.'" hidden>
                            <input type="text" name="manufacter" value="'.$manufacter.'" hidden>
                            <input type="text" name="size" value="'.$size.'" hidden>
                            <input type="text" name="manager" value="'.$manager.'" hidden>
                            <input type="text" name="material" value="'.$material.'" hidden>
                            <input type="text" name="image_src" value="'.$image.'" hidden>
                    
                            <input type="image" name="image" src='.$image.'  alt="',$costume_name,'">
                        </form>
                        <div class="product_info">
                            <h4>'.$costume_name.'</h4>
                            <h4>Cena: '.$price.'</h4>
                        </div>
                    </div>
                  </div>';
        }
    }else
        echo 'Sorry, no costumes available.';
}

function filterContainer($min_price, $max_price, $page){
    echo '<div class="filterContainer">
    <form class="filter-form" action="',$page,'" method="post">
        <div class="price-controls">
            Cena
            od <input name="min-price" type="text" value="',$min_price,'">
            do <input name="max-price" type="text" value="',$max_price,'">
        </div>
        <input type="submit" name="search_btn" value="Hledat">
    </form>
    </div>';
}
