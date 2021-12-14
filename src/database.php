<?php
$server = "localhost";
$user = "root";
$pass = "";
$dbname = "ebanking";


$db = new mysqli($server,$user,$pass,$dbname);

if($db->connect_error){
    die("Verbindung fehlgeschlagen: " . $db->connect_error);
}
// // Select mit SQL Injection Sicherung
// $mysqli = $db->prepare("SELECT email, passwort FROM kunde WHERE email = ? AND passwort = ?");
// $mysqli->bind_param("ss", $email, $password);
// $mysqli->execute();
// $count = $mysqli->fetch();

function loginCheckKunde($email, $password, $db){
        $mysqli = $db->prepare("SELECT email, passwort FROM kunde WHERE email = ? AND passwort = ?");
        $mysqli->bind_param("ss", $email, $password);
        $mysqli->execute();
        $count = $mysqli->fetch();
        echo $count;
        return $count;
}

function loginCheckEmployee($email, $password, $db){
    $mysqli = $db->prepare("SELECT email, passwort FROM X WHERE email = ? AND passwort = ?");
    $mysqli->bind_param("ss", $email, $password);
    $mysqli->execute();
    $count = $mysqli->fetch();
    echo $count;
    return $count;
}

function isEmailSet($email, $db){
    $mysqli = $db->prepare("SELECT email FROM kunde WHERE email = ?");
    $mysqli->bind_param("s", $email);
    $mysqli->execute();
    $count = $mysqli->fetch();
    return $count;
}

function insertIntoDb($email, $password, $db){
    $stmt = $db->prepare("INSERT INTO kunde (id, email, passwort) VALUES ('', ? , ?)");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
}



?>