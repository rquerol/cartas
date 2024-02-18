<?php
// Incluir el archivo de configuración de la base de datos
require_once 'config.php';

// Manejar el formulario para crear la carta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_carta'])) {
    // Recopilar los datos del formulario
    $mitjaPilot = $_POST['mitjaPilot'];
    $nombrePiloto = $_POST['nombrePiloto'];
    $exp = $_POST['exp'];
    $rac = $_POST['rac'];
    $awa = $_POST['awa'];
    $pac = $_POST['pac'];

    // Procesar la imagen del Piloto
    $imagenPiloto_tmp = $_FILES['imagenPiloto']['tmp_name'];
    $imagenPilotoName = $_FILES['imagenPiloto']['name'];
    $uploadPath = './media/' . $imagenPilotoName;
    move_uploaded_file($imagenPiloto_tmp, $uploadPath);

    // Procesar la bandera del País
    $bandera_tmp = $_FILES['bandera']['tmp_name'];
    $banderaName = $_FILES['bandera']['name'];
    $uploadPathBandera = './banderas/' . $banderaName;
    move_uploaded_file($bandera_tmp, $uploadPathBandera);

    // Insertar los datos en la base de datos
    try {
        // Insertar el país en la base de datos
        $stmt1 = $conn->prepare("INSERT INTO pais(nombre, bandera) VALUES (:nombre, :bandera)");
        $stmt1->bindParam(':nombre', $_POST['paisPiloto']);
        $stmt1->bindParam(':bandera', $uploadPathBandera);
        $stmt1->execute();
        $id_pais = $conn->lastInsertId();

        // Insertar la información del piloto en la base de datos
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

        // Asociar las competiciones seleccionadas con el piloto en la base de datos
        if (isset($_POST['competiciones']) && is_array($_POST['competiciones'])) {
            foreach ($_POST['competiciones'] as $competencia) {
                // Asociar cada competición seleccionada con el piloto
                $stmt2 = $conn->prepare("INSERT INTO piloto_competicio(idpiloto) VALUES (:idpiloto)");
                $stmt2->bindParam(':idpiloto', $conn->lastInsertId());
                $stmt2->execute();
            }
        }

        // Redirigir a la página principal después de agregar la carta
        header('Location: index.php');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Cerrar la conexión a la base de datos
$conn = null;
?>
