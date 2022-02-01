<?php
session_start();
require_once 'lib/database.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Banking App</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script type="text/javascript" src="index.js"></script>

</head>

<body>
    <?php
    $email = $_SESSION['login'];
    $user = fetchAll($email, $db);
    $id = $user['id'];
    $kontostand = $user['kontostand'];
    $displayName = displayName($user['vorname'], $user['nachname']);
    $displayIban = displayIban($user['iban'], $db);




    if (!isset($_SESSION['login'])) {
        header("Location: login.php");
        exit;
    } else {
        if (isset($_POST['signout'])) {
            unset($_SESSION['login']);
            header("Location: login.php");
            exit;
        }

    ?>
        <div class="container">
            <div class="card" id="headerCard">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-12 text-center" id="logoBox">
                            <h1>easy</h1>
                            <h2>banking</h2>
                        </div>
                        <div class="col-md-9  col-sm-12">
                            <div id="userBox">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-7  col-sm-12 ">
                                            <form action="index.php" method="POST">
                                                <button id="button" name="signout" type="submit" class="btn">Ausloggen</button>
                                            </form>
                                        </div>
                                        <div class="col-md-5  col-sm-12 ">
                                            <a id="button" class="btn" href="transfer.php" role="button">Neue Überweisung</a>
                                        </div>
                                    </div>
                                    <div class="row" id="userData">
                                        <div class="col-md-7  col-sm-12 ">
                                            <h3><?php echo $displayName; ?></h3>
                                            <h4><?php echo $displayIban; ?></h4>
                                        </div>
                                        <div class="col-md-5  col-sm-12 ">
                                            <h2 id="moneySum"><?php echo $kontostand . "€"; ?></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='container'>
                <div class="row">
                    <div class="col-6">


                        <div id="transactionList">
                            <h3>Letzte</h3>
                            <h3>Überweisungen:</h3>
                        </div>
                        <?php
                        $transaktionen = getTransaktionenById($id);

                        foreach ($transaktionen as &$transaktion) {
                            if ($transaktion['0'] == $id) {
                                $transaktion['3'] = "- " . $transaktion['3'];
                            } else {
                                $transaktion['3'] = "+ " . $transaktion['3'];
                            }
                        ?>

                            <div class="card" id="card">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-3">
                                                <p><?php echo $transaktion['1']; ?></p>
                                            </div>
                                            <div class="col-6">
                                                <p><?php echo  $transaktion['2']; ?></p>
                                            </div>
                                            <div class="col-3">
                                                <p><?php echo  $transaktion['3']; ?> €</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php
                        }
                        ?>
                    </div>

                    <div class="col-6">


                        <div id="transactionList">
                            <h3>Letzte</h3>
                            <h3>Zahlungen:</h3>
                        </div>
                        <?php
                        $zahlungen = getZahlungenById($id);

                        foreach ($zahlungen as &$zahlung) {
                            if ($zahlung['2'] == 0) {
                                $zahlung['2'] = "Abhebung";
                                $zahlung['3'] = "- " . $zahlung['3'];

                            } else {
                                $zahlung['2'] = "Einzahlung";
                                $zahlung['3'] = "+ " . $zahlung['3'];
                            }
                        ?>

                            <div class="card" id="card">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-3">
                                                <p><?php echo $zahlung['1']; ?></p>
                                            </div>
                                            <div class="col-6">
                                                <p><?php echo  $zahlung['2']; ?></p>
                                            </div>
                                            <div class="col-3">
                                                <p><?php echo  $zahlung['3']; ?> €</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php
                        }
                        
                        ?>
                    </div>

                </div>
            </div>
        </div>
    <?php
    }
    ?>


</body>

</html>