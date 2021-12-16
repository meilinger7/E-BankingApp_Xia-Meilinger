<?php
$errors = [];
    function validateEmail($email)
    {
        global $errors; // Zugriff auf die globale Fehlervariable
    
        if ($email != "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "E-Mail ungültig";
            return false;
        } else {
            return true;
        }
    }

    function validatePassword($password){
        global $errors;

        if(!isset($password) || strlen($password) < 5 || strlen($password) > 15){
            $errors['password'] = "Passwort ungültig";
            return false;
        }
        else{
            return true;
        }
    }

    function validateFirstname($firstname){
        global $errors;

        if(!isset($firstname) || strlen($firstname) < 1 || strlen($firstname) > 20){
            $errors['firstname'] = "Vorname ungültig";
            return false;
        }
        else{
            return true;
        }
    }

    function validateLastname($lastname){
        global $errors;

        if(!isset($lastname) || strlen($lastname) < 1 || strlen($lastname) > 20){
            $errors['lastname'] = "Nachname ungültig";
            return false;
        }
        else{
            return true;
        }
    }

    function validate($firstname , $lastname ,$email, $password)
{
    return validateEmail($email) & validatePassword($password) & validateFirstname($firstname) & validateLastname($lastname);
}


?>