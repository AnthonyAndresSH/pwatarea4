<?php
// Configura tu conexión a la base de datos
$servername = "localhost";
$username = "id21471118_a";
$password = "Andres123**";
$dbname = "id21471118_tareas";

$conexion = new mysqli($servername, $username, $password, $dbname);

if ($conexion->connect_error) {
    die("La conexión a la base de datos ha fallado: " . $conexion->connect_error);
}

// Realiza la consulta SQL para obtener las tareas
$result = $conexion->query("SELECT * FROM tareas");

// Construye el HTML de la tabla con las tareas recuperadas
$html = '<table border="1">
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Descripcion</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>';

while ($row = $result->fetch_assoc()) {
    $html .= '<tr>';
    $html .= '<td>' . $row['Codigo'] . '</td>';
    $html .= '<td>' . $row['Descripcion'] . '</td>';
    $html .= '<td>' . $row['Estado'] . '</td>';
    $html .= '<td>';
    $html .= '<button class="btn btn-primary" onclick="marcarTarea(' . $row['Codigo'] . ')">Marcar</button>';
    $html .= '<button class="btn btn-danger" onclick="eliminarTarea(' . $row['Codigo'] . ')">Eliminar</button>';
    $html .= '</td>';
    $html .= '</tr>';
}

$html .= '</tbody></table>';


echo $html;


$conexion->close();
?>
