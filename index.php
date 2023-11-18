<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tareas</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">    
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        body{
            background: #4e2ca7;
            color: #FFF;
        }
    </style>    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        .tareas-lista {
            list-style-type: none;
            padding: 0;
        }

        .tarea {
            margin-bottom: 10px;
        }

        .acciones {
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <h1>Gestión de Tareas</h1>


        <label for="rol">Selecciona un rol:</label>
        <select id="rol" name="rol">
            <option value="Aprendiz">Aprendiz</option>
            <option value="Maestro">Maestro</option>
        </select>

        <label for="descripcion">Descripción de la Tarea:</label>
        <input type="text" id="descripcion" name="descripcion" required>
        
        <button onclick="agregarTarea()"> Agregar Tarea </button>
    <h2>Lista de Tareas</h2>
    <div id="tabla-container">
<table border="1">
    <thead>
        <tr>
            <th>Codigo</th>
            <th>Descripcion</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Conéctate a la base de datos (asegúrate de tener esta parte en tu código)
        $servername = "localhost";
        $username = "id21471118_a";
        $password = "Andres123**";
        $dbname = "id21471118_tareas";
    

        $conexion = new mysqli($servername, $username, $password, $dbname);

        // Verifica la conexión
        if ($conexion->connect_error) {
            die("La conexión a la base de datos ha fallado: " . $conexion->connect_error);
        }

        // Realiza la consulta SQL para obtener las tareas
        $result = $conexion->query("SELECT * FROM tareas");

       
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['Codigo'] . '</td>';
            echo '<td>' . $row['Descripcion'] . '</td>';
            echo '<td>' . $row['Estado'] . '</td>';
            echo '<td>';
            echo '<button class="btn btn-primary" onclick="marcarTarea(' . $row['Codigo'] . ')">Marcar</button>';
            echo '<button class="btn btn-danger" onclick="eliminarTarea(' . $row['Codigo'] . ')">Eliminar</button>';
            echo '</td>';
            echo '</tr>';
        }

        // Cierra la conexión a la base de datos
        $conexion->close();
        ?>
    </tbody>
</table>
</div>

<script>


    
    function agregarTarea(){

        
        // Obtiene los valores del formulario
        var rolSeleccionado = document.getElementById('rol').value;
        var accion = 'crear';
        var descripcion = document.getElementById('descripcion').value;

        // Realiza la solicitud asíncrona
        fetch('insertar_tarea.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'rol=' + encodeURIComponent(rolSeleccionado) +
                '&accion=' + encodeURIComponent(accion) +
                '&descripcion=' + encodeURIComponent(descripcion),
        })
        .then(response => response.text())
        .then(data => {
            console.log(data); // Maneja la respuesta del servidor si es necesario
            actualizarTabla(); // Actualiza la tabla después de realizar la inserción
        })
        .catch(error => {
            console.error('Error al realizar la solicitud:', error);
        });
    }


    function marcarTarea(codigo) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "marcar_tarea.php", true); 
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        
        if (xhr.status === 200) {
            console.log(xhr.responseText);
            location.reload();
        }
    };
        xhr.send("codigo=" + codigo);
    }

    function eliminarTarea(codigo) {
    var rolSelect = document.getElementById("rol");
    var rolSeleccionado = rolSelect.options[rolSelect.selectedIndex].value;

    if (rolSeleccionado == 'Maestro'){
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "eliminar_tarea.php", true); 
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            
            if (xhr.status === 200) {

                console.log(xhr.responseText);
                location.reload();
            }
        };
        xhr.send("codigo=" + codigo);
    }else{
        alert('Los Aprendices no pueden eliminar tarea!')

    }
    
    }

    function actualizarTabla() {
    // Crea una instancia de XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Configura la solicitud
    xhr.open("GET", "obtener_tareas.php", true); // Ajusta "obtener_tareas.php" con la ruta correcta a tu script PHP
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // Define la función a ejecutar cuando la solicitud se complete con éxito
    xhr.onload = function() {
        if (xhr.status === 200) {
            
            document.getElementById('tabla-container').innerHTML = xhr.responseText;
        }
    };

    // Envía la solicitud
    xhr.send();
}

</script>

</body>
</html>
