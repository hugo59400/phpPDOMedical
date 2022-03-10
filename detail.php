<?php

try {
    $pdo = new PDO("mysql:host=localhost:3310;dbname=medical", "root", "root");
} catch (PDOException $exception) {
    print $exception;
    die();
}

function readAllInfirmier($id)
{
    global $pdo;
    $read = $pdo->query("SELECT nom, prenom, tel_pro, tel_perso, numero_pro, numero, rue, cp, ville FROM infirmier i INNER JOIN adresse a ON i.adresse_idadresse = a.idadresse WHERE idinfirmier = " . intval($id));
    $infirmiers = $read->fetchAll(PDO::FETCH_OBJ);
    $pdo = null;
    //var_dump(json_encode($infirmiers));
    return $infirmiers;
}


if (!empty($_REQUEST["id"])) {
    $read = readAllInfirmier($_REQUEST["id"]);
}
?>


<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Detail</title>
</head>
<body>


<div class="card" style="width: 18rem;">
    <div class="card-body">
        <h5 class="card-title"><?= $read[0]->prenom . " " . $read[0]->nom ?></h5>
        <p class="card-text">
        <p>numero professionnel : <?= $read[0]->numero_pro ?> </p>
        <p> portable : <?= $read[0]->tel_pro ?> </p>
        <p> telephone : <?= $read[0]->tel_perso ?> </p>
        <p> adresse : <?= $read[0]->numero . " " . $read[0]->rue . " " . $read[0]->cp . " " . $read[0]->ville ?> </p>

        </p>
        <a href="accueil.php" class="btn btn-primary">retour</a>
    </div>
</div>


<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>
</html>