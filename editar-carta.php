<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Carta</title>
</head>
<body>
    <?php
    // Conexión a la base de datos y recuperación de la carta
    require_once 'config.php';

    // Verificar si se proporciona un ID de carta
    if(isset($_GET['id'])) {
        $cartaId = $_GET['id'];

        // Recuperar la información de la carta desde la base de datos
        $stmt = $conn->prepare("SELECT * FROM piloto WHERE idpiloto = :cartaId");
        $stmt->bindParam(':cartaId', $cartaId);
        $stmt->execute();
        $carta = $stmt->fetch(PDO::FETCH_ASSOC);

        // Mostrar el formulario de edición prellenado con la información de la carta
        ?>
        <form method="POST" action="guardar-edicion.php">
            <input type="hidden" name="carta_id" value="<?php echo $carta['idpiloto']; ?>">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $carta['name']; ?>"><br>
            <label for="media">Media:</label>
            <input type="text" name="media" value="<?php echo $carta['media']; ?>"><br>
            <label for="exp">Experiencia:</label>
            <input type="text" name="exp" value="<?php echo $carta['exp']; ?>"><br>
            <label for="rac">Reflejos:</label>
            <input type="text" name="rac" value="<?php echo $carta['rac']; ?>"><br>
            <label for="awa">Pas per Curves:</label>
            <input type="text" name="awa" value="<?php echo $carta['awa']; ?>"><br>
            <label for="pac">Velocidad:</label>
            <input type="text" name="pac" value="<?php echo $carta['pac']; ?>"><br>
            <input type="submit" name="guardar_edicion" value="Guardar Cambios">
        </form>
        <?php
    } else {
        // Manejar el caso en que no se proporciona el ID de la carta
        echo "No se proporcionó un ID de carta válido.";
    }
    ?>
</body>
</html>
    