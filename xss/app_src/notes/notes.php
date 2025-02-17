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

// Obtener el ID del usuario actual
$userId = $_SESSION['user_id'];

// Obtener todas las notas del usuario actual
$getNotesQuery = "SELECT id, content, is_public FROM notes WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $getNotesQuery);
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$notesResult = mysqli_stmt_get_result($stmt);

// Mensaje de éxito o error de creación de nota
$noteCreationMessage = '';

// Procesar el formulario de creación de nota
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_note'])) {
    // Obtener el contenido y la visibilidad de la nota
    $content = $_POST['content'];
    $isPublic = isset($_POST['is_public']) ? 1 : 0;

    // Insertar la nota en la base de datos
    $insertNoteQuery = "INSERT INTO notes (content, is_public, user_id) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertNoteQuery);
    mysqli_stmt_bind_param($stmt, "sii", $content, $isPublic, $userId);
    if (mysqli_stmt_execute($stmt)) {
        $noteCreationMessage = 'Nota creada con éxito';
    } else {
        $noteCreationMessage = 'Error al crear la nota';
    }
}

// Cerrar la conexión
mysqli_close($conn);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Mis Notas</title>
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
        <h1 class="mt-4">Crear Notas</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="content">Contenido:</label>
                <textarea id="content" name="content" class="form-control" required></textarea>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" id="is_public" name="is_public" value="1" class="form-check-input">
                <label for="is_public" class="form-check-label">Pública</label>
            </div>
            <div>
                <button type="submit" name="create_note" class="btn btn-primary">Crear Nota</button>
            </div>
        </form>
        <?php if ($noteCreationMessage !== ''): ?>
            <div class="mt-4 alert alert-success"><?php echo $noteCreationMessage; ?></div>
        <?php endif; ?>
        <h2 class="mt-4">Mis Notas</h2>
        <?php while ($note = mysqli_fetch_assoc($notesResult)): ?>
            <div class="card mt-4">
                <div class="card-body">
                    <p><?php echo $note['content']; ?></p>
                    <?php if ($note['is_public'] == 1): ?>
                        <p>Esta nota es pública</p>
                    <?php else: ?>
                        <p>Esta nota es privada</p>
                    <?php endif; ?>
                    <button class="btn btn-primary" onclick="window.location.href='edit_note.php?id=<?php echo $note['id']; ?>'">Editar</button>
                    <button class="btn btn-danger" onclick="window.location.href='delete_note.php?id=<?php echo $note['id']; ?>'">Eliminar</button>
                </div>
            </div>
        <?php endwhile; ?>
        <p class="mt-4"><a href="welcome.php">Volver</a></p>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
