<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

// Conectar a la base de datos
$conn = mysqli_connect('127.0.0.1', 'sha16', 'H4ckm3tr1x_4c4d3my_1234#', 'app_db');

// Verificar la conexión a la base de datos
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Obtener todas las notas públicas
$getPublicNotesQuery = "SELECT users.username, notes.content
                       FROM notes
                       INNER JOIN users ON notes.user_id = users.id
                       WHERE notes.is_public = 1";
$publicNotesResult = mysqli_query($conn, $getPublicNotesQuery);

// Obtener el nombre de usuario del usuario actual
$currentUser = $_SESSION['username'];

// Cerrar la conexión
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bienvenido</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Mis Notas</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="welcome.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="notes.php">Mis Notas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h1 class="mt-5">Bienvenido, <?php echo $currentUser; ?>!</h1>
        <h2 class="mt-4">Notas Públicas</h2>
        <?php while ($note = mysqli_fetch_assoc($publicNotesResult)): ?>
            <div class="border p-3 my-3">
                <p><?php echo $note['content']; ?></p>
                <p>Creado por: <?php echo $note['username']; ?></p>
            </div>
        <?php endwhile; ?>
        <p><a href="notes.php" class="btn btn-primary">Mis Notas</a></p>
        <p><a href="logout.php" class="btn btn-danger">Cerrar Sesión</a></p>
    </div>
</body>
</html>
