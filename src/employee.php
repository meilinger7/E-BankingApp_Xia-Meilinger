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
    $email = $_SESSION['employeeLogin'];
    $user = fetchAllEmployee($email, $db);
    $id = $user['id'];
    $email = $user['email'];

    if (!isset($_SESSION['employeeLogin'])) {
        header("Location: employeeLogin.php");
        exit;
    } else {
        if (isset($_POST['signout'])) {
            unset($_SESSION['employeeLogin']);
            header("Location: employeeLogin.php");
            exit;
        }
        if (isset($_POST['abheben'])) {
            abheben($_POST['iban'], $id, $_POST['betrag']);
        }
        if (isset($_POST['einzahlen'])) {
            einzahlen($_POST['iban'], $id, $_POST['betrag']);
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
                            <div id="employeeBox">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-7  col-sm-12 ">
                                            <h5><?php echo $email; ?></h5>
                                        </div>
                                        <div class="col-md-5  col-sm-12 ">
                                            <form action="employee.php" method="POST">
                                                <button id="button" name="signout" type="submit" class="btn">Ausloggen</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>

                <div id="transactionList">
                    <h3>Abheben:</h3>
                    <form action="employee.php" method="POST">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-5  col-sm-12 ">
                                    <input type="text" name="iban" class="form-control" placeholder="Iban" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                </div>
                                <div class="col-md-5  col-sm-12 ">
                                    <input type="text" name="betrag" class="form-control" placeholder="Betrag" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                </div>
                                <div class="col-md-2  col-sm-12 ">
                                    <button id="payButton" name="abheben" type="submit" class="btn">Ausführen</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <br>
                    <h3>Einzahlen: </h3>
                    <form action="employee.php" method="POST">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-5  col-sm-12 ">
                                    <input type="text" name="iban" class="form-control" placeholder="Iban" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                </div>
                                <div class="col-md-5  col-sm-12 ">
                                    <input type="text" name="betrag" class="form-control" placeholder="Betrag" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                </div>
                                <div class="col-md-2  col-sm-12 ">
                                    <button id="payButton" name="einzahlen" type="submit" class="btn">Ausführen</button>
                                </div>
                            </div>
                        </div>
                    </form>




                </div>


            </div>
        </div>
    <?php
    }
    ?>


</body>

</html>