<?php
// Conecta a la base de datos (asegúrate de tener esta parte en tu código)
$servername = "localhost";
$username = "id21471118_a";
$password = "Andres123**";
$dbname = "id21471118_tareas";

$conexion = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conexion->connect_error) {
    die("La conexión a la base de datos ha fallado: " . $conexion->connect_error);
}

// Obtén el código de la tarea de la solicitud AJAX
$codigo = $_POST['codigo'];

// Actualiza el estado de la tarea a "Completada"
$sql = "UPDATE tareas SET Estado='Completada' WHERE Codigo=$codigo";

// Ejecuta la consulta
if ($conexion->query($sql) === TRUE) {
    echo "Tarea marcada como completada con éxito";
} else {
    echo "Error al marcar la tarea como completada: " . $conexion->error;
}

// Cierra la conexión a la base de datos
$conexion->close();
?>
