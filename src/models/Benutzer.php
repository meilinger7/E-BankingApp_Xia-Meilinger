<?php
$defaultEmail = "test@gmail.com";
$defaultPassword = "12345";

class Benutzer
{
    private $email = '';
    private $password = '';

    public function __construct()
    {
    }

    public static function get($email, $password)
    {
        global $defaultEmail;
        global $defaultPassword;
        $user = new Benutzer($email, $password);
        if ($email == $defaultEmail && $password == $defaultPassword) {
            return $user;
        } else {
            return null;
        }
    }

    // rückgabewert boolean
    public function login()
    {
        $_SESSION['email'] = $this->getEmail();
    }

    // kein rückgabewert
    public static function logout()
    {
        if (isset($_SESSION['email'])) {
            unset($_SESSION['email']);
        }
    }
    // wert boolean rückgabe
    public static function isLoggedIn()
    {
        if (isset($_SESSION['email'])) {
            return true;
        } else {
            return false;
        }
    }

    //Getter
    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    //Setter
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }
}
