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

function fetchAll($email, $db){
    $mysqli = $db->prepare("SELECT * FROM kunde WHERE email = ?");
    $mysqli->bind_param("s", $email);
    $mysqli->execute();
    $result = $mysqli->get_result();
    $assocresult = $result->fetch_assoc();
    return $assocresult;
}

function loginCheckKunde($email, $password, $db){
    $mysqli = $db->prepare("SELECT email, passwort FROM kunde WHERE email = ? AND passwort = ?");
    $mysqli->bind_param("ss", $email, $password);
    $mysqli->execute();
    $count = $mysqli->fetch();
    return $count;
}

function loginCheckEmployee($email, $password, $db){
    $mysqli = $db->prepare("SELECT email, passwort FROM angestellte WHERE email = ? AND passwort = ?");
    $mysqli->bind_param("ss", $email, $password);
    $mysqli->execute();
    $count = $mysqli->fetch();
    return $count;
}

function isEmailSet($email, $db){
    $mysqli = $db->prepare("SELECT email FROM kunde WHERE email = ?"); 
    $mysqli->bind_param("s", $email);
    $mysqli->execute();
    $count = $mysqli->fetch();
    return $count;
}

function insertRegister($firstname, $lastname, $email, $password, $db){
    $iban = generateIban($db);
    $bic = generateBic($db);
    $stmt = $db->prepare("INSERT INTO kunde (id, vorname, nachname, email, passwort, iban, bic) VALUES ('', ? , ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $firstname, $lastname, $email, $password, $iban, $bic);
    $stmt->execute();
}

function generateIban($db){
    $iban = "AT";
    $number = "";
    $result = 1;
    while ($result != 0) {
        for ($i=0; $i <= 14 ; $i++) { 
            $number = rand(1, 9);
            $iban = $iban . $number;
        }
        $stmt2 = $db->prepare("SELECT iban FROM kunde WHERE iban = ?");
        $stmt2->bind_param("s", $iban);
        $stmt2->execute();
        $result = $stmt2->fetch();
    }
    return $iban;
}

function generateBic($db){
    $bic = "AT";
    // $bic = "AT";
    // $number = "";
    // $result = 1;
    // while ($result != 0) {
    //     for ($i=0; $i <=11 ; $i++) { 
    //         $number = rand(1, 9);
    //         $bic = $bic . $number;
    //     }
    //     $stmt2 = $db->prepare("SELECT bic FROM kunde WHERE bic = ?");
    //     $stmt2->bind_param("s", $bic);
    //     $stmt2->execute();
    //     $result = $stmt2->fetch();
    // }
    return $bic;
}

function displayIban($email, $db){
    $user = fetchAll($email,$db)['iban'];
    $iban = substr($user,0 ,4). " " . substr($user, 4, 4) . " " . substr($user, 8, 4) . " " . substr($user, 12, 4);
    return $iban;
}

function displayName($email, $db){
    $arrUser = fetchAll($email, $db);
    $name = $arrUser['vorname'] . " " . $arrUser['nachname'];
    return $name;
}


?>