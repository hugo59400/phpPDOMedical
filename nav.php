<?php
session_start();

if (empty($_SESSION["user"])) {
    header("Location:/login.php");
}
?>

<ul class="nav">
    <li class="nav-item">
        <a class="nav-link active" href="page1.php"> page 1</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="page2.php"> page 2</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="accueil.php"> accueil</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="create.php"> créer un infirmier</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="logout.php"> deconnexion</a>
    </li>
</ul>
