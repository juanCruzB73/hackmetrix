<?php
session_start();

// Conectar a la base de datos o crearla si no existe
$conn = mysqli_connect('127.0.0.1', 'sha16', 'H4ckm3tr1x_4c4d3my_1234#');
mysqli_query($conn, 'CREATE DATABASE IF NOT EXISTS app_db');
mysqli_select_db($conn, 'app_db');

// Crear la tabla de usuarios si no existe
$createUsersTableQuery = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
)";
mysqli_query($conn, $createUsersTableQuery);

// Crear la tabla de notas si no existe
$createNotesTableQuery = "CREATE TABLE IF NOT EXISTS notes (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    is_public TINYINT(1) NOT NULL DEFAULT 0,
    user_id INT(11) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
)";
mysqli_query($conn, $createNotesTableQuery);

// Verificar si el usuario está autenticado
if (isset($_SESSION['username'])) {
    // Si está autenticado, redirigir a welcome.php
    header("Location: welcome.php");
    exit();
}

// Mensajes de error de registro y autenticación
$registerError = '';
$loginError = '';

// Procesar el formulario de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    // Obtener los datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Verificar si las contraseñas coinciden
    if ($password === $confirmPassword) {
        // Verificar si el usuario ya existe en la base de datos
        $checkUserQuery = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $checkUserQuery);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) === 0) {
            // Insertar el nuevo usuario en la base de datos
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertUserQuery = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $insertUserQuery);
            mysqli_stmt_bind_param($stmt, "ss", $username, $hashedPassword);
            mysqli_stmt_execute($stmt);

            // Mensaje de registro exitoso
            $registrationMessage = "Usuario registrado exitosamente";
        } else {
            $registerError = 'El nombre de usuario ya está registrado';
        }
    } else {
        $registerError = 'Las contraseñas no coinciden';
    }
}

// Procesar el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    // Obtener los datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Buscar el usuario en la base de datos
    $checkUserQuery = "SELECT id, password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $checkUserQuery);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) === 1) {
        mysqli_stmt_bind_result($stmt, $userId, $hashedPassword);
        if (mysqli_stmt_fetch($stmt) && password_verify($password, $hashedPassword)) {
            // Autenticación exitosa, iniciar sesión
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $userId;
            $_SESSION['username'] = $username;

            header('Location: welcome.php');
            exit;
        }
    }

    $loginError = 'Nombre de usuario o contraseña incorrectos';
}

// Cerrar la conexión
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inicio</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Bienvenido a la Aplicación</h1>
        <h2 class="mt-4">Registro</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Nombre de Usuario:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirmar Contraseña:</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
            </div>
            <div>
                <button type="submit" name="register" class="btn btn-primary">Registrarse</button>
            </div>
        </form>
        <?php if ($registerError !== ''): ?>
            <p class="text-danger"><?php echo $registerError; ?></p>
        <?php endif; ?>
        <?php if (isset($registrationMessage)): ?>
            <p class="text-success"><?php echo $registrationMessage; ?></p>
        <?php endif; ?>
        <h2 class="mt-4">Iniciar Sesión</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="login_username">Nombre de Usuario:</label>
                <input type="text" id="login_username" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="login_password">Contraseña:</label>
                <input type="password" id="login_password" name="password" class="form-control" required>
            </div>
            <div>
                <button type="submit" name="login" class="btn btn-primary">Iniciar Sesión</button>
            </div>
        </form>
        <?php if ($loginError !== ''): ?>
            <p class="text-danger"><?php echo $loginError; ?></p>
        <?php endif; ?>
    </div>

	<div class="text-center mt-4">
		<a href="app_src.zip" download class="btn btn-danger">Descargar código fuente</a>
	</div>
</body>
</html>
