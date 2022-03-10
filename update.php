<?php
try {
    $pdo = new PDO("mysql:host=localhost:3310;dbname=medical", "root", "root");
} catch (PDOException $exception) {
    print $exception;
    die();
}


/**
 * @param $id
 * @return mixed
 */
function readInfirmier($id)
{
    global $pdo;
    $read = $pdo->query("select * FROM infirmier INNER JOIN adresse WHERE idinfirmier = $id");
    $infirmiers = $read->fetch(PDO::FETCH_OBJ);
    return $infirmiers;
}

if (!empty($_REQUEST['id'])) {
    $data = readInfirmier($_REQUEST['id']);
}

if (sizeof($_REQUEST) == 10) {
    $check = 0;
    foreach ($_REQUEST as $value) {
        if (empty($value)) {
            $check++;
        }
    }
    if ($check == 0) {
        $id = getId($_REQUEST);
        setAdresse($id->idadresse, $_POST);
        $error = setInfirmier($_REQUEST);
        if ($error == 00000 ) {
            $_REQUEST = null;
            header("Location:/accueil.php");
        } else {
            print $error;
        }
    }
}

/**
 * @param $data
 * @return mixed|void
 */
function getId($data) {
    global $pdo;
    $sql = $pdo->prepare("SELECT adresse_idadresse as idadresse FROM infirmier WHERE idinfirmier = :id ");
    $sql->bindParam(":id", $data["id"]);
    try {
        $sql->execute();
        return $sql->fetch(PDO::FETCH_OBJ);
    }catch (PDOException $except) {
        print $except;
    }
}

/**
 * @param $id
 * @param $data
 * @return void
 */
function setAdresse($id, $data) {
    global $pdo;
    $sql = $pdo->prepare("UPDATE adresse SET numero = :num, rue = :rue, cp = :cp, ville = :ville WHERE idadresse = :idadresse");
    $sql->bindParam(":num", $data["numero"], PDO::PARAM_STR);
    $sql->bindParam(":rue", $data["rue"], PDO::PARAM_STR);
    $sql->bindParam(":cp", $data["cp"], PDO::PARAM_INT);
    $sql->bindParam(":ville", $data["ville"], PDO::PARAM_STR);
    $sql->bindParam(":idadresse", $id, PDO::PARAM_INT);
    try {
        $sql->execute();
    }catch (PDOException $except) {
        print $except;
    }
}

/**
 * @param $data
 * @return mixed|string|void|null
 */
function setInfirmier($data) {
    global $pdo;
    $sql = $pdo->prepare("UPDATE infirmier SET nom = :nom, prenom = :prenom, numero_pro = :numpro, tel_pro = :tel_pro, tel_perso = :tel_perso WHERE idinfirmier = :id");
    $sql->bindParam(":nom", $data["nom"], PDO::PARAM_STR);
    $sql->bindParam(":prenom", $data["prenom"], PDO::PARAM_STR);
    $sql->bindParam(":numpro", $data["numero_pro"], PDO::PARAM_INT);
    $sql->bindParam(":tel_pro", $data["tel_pro"], PDO::PARAM_INT);
    $sql->bindParam(":tel_perso", $data["tel_perso"], PDO::PARAM_INT);    $sql->bindParam(":id", $data["id"], PDO::PARAM_INT);
    try {
        $sql->execute();
        return $pdo->errorCode();
    }catch (PDOException $except) {
        print $except;
    }
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
    <title>Creation</title>
</head>
<body>

<?php include_once("nav.php") ?>

<form action="" method="post">
    <input type="hidden" name="id" value="<?= $_GET["id"] ?>">
    <div class="mb-3">
        <label class="form-label" for="nom"> nom : </label>
        <input class="form-control" type="text" name="nom" id="nom" value="<?= $data->nom ?>">
    </div>

    <div>
        <label class="form-label" for="prenom"> prenom : </label>
        <input class="form-control" type="text" name="prenom" id="prenom" value="<?= $data->prenom ?>">
    </div>

    <div>
        <label class="form-label" for="numero_pro"> numero professionnel : </label>
        <input class="form-control" type="text" name="numero_pro" id="numero_pro" value="<?= $data->numero_pro ?>">
        <?php if (isset($error) && $error == 23000) { ?>
            <p style="color: red"> numéro professionnel déjà présent en base de données </p>
        <?php } ?>
    </div>

    <div>
        <label class="form-label" for="tel_pro"> telephone professionnel : </label>
        <input class="form-control" type="text" name="tel_pro" id="tel_pro" value="<?= $data->tel_pro ?>">
    </div>

    <div>
        <label class="form-label" for="tel_perso"> telephone personnel : </label>
        <input class="form-control" type="text" name="tel_perso" id="tel_perso" value="<?= $data->tel_perso ?>">
    </div>

    <div>
        <label class="form-label" for="numero"> numero : </label>
        <input class="form-control" type="text" name="numero" id="numero" value="<?= $data->numero ?>">
    </div>

    <div>
        <label class="form-label" for="rue"> rue : </label>
        <input class="form-control" type="text" name="rue" id="rue" value="<?= $data->rue ?>">
    </div>

    <div>
        <label class="form-label" for="cp"> code postal : </label>
        <input class="form-control" type="text" name="cp" id="cp" value="<?= $data->cp ?>">
    </div>

    <div>
        <label class="form-label" for="ville"> ville : </label>
        <input class="form-control" type="text" name="ville" id="ville" value="<?= $data->ville ?>">
    </div>


    <button class="btn btn-primary" type="submit"> soumettre</button>
</form>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>
</html>
