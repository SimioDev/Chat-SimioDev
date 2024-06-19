<?php
include('templates/header.php');
include('db.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->query('SELECT * FROM chats');
$chats = $stmt->fetchAll();

$current_chat = null;
if (isset($_GET['chat_id'])) {
    $chat_id = $_GET['chat_id'];
    $stmt = $pdo->prepare('SELECT * FROM chats WHERE id = ?');
    $stmt->execute([$chat_id]);
    $current_chat = $stmt->fetch();
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <h4>Crear Nuevo Chat</h4>
            <form id="createChatForm">
                <div class="form-group">
                    <label for="chatName">Nombre del Chat:</label>
                    <input type="text" class="form-control" id="chatName" name="chatName" placeholder="Nombre del chat que quieres crear..." required>
                </div>
                <button type="submit" class="btn btn-success">Crear Chat</button>
            </form>
            <h4 class="mt-4">Chats Disponibles</h4>
            <ul id="chatList" class="list-group">
                <?php foreach ($chats as $chat): ?>
                    <li class="list-group-item <?php echo isset($current_chat) && $current_chat['id'] == $chat['id'] ? 'active-chat' : ''; ?>">
                        <a href="chat.php?chat_id=<?php echo $chat['id']; ?>"><?php echo $chat['name']; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-md-8">
            <?php if (isset($current_chat)): ?>
                <div id="chatWindow" class="border rounded p-3">
                    <h4><?php echo htmlspecialchars($current_chat['name']); ?></h4>
                    <div id="messages" class="border rounded p-2 mb-3" style="height: 400px; overflow-y: scroll;"></div>
                    <form id="messageForm" class="d-flex">
                        <input type="hidden" id="user_id" value="<?php echo $user_id; ?>">
                        <input type="text" class="form-control mr-2" id="message" name="message" placeholder="Escribe tu mensaje..." required>
                        <button type="submit" class="btn btn-success">Enviar</button>
                    </form>
                </div>
            <?php else: ?>
                <p>Selecciona un chat para empezar a chatear.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include('templates/footer.php'); ?>
