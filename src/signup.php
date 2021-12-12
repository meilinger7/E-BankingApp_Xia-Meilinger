<?php
require "func.php";
$server = "localhost";
$user = "root";
$pass = "";
$dbname = "ebanking";

$db = new mysqli($server,$user,$pass,$dbname);

if($db->connect_error){
    die("Verbindung fehlgeschlagen: " . $db->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Banking App - Registrieren</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script type="text/javascript" src="index.js"></script>

</head>

<body>
    <?php
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $password = isset($_POST['password']) ? $_POST['password'] : "";
    ?>

    <div id="formStyle" class="container">
        <div id="formField">
            <h2>Registrieren</h2>
            <?php
                if(isset($_POST['signin'])){
                    if (validate($email, $password)) {
                        //Weiterleitung an die index
                    } else {
                        echo "<div class='alert alert-danger'>Die eingegebenen Daten sind fehlerhaft!<ul>";
                        foreach ($errors as $key => $value) {
                            echo "<li>" . $value . "</li>";
                        }
                    }
                    echo "</div>";
                }
                
            ?>
            <form action="signup.php" method="post">
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" placeholder="E-Mail" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required="required">
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : ''  ?>" placeholder="Password" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" minlength="5" maxlength="15" required="requiered">
                </div>
                <button id="button" name="signin" type="submit" class="btn">Registrieren</button>

            </form>

            <a class="link-light" href="login.php">Einloggen</a>

        </div>
    </div>

    <?php
        $mail = $_POST['email'];
        $kennwort = $_POST['password'];

        $sql = "INSERT INTO kunde (id, email, password)
        VALUES ('', '$mail', '$kennwort')";

        if(isset($mail) && isset($kennwort)){
            $db->query($sql);
            $db->close();
        }
    ?>

</body>

</html>