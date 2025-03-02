<?php
session_start();

if (isset($_SESSION['loggedin'])) {
        if ($_SESSION['loggedin'] === true) {
        header('Location: welcome.php');
        exit;
    }
}

$servername = "127.0.0.1";
$username = "sha16";
$password = "H4ck_th3_w0rld#";
$dbname = "app_db";

// Crear conexión
$conn = new mysqli($servername, $username, $password);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}

// Consulta para crear la base de datos si no existe
$createDBQuery = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($createDBQuery) === TRUE) {
    // Seleccionar la base de datos
    $conn->select_db($dbname);

    // Consulta para crear la tabla de usuarios si no existe
    $createUsersTableQuery = "CREATE TABLE IF NOT EXISTS users (
        user_id INT(11) AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL
    )";
    if ($conn->query($createUsersTableQuery) === TRUE) {
    } else {
        echo "Error al crear la tabla 'users': " . $conn->error;
    }

    // Consulta para crear la tabla de imágenes si no existe
    $createImagesTableQuery = "CREATE TABLE IF NOT EXISTS images (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        user_id INT(11) NOT NULL,
        image_name VARCHAR(255) NOT NULL,
        path VARCHAR(255) NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(user_id)
    )";
    if ($conn->query($createImagesTableQuery) === TRUE) {
    } else {
        echo "Error al crear la tabla 'images': " . $conn->error;
    }
} else {
    echo "Error al crear la base de datos: " . $conn->error;
}

// Cerrar conexión a la base de datos
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bienvenido a la Aplicación</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Bienvenido a <b>Hackmetrix Academy</b></h1>
        <p class="mt-3">¡Gracias por unirte a nuestra comunidad!</p>
        <p>Por favor, inicia sesión o regístrate para empezar encontrar las flags.</p>
		<div class="mt-3">
		    <a href="login.php" class="btn btn-primary mr-2">Iniciar Sesión</a>
		    <a href="register.php" class="btn btn-primary">Registrarse</a>
		    <a href="app_source_code.zip" class="btn btn-danger ml-2">Descargar Código Fuente</a>
		</div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
