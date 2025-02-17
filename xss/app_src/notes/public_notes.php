<?php
include 'navbar.php';
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

// Cerrar la conexión
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notas Públicas</title>
</head>
<body>
    <h1>Notas Públicas</h1>
    <?php while ($note = mysqli_fetch_assoc($publicNotesResult)): ?>
        <div>
            <p><?php echo $note['content']; ?></p>
            <p>Creado por: <?php echo $note['username']; ?></p>
        </div>
    <?php endwhile; ?>
    <p><a href="welcome.php">Volver</a></p>
</body>
</html>
