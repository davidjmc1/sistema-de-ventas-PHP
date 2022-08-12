<?php
$host ='localhost';
$user ='root';
$password ='';
$database='proyecto';

$mysqli = new mysqli($host, $user, $password, $database);

if ($mysqli -> connect_errno){
die("Fallo la conexión a MySQL: (".$mysqli -> mysqli_connect_errno());
}

?>