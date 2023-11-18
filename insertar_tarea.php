<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rolSeleccionado = $_POST['rol'];
    $accion = $_POST['accion'];
    $descripcion = $_POST['descripcion'];

    // Configura tu conexión a la base de datos
    $servername = "localhost";
    $username = "id21471118_a";
    $password = "Andres123**";
    $dbname = "id21471118_tareas";

    $conexion = new mysqli($servername, $username, $password, $dbname);

    if ($conexion->connect_error) {
        die("La conexión a la base de datos ha fallado: " . $conexion->connect_error);
    }

    $descripcion = $conexion->real_escape_string($descripcion);
    $estadoInicial = 'Pendiente';  // Estado por defecto al crear una tarea

    $sql = "INSERT INTO tareas (Descripcion, Estado) VALUES ('$descripcion', '$estadoInicial')";

    if ($conexion->query($sql) === TRUE) {
        echo "Tarea creada con éxito";
    } else {
        echo "Error al crear la tarea: " . $conexion->error;
    }

    $conexion->close();
}
?>
