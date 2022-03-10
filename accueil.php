<?php

try {
    $pdo = new PDO("mysql:host=localhost:3310;dbname=medical", "root", "root");
} catch (PDOException $exception) {
    print $exception;
    die();
}

function readAllInfirmier()
{
    global $pdo;
    $read = $pdo->query("select * FROM infirmier");
    $infirmiers = $read->fetchAll(PDO::FETCH_OBJ);
    $pdo = null;
    return $infirmiers;
}

$read = readAllInfirmier();
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
    <title>REQUETE </title>
</head>
<body>

<?php include_once("nav.php") ?>
<h1 style="text-align: center"> Accueil </h1>

<table class="table table-sm">
    <thead>
    <tr>
        <th class="col-sm-3" scope="col">nom</th>
        <th class="col-sm-3" scope="col">prenom</th>
        <th class="col-sm-3" scope="col">numero professionnel</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($read as $infirmier) { ?>
        <tr>
            <td><?= $infirmier->nom ?></td>
            <td><?= $infirmier->prenom ?></td>
            <td><?= $infirmier->numero_pro ?></td>
            <td>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal"
                        data-bs-id="<?= $infirmier->idinfirmier ?>"> details
                </button>
                <a class="btn btn-warning" href="http://localhost:8000/update.php?id=<?= $infirmier->idinfirmier ?>">
                    modifier </a>
                <a class="btn btn-danger" href="http://localhost:8000/delete.php?id=<?= $infirmier->idinfirmier ?>">
                    supprimer </a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<!-- modale -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Details </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 id="patronyme" class="card-title"></h5>
                        <p class="card-text">
                        <p>numero professionnel : <span id="numpro"> </span></p>
                        <p> portable : <span id="portable"></span></p>
                        <p> telephone : <span id="telephone"></span></p>
                        <p> adresse : <span id="adresse"></span></p>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
<script src="js/script.js"></script>
</body>
</html>



