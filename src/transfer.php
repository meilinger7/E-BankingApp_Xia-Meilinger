<?php
session_start();

require "lib/func.php";
require_once "lib/database.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Banking App - Überweisung</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script type="text/javascript" src="index.js"></script>

</head>

<body>
    <?php
    $login = $_SESSION['login'];
    
    if (!isset($_SESSION['login'])) {
        header("Location: login.php");
        exit;
    } else {
        if (isset($_POST['transfer'])) {
            $betrag = isset($_POST['betrag']) ? $_POST['betrag'] : "";
            $senderIban = fetchAll($login, $db)['iban'];
            $empfaengerIban = isset($_POST['iban']) ? $_POST['iban'] : "";
            $bic = isset($_POST['bic']) ? $_POST['bic'] : "";
            $zweck = isset($_POST['zweck']) ? $_POST['zweck'] : "";

            transfer($betrag, $senderIban, $empfaengerIban, $bic, $zweck);

            header("Location: index.php");
            exit;
        }



    ?>
        <div id="formStyle" class="container">
            <div id="formField">
                <h2>Überweisen</h2>
                <form action="transfer.php" method="POST">
                    <div class="input-group mb-3">
                        <input type="text" name="iban" class="form-control" placeholder="IBAN" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>

                    <div class="input-group mb-3">
                        <input type="text" name="bic" class="form-control" placeholder="BIC" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>

                    <div class="input-group mb-3">
                        <input type="text" name="betrag" class="form-control" placeholder="Betrag" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>

                    <div class="input-group mb-3">
                        <textarea name="zweck" placeholder="Verwendungszweck" class="form-control" aria-label="With textarea"></textarea>
                    </div>

                    <button id="button" name="transfer" type="submit" class="btn">Senden</button>
                    <a id="backButton" name="back" class="link-light" href="index.php">zurück</a>
                </form>

            </div>
        </div>
    <?php
    }
    ?>


</body>

</html>