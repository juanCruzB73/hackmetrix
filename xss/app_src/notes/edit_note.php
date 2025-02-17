<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

// Obtener el ID de la nota a editar
if (!isset($_GET['id'])) {
    header('Location: notes.php');
    exit;
}
$noteId = $_GET['id'];

// Conectar a la base de datos
$conn = mysqli_connect('127.0.0.1', 'sha16', 'H4ckm3tr1x_4c4d3my_1234#', 'app_db');

// Obtener la nota actual del usuario
$userId = $_SESSION['user_id'];
$getNoteQuery = "SELECT * FROM notes WHERE id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $getNoteQuery);
mysqli_stmt_bind_param($stmt, "ii", $noteId, $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$note = mysqli_fetch_assoc($result);

// Verificar si la nota existe y pertenece al usuario
if (!$note) {
    header('Location: notes.php');
    exit;
}

// Mensaje de éxito al editar la nota
$updateNoteSuccess = '';

// Procesar el formulario de edición de la nota
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_note'])) {
    // Obtener los datos del formulario
    $content = $_POST['content'];
    $isPublic = isset($_POST['is_public']) ? 1 : 0;

    // Actualizar la nota en la base de datos
    $updateNoteQuery = "UPDATE notes SET content = ?, is_public = ? WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $updateNoteQuery);
    mysqli_stmt_bind_param($stmt, "siii", $content, $isPublic, $noteId, $userId);
    mysqli_stmt_execute($stmt);

    // Mensaje de éxito al editar la nota
    $updateNoteSuccess = 'La nota ha sido editada exitosamente';
}

// Cerrar la conexión
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Nota</title>
    <!-- Agrega el enlace a Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <div class="container mt-5">
        <h1 class="mb-4">Editar Nota</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="content" class="form-label">Contenido:</label>
                <textarea id="content" name="content" class="form-control" rows="4" required><?php echo $note['content']; ?></textarea>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="is_public" name="is_public" <?php if ($note['is_public'] === 1) echo 'checked'; ?>>
                <label for="is_public" class="form-check-label">Pública</label>
            </div>
            <button type="submit" name="edit_note" class="btn btn-primary">Guardar Cambios</button>
        </form>
        <?php if ($updateNoteSuccess !== ''): ?>
            <p class="mt-3"><?php echo $updateNoteSuccess; ?></p>
        <?php endif; ?>
    </div>

    <!-- Agrega el enlace a Bootstrap JS (opcional, solo si necesitas componentes interactivos de Bootstrap) -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
</body>
</html>


<!--
<!DOCTYPE html>
<html>
<head>
    <title>Editar Nota</title>
</head>
<body>
    <h1>Editar Nota</h1>
    <form method="POST" action="">
        <div>
            <label for="content">Contenido:</label>
            <textarea id="content" name="content" rows="4" cols="50" required><?php echo $note['content']; ?></textarea>
        </div>
        <div>
            <label for="is_public">Pública:</label>
            <input type="checkbox" id="is_public" name="is_public" <?php if ($note['is_public'] === 1) echo 'checked'; ?>>
        </div>
        <div>
            <button type="submit" name="edit_note">Guardar Cambios</button>
        </div>
    </form>
    <?php if ($updateNoteSuccess !== ''): ?>
        <p><?php echo $updateNoteSuccess; ?></p>
    <?php endif; ?>
</body>
</html>
-->
