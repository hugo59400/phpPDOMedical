<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>

<form action="" method="post">
    <label for="identifiant"> identifiant </label>
    <input type="text" id="identifiant" name="identifiant">

    <label for="password"> mot de passe </label>
    <input type="password" id="password" name="password">

    <button type="submit"> soumettre</button>
</form>
</body>
</html>

<?php

class User
{
    public static $inc = 1;
    public $id;
    public $identifiant;
    public $password;
    public $isadmin;

    public function __construct($identifiant, $password, $isadmin = FALSE)
    {
        $this->id = self::$inc++;
        $this->identifiant = $identifiant;
        $this->password = $password;
        $this->isadmin = $isadmin;
    }

}

$table = array(new User("marc", "root", TRUE), new User("marie", "root"), new User("jeanne", "root"));

if (!empty($_REQUEST["identifiant"]) && !empty($_REQUEST["password"])) {
    $user = $_REQUEST["identifiant"];
    $pass = $_REQUEST["password"];

    foreach ($table as $value) {
        if ($value->identifiant == $user && $value->password == $pass) {
            session_start();
            $_SESSION["user"] = $user;
            $_SESSION["id"] = $value->id;
            if ($value->isadmin == TRUE) {
                $_SESSION["isadmin"] = 1;
            }
            header("Location:/accueil.php");
            exit();
        }
    }
}
