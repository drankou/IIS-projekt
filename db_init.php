<?php
$DB_HOST = "localhost";  //
$DB_USERNAME = "root";  //xdrank00
$DB_PASSWORD = "password";  //jir4onvu
$DB_NAME = "iis-project";   //xdrank00

$db = mysqli_init();
if (!mysqli_real_connect($db, $DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME, 3306, '/var/run/mysqld/mysqld.sock')) {
    die('cannot connect '.mysqli_connecterror());
}