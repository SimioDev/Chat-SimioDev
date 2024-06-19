<?php
include('db.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
    $stmt->execute([$username, $email, $password]);

    header('Location: login.php');
    exit();
}
?>

<?php include('templates/header.php'); ?>

<div class="container mt-5">
    <h2>Registrarse</h2>
    <form method="POST" action="register.php" class="mt-4">
        <div class="form-group">
            <label for="username">Nombre de Usuario:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-success">Registrarse</button>
    </form>
</div>

<?php include('templates/footer.php'); ?>
