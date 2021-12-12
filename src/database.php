<?php
$server = "localhost";
$user = "root";
$pass = "";
$dbname = "ebanking";

$db = new mysqli($server,$user,$pass,$dbname);

if($db->connect_error){
    die("Verbindung fehlgeschlagen: " . $db->connect_error);
}
?>