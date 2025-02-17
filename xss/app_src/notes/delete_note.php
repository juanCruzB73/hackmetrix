<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

// Verificar si se ha recibido el ID de la nota
if (isset($_GET['id'])) {
    // Obtener el ID de la nota a eliminar
    $noteId = $_GET['id'];

    // Conectar a la base de datos
    $conn = mysqli_connect('127.0.0.1', 'sha16', 'H4ckm3tr1x_4c4d3my_1234#', 'app_db');

    // Verificar si la nota pertenece al usuario actual
    $userId = $_SESSION['user_id'];
    $checkNoteQuery = "SELECT id FROM notes WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $checkNoteQuery);
    mysqli_stmt_bind_param($stmt, "ii", $noteId, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) === 1) {
        // Eliminar la nota de la base de datos
        $deleteNoteQuery = "DELETE FROM notes WHERE id = ?";
        $stmt = mysqli_prepare($conn, $deleteNoteQuery);
        mysqli_stmt_bind_param($stmt, "i", $noteId);
        mysqli_stmt_execute($stmt);

        // Redirigir al usuario al panel de notas
        header('Location: notes.php');
        exit;
    }
}

// Si no se pudo eliminar la nota o no se proporcionó un ID válido, redirigir al panel de notas con un mensaje de error
header('Location: notes.php?error=1');
exit;
