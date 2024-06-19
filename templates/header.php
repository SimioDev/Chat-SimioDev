<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SimioChat - WebSocket</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="shortcut icon" href="https://images.vexels.com/content/228660/preview/monkey-ape-logo-9e8c9a.png">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">SimioChat - WebSocket</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <?php
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                if (isset($_SESSION['user_id'])) {
                    echo '<li class="nav-item"><a class="nav-link" href="chat.php">Chats</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="logout.php">Cerrar sesión</a></li>';
                } else {
                    echo '<li class="nav-item"><a class="nav-link" href="login.php">Iniciar sesión</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="register.php">Registrarse</a></li>';
                }
                ?>
            </ul>
        </div>
    </nav>
</body>
</html>
