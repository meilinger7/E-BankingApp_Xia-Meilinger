<?php
require_once "lib/database.php";

session_start();
$message = "";
$email = "";
$password = "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Banking App - Einloggen Angestellter</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script type="text/javascript" src="index.js"></script>

</head>

<body>
    <?php
    if (isset($_POST['login'])) {
        $email = isset($_POST['email']) ? $_POST['email'] : "";
        $password = isset($_POST['password']) ? $_POST['password'] : "";
        
        if(loginCheckEmployee($email, $password, $db) == 0) {
            $message = "<div class='alert alert-danger'>Die eingegebenen Daten sind fehlerhaft!</div>";
        } else {
            $_SESSION['employeeLogin'] = $email;
            header("Location: employee.php");
            exit;
        }
    }

    ?>
    <div id="formStyle" class="container">
        <div id="formField">
            <h2>Login für Angestellte</h2>
            <?php
                echo $message;
                ?>
            <form action="employeeLogin.php" method="POST">

                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="E-Mail" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>

                <button id="button" name="login" type="submit" class="btn">Einloggen</button>

                <a class="link-light" href="login.php">als Kunde anmelden</a>

            </form>

        </div>


    </div>



</body>

</html>