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


// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}

// Función para verificar las credenciales de inicio de sesión
function verificarCredenciales($conn, $username, $password)
{
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    $query = "SELECT user_id FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        return $row['user_id'];
    } else {
        return false;
    }
}

// Manejar el inicio de sesión
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user_id = verificarCredenciales($conn, $username, $password);

    if ($user_id !== false) {
        // Iniciar sesión y redireccionar al dashboard
        $_SESSION['loggedin'] = true;
		$_SESSION['user_id'] = $user_id;
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;

		header('Location: welcome.php');

    } else {
        $loginError = "Usuario o contraseña incorrectos.";
    }
}

// Cerrar conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Iniciar Sesión</h1>

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
                <button type="submit" name="login" class="btn btn-primary">Iniciar Sesión</button>
            </div>
        </form>

        <?php if (isset($loginError)): ?>
            <p class="text-danger mt-3"><?php echo $loginError; ?></p>
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
