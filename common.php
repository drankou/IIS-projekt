<?php
session_start();
if (!isset($_SESSION["cart_array"])){
    $_SESSION["cart_array"] = array();
}
if (!isset($_SESSION['user'])){
    $_SESSION['user'] = "visitor";
}
function make_header($title)
{
    ini_set("default_charset", "utf-8");
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
                    <?php if ($_SESSION['user'] == "client" || $_SESSION['user'] == "visitor") {
                        $items_number = count($_SESSION["cart_array"]);
                        echo '<a href="cart.php">Košík('.$items_number.')</a>';
                        }
                        ?>
                    <?php if(!isset($_SESSION['login'])){ echo '<a href="registration.php">Zaregistrovat se</a>';}?>
                    <div class="login-container">
                        <?php
                            if(isset($_SESSION['login']) ) {
                                if ($_SESSION['user'] == "client"){
                                echo '  <a href="client.php"><button>Můj Účet</button></a>
                                        <form action="login.php" method="post">
                                            <input type="submit" name="logout_btn" value="Odhlasit se">';
                                } else if ($_SESSION['user'] =="admin"){
                                    echo '  <a href="admin.php"><button>Můj Účet</button></a>
                                        <form action="login.php" method="post">
                                            <input type="submit" name="logout_btn" value="Odhlasit se">';
                                }  else if ($_SESSION['user'] == "employee"){
                                    echo '  <a href="employee.php"><button>Můj Účet</button></a>
                                        <form action="login.php" method="post">
                                            <input type="submit" name="logout_btn" value="Odhlasit se">';
                                }                  
                                 

                            }

                            else {
                                echo '<form action="login.php" method="post">
                                        <label for="login">Login</label>
                                        <input type="text" name="login" id="login" required><br>
                                        <label for="password">Heslo</label>
                                        <input type="password" name="password" id="password" required><br>
                                        <input type="submit" name="login_btn" value="Přihlasit se">';
                            }
                        ?>                      
                        </form>
                    </div>
                </div>
        </div>
        <div class="nav">
            <ul>
                <li><a href="index.php">Úvodní strana</a></li>
                <li><a href="costumes.php">Kostýmy</a></li>
                <li><a href="accessories.php">Doplňky</a></li>
                <li><a href="contacts.php">Kontakty</a></li>
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
function get_products($db, $sql, $product){
    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            $product_id = $row["id"];
            $product_name = $row["nazev"];
            $price = $row["cena"];
            $image = $row["filepath"];
            $color = $row["barva"];
            $manufacter = $row["vyrobce"];
            $material = $row["material"];
            $manager = $row["spravce"];
            $quantity = $row["pocet_kusu"];
            if ($product == "costumes"){
                $size = $row["velikost"];
            }else {
                $size = null;
            }
            if ($quantity > 0){
            echo '<div class="column">
                    <div class="content">
                        <form action="product.php" method="post">
                            <input type="text" name="price" value="'.$price.'" hidden>
                            <input type="text" name="color" value="'.$color.'" hidden>
                            <input type="text" name="product_name" value="'.$product_name.'" hidden>
                            <input type="text" name="product_id" value="'.$product_id.'" hidden>
                            <input type="text" name="manufacter" value="'.$manufacter.'" hidden>
                            <input type="text" name="size" value="'.$size.'" hidden>
                            <input type="text" name="manager" value="'.$manager.'" hidden>
                            <input type="text" name="material" value="'.$material.'" hidden>
                            <input type="text" name="image_src" value="'.$image.'" hidden>
                            <input type="text" name="product_type" value="'.$product.'" hidden>
                            <input type="text" name="quantity" value="'.$quantity.'" hidden>
                    
                            <input type="image" name="image" src='.$image.'  alt="',$product_name,'">
                        </form>
                        <div class="product_info">
                            <h4>'.$product_name.'</h4>
                            <h4>Cena: '.$price.'</h4>
                        </div>
                    </div>
                  </div>';
              }
              else
              {
                continue;
              }
        }
    }else
        echo 'Sorry, no costumes available.';
}
function filterContainer($min_price, $max_price, $page){
    echo '<div class="filterContainer">
    <form class="filter-form" id="search" action="',$page,'" method="post">
        <div class="price-controls">
            Cena
            od <input name="min-price" type="text" value="',$min_price,'">
            do <input name="max-price" type="text" value="',$max_price,'">
        </div>
        <div class="select-cat">
            <select name="category" form="search">
                <option disabled selected value> -- Kategorie -- </option>
                <option value="men">Halloween</option>
                <option value="women">Narozeníny</option>
                <option value="child">Pohádka</option>
            </select>
        </div>
        <input type="submit" name="search_btn" value="Hledat">
    </form>
    <div class="ordering-controls">
            <span> Řadit </span>
            <a href="'.$page.'?mode=ascending">od nejlevnějšího</a>
            <span> / </span>
            <a href="'.$page.'?mode=descending">od nejdražšího</a>            
    </div>
    </div>';
}
function get_related_products($db, $product_id){
    $sql = "SELECT * FROM DOPLNEK WHERE kostym='$product_id' LIMIT 4";
    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo '<span>Možné doplňky:</span><br/>';
        while ($row = mysqli_fetch_array($result)) {
            $product_id = $row["id"];
            $product_name = $row["nazev"];
            $price = $row["cena"];
            $image = $row["filepath"];
            $color = $row["barva"];
            $manufacter = $row["vyrobce"];
            $material = $row["material"];
            $manager = $row["spravce"];
            $quantity = $row["pocet_kusu"];
            $product = "accessories";
            $size = null;
            if ($quantity > 0){
            echo '<div class="related-product-img">
                  <form action="product.php" method="post">
                      <input type="text" name="price" value="'.$price.'" hidden>
                      <input type="text" name="color" value="'.$color.'" hidden>
                      <input type="text" name="product_name" value="'.$product_name.'" hidden>
                      <input type="text" name="product_id" value="'.$product_id.'" hidden>
                      <input type="text" name="manufacter" value="'.$manufacter.'" hidden>
                      <input type="text" name="manager" value="'.$manager.'" hidden>
                      <input type="text" name="material" value="'.$material.'" hidden>
                      <input type="text" name="image_src" value="'.$image.'" hidden>
                      <input type="text" name="product_type" value="'.$product.'" hidden>
                      <input type="text" name="size" value="'.$size.'" hidden>
                      <input type="text" name="quantity" value="'.$quantity.'" hidden>
                    
                      <input type="image" name="image" src='.$image.'  alt="',$product_name,'">
                  </form>
                  </div>';
              }
              else
              {
                continue;
              }
        }
    }
}