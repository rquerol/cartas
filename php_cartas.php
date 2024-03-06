<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_carta'])) {
    $mitjaPilot = $_POST['mitjaPilot'];
    $nombrePiloto = $_POST['nombrePiloto'];
    $exp = $_POST['exp'];
    $rac = $_POST['rac'];
    $awa = $_POST['awa'];
    $pac = $_POST['pac'];

    $imagenPiloto_tmp = $_FILES['imagenPiloto']['tmp_name'];
    $imagenPilotoName = $_FILES['imagenPiloto']['name'];
    $uploadPath = './media/' . $imagenPilotoName;
    move_uploaded_file($imagenPiloto_tmp, $uploadPath);

    $bandera_tmp = $_FILES['bandera']['tmp_name'];
    $banderaName = $_FILES['bandera']['name'];
    $uploadPathBandera = './banderas/' . $banderaName;
    move_uploaded_file($bandera_tmp, $uploadPathBandera);

    try {
        $stmt1 = $conn->prepare("INSERT INTO pais(nombre, bandera) VALUES (:nombre, :bandera)");
        $stmt1->bindParam(':nombre', $_POST['paisPiloto']);
        $stmt1->bindParam(':bandera', $uploadPathBandera);
        $stmt1->execute();
        $id_pais = $conn->lastInsertId();

        $stmt = $conn->prepare("INSERT INTO piloto(media, name, exp, rac, awa, pac, photo, idpais) VALUES (:mitjaPilot, :name, :exp, :rac, :awa, :pac, :photo, :idpais)");
        $stmt->bindParam(':mitjaPilot', $mitjaPilot);
        $stmt->bindParam(':name', $nombrePiloto);
        $stmt->bindParam(':exp', $exp);
        $stmt->bindParam(':rac', $rac);
        $stmt->bindParam(':awa', $awa);
        $stmt->bindParam(':pac', $pac);
        $stmt->bindParam(':photo', $uploadPath);
        $stmt->bindParam(':idpais', $id_pais);
        $stmt->execute();

        $conn = null;

        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

$conn = null;
?>
