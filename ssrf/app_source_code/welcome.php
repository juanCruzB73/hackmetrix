        <?php
            session_start();
            if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
                header('Location: index.php');
                exit;
            }
        ?>

        <!DOCTYPE html>
        <html>
        <head>
            <title>Buscador de evidencias</title>
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        </head>
        <body>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <b><a class="navbar-brand" href="welcome.php">HM Exploits</a></b>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="welcome.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="container">
                <h1 class="mt-5">Buscador de Evidencias</h1>
                <form method="POST" action="">
                    <div class="form-group">
                        <input type="text" name="evidence" class="form-control" placeholder='URL de la evidencia...'>
                    </div>
                    <button class="btn btn-primary">Search</button>
                </form>

                <?php
                    function errorHandler($errno, $errstr, $errfile, $errline) {
                        if (error_reporting() === 0) {
                            return; // Este error fue desencadenado por un @
                        }
                        
                        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
                    }
                    
                    // Establecer el manejador de errores personalizado
                    set_error_handler("errorHandler");
                    
                    if (isset($_POST["evidence"])) {
                        $evidence = strtolower($_POST["evidence"]);
                        
                        if (strpos($evidence, "http://") === 0 || strpos($evidence, "https://") === 0) {
                            if (!stripos($evidence, '.php')) {
                                try {			
                                    include($evidence);
                                } catch (Exception $e) {
                                    echo "<br><pre>Internal Server Error</pre>";
                                }
                            } else {
                                echo "<br><pre>Internal Server Error</pre>";	
                            }
                        } else {
                            echo "<br><pre>Internal Server Error</pre>";
                        }
                    }   
                ?>
                <div class="row mt-4">
                <?php
                    $servername = "127.0.0.1";
                    $username = "sha16";
                    $password = "H4ck_th3_w0rld#";
                    $dbname = "app_db";

                    // Crear conexión
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Verificar conexión
                    if ($conn->connect_error) {
                        die("La conexión a la base de datos falló: " . $conn->connect_error);
                    }

                    // Consulta para seleccionar todos los registros de la tabla images
                    $selectQuery = "SELECT user_id, image_name, path FROM images";
                    $result = $conn->query($selectQuery);

                    if ($result->num_rows > 0) {
                        // Mostrar los registros encontrados
                        while ($row = $result->fetch_assoc()) {
                            $userId = htmlspecialchars($row['user_id']);
                            $getUserQuery = "SELECT username FROM users WHERE user_id = ?";
                            $stmt = mysqli_prepare($conn, $getUserQuery);
                            mysqli_stmt_bind_param($stmt, "i", $userId);
                            mysqli_stmt_execute($stmt);
                            $userNotesResult = mysqli_stmt_get_result($stmt);

                            if ($userNotesResult->num_rows > 0) {
                                while ($row_user = $userNotesResult->fetch_assoc()) {
                                    $userAuthor = htmlspecialchars($row_user['username']); 
                                }
                            }
                    
                            $nombreImagen = htmlspecialchars($row['image_name']);
                            $rutaImagen = htmlspecialchars($row['path']);
                            echo "<div class='col-md-4 mb-4'>";
                            echo "<div class='card'>";
                            echo "<img src='$rutaImagen' alt='Imagen' class='card-img-top' style='height: 200px; object-fit: cover;'>";
                            echo "<div class='card-body'>";
                            echo "<h5 class='card-title'>$nombreImagen</h5>";
                            echo "<p class='card-text'>Creada por $userAuthor</p>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                    }

                    // Cerrar conexión a la base de datos
                    $conn->close();
                        
                ?>
                </div>
            </div>

            <!-- Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </body>
        </html>
