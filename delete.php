<?php

try {
    $pdo = new PDO("mysql:host=localhost:3310;dbname=medical", "root", "root");
} catch (PDOException $exception) {
    print $exception;
    die();
}

/**
 * @param $id
 * @return void
 */
function deleteInfirmier($id)
{
    global $pdo;
    $sql = $pdo->prepare("DELETE FROM infirmier WHERE idinfirmier= :id");
    $sql->bindParam(':id', $id, PDO::PARAM_INT);
    $idadresse = getIdAdresse($id);
    $sql->execute();

    $count = checkAdresse($idadresse);
    if ($count == 0) {
        deleteAdresse($idadresse);
    }
    $pdo = null;
}

/**
 * @param $id
 * @return mixed
 */
function getIdAdresse($id)
{
    global $pdo;
    $sql = $pdo->query("SELECT adresse_idadresse as id FROM infirmier WHERE idinfirmier = $id");
    $data = $sql->fetch(PDO::FETCH_OBJ);
    return $data->id;
}

/**
 * @param $id
 * @return mixed
 */
function checkAdresse($id)
{
    global $pdo;
    $sql = $pdo->query("SELECT count(idinfirmier) as nbr FROM infirmier WHERE adresse_idadresse = $id");
    $data = $sql->fetch(PDO::FETCH_OBJ);
    return $data->nbr;
}

/**
 * @param $id
 * @return void
 */
function deleteAdresse($id)
{
    global $pdo;
    $sql = $pdo->prepare("DELETE FROM adresse WHERE idadresse = :id");
    $sql->bindParam(':id', $id, PDO::PARAM_INT);
    $sql->execute();
}

if (!empty($_REQUEST["id"])) {
    deleteInfirmier($_REQUEST["id"]);
    header("Location: http://localhost:8000/accueil.php");
}
