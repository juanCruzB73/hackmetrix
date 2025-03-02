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

$conn->close();

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}

// Función para verificar si el nombre de usuario ya está registrado
function verificarNombreUsuario($conn, $username)
{
    $username = $conn->real_escape_string($username);

    $query = "SELECT user_id FROM users WHERE username='$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

// Manejar el registro de usuario
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificar si el nombre de usuario ya está registrado
    if (verificarNombreUsuario($conn, $username)) {
        $registerError = "El nombre de usuario ya está registrado. Por favor, elige otro.";
    } else {
        $username = $conn->real_escape_string($username);
        $password = $conn->real_escape_string($password);

        // Insertar el nuevo usuario en la base de datos
        $insertQuery = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if ($conn->query($insertQuery) === TRUE) {
            $registrationMessage = "Usuario registrado exitosamente.";
        } else {
            $registerError = "Error al registrar el usuario: " . $conn->error;
        }
    }
}

// Cerrar conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Registro</h1>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Nombre de Usuario:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="mt-4">
                <button type="submit" name="register" class="btn btn-primary">Registrarse</button>
            </div>
        </form>

        <?php if (isset($registerError)): ?>
            <p class="text-danger mt-3"><?php echo $registerError; ?></p>
        <?php endif; ?>
        <?php if (isset($registrationMessage)): ?>
            <p class="text-success mt-3"><?php echo $registrationMessage; ?></p>
        <?php endif; ?>

        <div class="mt-3">
            <a href="index.php">Volver</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
