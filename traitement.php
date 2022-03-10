<?php

try {
    $pdo = new PDO("mysql:host=localhost:3310;dbname=medical", "root", "root");
} catch (PDOException $exception) {
    print $exception;
    die();
}

function readInfirmier($id)
{
    global $pdo;
    $read = $pdo->query("select * FROM infirmier INNER JOIN adresse WHERE idinfirmier = $id");
    $infirmiers = $read->fetch


    (PDO::FETCH_OBJ);
    $pdo = null;
    echo json_encode($infirmiers);
}

if (!empty($_REQUEST['id'])) {
    readInfirmier($_REQUEST['id']);
}
