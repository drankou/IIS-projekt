<?php
$DB_HOST = "localhost";
$DB_USERNAME = "xdrank00";
$DB_PASSWORD = "jir4onvu";
$DB_NAME = "xdrank00";

$db = mysqli_init();
if (!mysqli_real_connect($db, $DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME, 3306, '/var/run/mysql/mysql.sock')) {
    die('cannot connect '.mysqli_connecterror());
}
mysqli_set_charset($db,'utf8');