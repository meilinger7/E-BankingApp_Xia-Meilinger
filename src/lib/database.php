<?php
$server = "localhost";
$user = "root";
$pass = "";
$dbname = "ebanking";


$db = new mysqli($server, $user, $pass, $dbname);

if ($db->connect_error) {
    die("Verbindung fehlgeschlagen: " . $db->connect_error);
}
// // Select mit SQL Injection Sicherung
// $mysqli = $db->prepare("SELECT email, passwort FROM kunde WHERE email = ? AND passwort = ?");
// $mysqli->bind_param("ss", $email, $password);
// $mysqli->execute();
// $count = $mysqli->fetch();

function fetchAll($email, $db)
{
    $mysqli = $db->prepare("SELECT * FROM kunde WHERE email = ?");
    $mysqli->bind_param("s", $email);
    $mysqli->execute();
    $result = $mysqli->get_result();
    $assocresult = $result->fetch_assoc();
    return $assocresult;
}

function fetchAllEmployee($email, $db)
{
    $mysqli = $db->prepare("SELECT * FROM angestellte WHERE email = ?");
    $mysqli->bind_param("s", $email);
    $mysqli->execute();
    $result = $mysqli->get_result();
    $assocresult = $result->fetch_assoc();
    return $assocresult;
}

function loginCheckKunde($email, $password, $db)
{
    $mysqli = $db->prepare("SELECT email, passwort FROM kunde WHERE email = ? AND passwort = ?");
    $mysqli->bind_param("ss", $email, $password);
    $mysqli->execute();
    $count = $mysqli->fetch();
    return $count;
}

function loginCheckEmployee($email, $password, $db)
{
    $mysqli = $db->prepare("SELECT email, passwort FROM angestellte WHERE email = ? AND passwort = ?");
    $mysqli->bind_param("ss", $email, $password);
    $mysqli->execute();
    $count = $mysqli->fetch();
    return $count;
}

function isEmailSet($email, $db)
{
    $mysqli = $db->prepare("SELECT email FROM kunde WHERE email = ?");
    $mysqli->bind_param("s", $email);
    $mysqli->execute();
    $count = $mysqli->fetch();
    return $count;
}

function insertRegister($firstname, $lastname, $email, $password, $db)
{
    $iban = generateIban($db);
    $bic = generateBic($db);
    $stmt = $db->prepare("INSERT INTO kunde (id, vorname, nachname, email, passwort, iban, bic) VALUES ('', ? , ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $firstname, $lastname, $email, $password, $iban, $bic);
    $stmt->execute();
}

function generateIban($db)
{
    $iban = "AT";
    $number = "";
    $result = 1;
    while ($result != 0) {
        for ($i = 0; $i <= 14; $i++) {
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

function generateBic($db)
{
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

function displayIban($iban, $db)
{
    $nIban = substr($iban, 0, 4) . " " . substr($iban, 4, 4) . " " . substr($iban, 8, 4) . " " . substr($iban, 12, 4);
    return $nIban;
}

function displayName($vName, $nName)
{
    $name = $vName . " " . $nName;
    return $name;
}

function transfer($betrag, $senderIban, $empfaengerIban, $bic, $zweck)
{
    global $db;

    $sender = getIdFromIban($senderIban);
    $empfaenger = getIdFromIban($empfaengerIban);
    $betrag = floatval($betrag);
    $timestamp = date("Y-m-d H:i:s");

    //Insert into transaktionen
    $stmt = $db->prepare("INSERT INTO transaktionen (id, betrag, sender_id, empfaenger_id, bic, zweck, zeitstempel) VALUES ('', ? , ?, ?, ?, ?, ?)");
    $stmt->bind_param("diisss", $betrag, $sender, $empfaenger, $bic, $zweck, $timestamp);
    $stmt->execute();

    //Update Sender
    $stmt = $db->prepare("UPDATE kunde SET kontostand=kontostand-? WHERE id=?");
    $stmt->bind_param("di", $betrag, $sender);
    $stmt->execute();

    //Update Empfänger
    $stmt = $db->prepare("UPDATE kunde SET kontostand=kontostand+? WHERE id=?");
    $stmt->bind_param("di", $betrag, $empfaenger);
    $stmt->execute();
}


function abheben($iban, $angestellterId, $betrag)
{
    global $db;
    $timestamp = date("Y-m-d H:i:s");
    $kundeId = getIdFromIban($iban);
    $me = true;

    //Insert into zahlungen / abhabeung
    $stmt = $db->prepare("INSERT INTO zahlungen (id, kunde, angestellter, betrag, methode, zeitstempel) VALUES ('', ?, ?, ?, 0, ?)");
    $stmt->bind_param("iids", $kundeId, $angestellterId, $betrag, $timestamp);
    $stmt->execute();
}

function einzahlen($iban, $angestellterId, $betrag)
{
    global $db;
    $timestamp = date("Y-m-d H:i:s");
    $kundeId = getIdFromIban($iban);


    //Insert into zahlungen / abhabeung
    $stmt = $db->prepare("INSERT INTO zahlungen (id, kunde, angestellter, betrag, methode, zeitstempel) VALUES ('', ?, ?, ?, 1, ?)");
    $stmt->bind_param("iids", $kundeId, $angestellterId, $betrag, $timestamp);
    $stmt->execute();
}



function getIdFromIban($iban)
{
    global $db;
    $id = '';

    $mysqli = $db->prepare("SELECT id FROM kunde WHERE iban = ?");
    $mysqli->bind_param("s", $iban);
    $mysqli->execute();
    $result = $mysqli->get_result();
    $id = $result->fetch_assoc();

    return $id['id'];
}

function getTransaktionenById($id)
{
    global $db;

    $mysqli = $db->prepare("SELECT sender_id, zeitstempel, zweck, betrag FROM transaktionen WHERE sender_id = ? OR empfaenger_id = ?");
    $mysqli->bind_param("ii", $id, $id);
    $mysqli->execute();
    $result = $mysqli->get_result();
    $transaktionen = $result->fetch_all();

    return $transaktionen;
}
