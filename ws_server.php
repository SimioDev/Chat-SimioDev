<?php
require 'vendor/autoload.php';
include('db.php');

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = [];
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients[$conn->resourceId] = $conn;
        echo "Nueva conexión! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);

        if (isset($data['chat_id']) && isset($data['message'])) {
            global $pdo;
            $chat_id = $data['chat_id'];
            $message = $data['message'];
            $user_id = $data['user_id'];

            // Obtener el nombre de usuario
            $stmt = $pdo->prepare('SELECT username FROM users WHERE id = ?');
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();

            if ($user) {
                $username = $user['username'];
                $msg_data = json_encode([
                    'chat_id' => $chat_id,
                    'username' => $username,
                    'message' => $message
                ]);

                foreach ($this->clients as $client) {
                    $client->send($msg_data);
                }
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        unset($this->clients[$conn->resourceId]);
        echo "Conexión {$conn->resourceId} cerrada\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Ocurrió un error: {$e->getMessage()}\n";
        $conn->close();
    }
}

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    8080
);

$server->run();
