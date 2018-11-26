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
                    <a href="#">Košík</a>
                    <div class="login-container">
                        <?php
                            session_start();
                            if(isset($_SESSION['login'])) {
                                echo '<form action="login.php" method="post">
                                        <p class=login-status"> Ste prihlásený</p>
                                        <input type="submit" name="logout_btn" value="Odhlasit se">';
                                }
                            else {
                                echo '<form action="login.php" method="post">
                                        <label for="login">Login</label>
                                        <input type="text" name="login" id="login"><br>

                                        <label for="password">Heslo</label>
                                        <input type="password" name="password" id="password"><br>

                                        <input type="submit" name="logout_btn" value="Odhlasit se">
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