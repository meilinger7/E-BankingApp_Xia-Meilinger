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

    function validate($email, $password)
{
    return validateEmail($email) & validatePassword($password);
}


?>