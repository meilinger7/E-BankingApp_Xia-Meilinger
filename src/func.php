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

    function validateUsername($username){
        global $errors;

        if(!isset($username) || strlen($username) < 5 || strlen($username) > 20){
            $errors['username'] = "Benutzername ungültig";
            return false;
        }
        else{
            return true;
        }
    }

    function validate($username ,$email, $password)
{
    return validateEmail($email) & validatePassword($password) & validateUsername($username);
}


?>