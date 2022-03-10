<?php
try {
    $pdo = new PDO("mysql:host=localhost:3310;dbname=medical", "root", "root");
} catch (PDOException $exception) {
    print $exception;
    die();
}

/**
 * @param $id
 * @param $data
 * @return string|null
 */
function createInfirmier($id, $data)
{
    global $pdo;
    $request = $pdo->prepare("INSERT INTO infirmier(adresse_idadresse,numero_pro, nom, prenom, tel_pro, tel_perso) VALUES(:idadresse, :numpro, :nom, :prenom, :telpro, :telperso)");
    $request->bindParam(':idadresse', $id, PDO::PARAM_INT);
    $request->bindParam(':numpro', $data['numero_pro'], PDO::PARAM_INT);
    $request->bindParam(':nom', $data['nom'], PDO::PARAM_STR);
    $request->bindParam(':prenom', $data['prenom'], PDO::PARAM_STR);
    $request->bindParam(':telpro', $data['tel_pro'], PDO::PARAM_INT);
    $request->bindParam(':telperso', $data['tel_perso'], PDO::PARAM_INT);
    $request->execute();
    return $request->errorCode();

}

/**
 * @param $data
 * @return int
 */
function checkAdresse($data)
{
    global $pdo;
    $adresse = $pdo->prepare("SELECT idadresse FROM adresse WHERE numero = :numero and rue = :rue and cp = :cp and ville = :ville");
    $adresse->bindParam(':numero', $data['numero'], PDO::PARAM_STR);
    $adresse->bindParam(':rue', $data['rue'], PDO::PARAM_STR);
    $adresse->bindParam(':cp', $data['cp'], PDO::PARAM_INT);
    $adresse->bindParam(':ville', $data['ville'], PDO::PARAM_STR);
    $adresse->execute();
    $result = $adresse->fetch(PDO::FETCH_OBJ);
    if ($result == FALSE) {
        return 0;
    } else {
        return $result->idadresse;
    }
}

/**
 * @param $data
 * @return false|string
 */
function createAdresse($data)
{
    global $pdo;
    $adresse = $pdo->prepare("INSERT INTO adresse(numero, rue, cp, ville) VALUES(?,?,?,?)");
    $adresse->bindParam(1, $data["numero"], PDO::PARAM_STR);
    $adresse->bindParam(2, $data["rue"], PDO::PARAM_STR);
    $adresse->bindParam(3, $data["cp"], PDO::PARAM_INT);
    $adresse->bindParam(4, $data["ville"], PDO::PARAM_STR);
    $adresse->execute();
    return $pdo->lastInsertId();

}

if (sizeof($_REQUEST) == 9) {
    $check = 0;
    foreach ($_REQUEST as $value) {
        if (empty($value)) {
            $check++;
        }
    }
    if ($check == 0) {
        if (checkAdresse($_REQUEST) == 0) {
            $id = createAdresse($_REQUEST);
        } else {
            $id = checkAdresse($_REQUEST);
        }
        $error = createInfirmier($id, $_REQUEST);
        if ($error == 00000 ) {
            $_REQUEST = null;
        }

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
    <div class="mb-3">
        <label class="form-label" for="nom"> nom : </label>
        <input class="form-control" type="text" name="nom" id="nom" value="test">
    </div>

    <div>
        <label class="form-label" for="prenom"> prenom : </label>
        <input class="form-control" type="text" name="prenom" id="prenom" value="test">
    </div>

    <div>
        <label class="form-label" for="numero_pro"> numero professionnel : </label>
        <input class="form-control" type="text" name="numero_pro" id="numero_pro" value="111111111">
        <?php if (isset($error) && $error == 23000) { ?>
            <p style="color: red"> numéro professionnel déjà présent en base de données </p>
        <?php } ?>
    </div>

    <div>
        <label class="form-label" for="tel_pro"> telephone professionnel : </label>
        <input class="form-control" type="text" name="tel_pro" id="tel_pro" value="000000000">
    </div>

    <div>
        <label class="form-label" for="tel_perso"> telephone personnel : </label>
        <input class="form-control" type="text" name="tel_perso" id="tel_perso" value="00000000">
    </div>

    <div>
        <label class="form-label" for="numero"> numero : </label>
        <input class="form-control" type="text" name="numero" id="numero" value="99">
    </div>

    <div>
        <label class="form-label" for="rue"> rue : </label>
        <input class="form-control" type="text" name="rue" id="rue" value="rue jfk">
    </div>

    <div>
        <label class="form-label" for="cp"> code postal : </label>
        <input class="form-control" type="text" name="cp" id="cp" value="59100">
    </div>

    <div>
        <label class="form-label" for="ville"> ville : </label>
        <input class="form-control" type="text" name="ville" id="ville" value="iuyrttyzer">
    </div>


    <button class="btn btn-primary" type="submit"> soumettre</button>
</form>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>
</html>
