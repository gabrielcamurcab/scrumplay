<?php

namespace App\WebSocket;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use App\Controllers\SessionController;

class WebSocketHandler implements MessageComponentInterface
{
    protected $clients;
    protected $sessionController;
    protected $rooms;

    public function __construct(SessionController $sessionController)
    {
        $this->clients = new \SplObjectStorage;
        $this->sessionController = $sessionController;
        $this->rooms = [];
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "Nova conexão! $conn->resourceId";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);

        if (!$data || !isset($data['action'])) {
            $from->send(json_encode(['status' => 'error', 'message' => 'Ação Inválida!'], JSON_UNESCAPED_UNICODE));
            return;
        }

        switch ($data['action']) {
            case 'create_room':
                $this->createRoom($from, $data);
                break;
            #case 'join_room':
                #$this->joinRoom($from, $data['session_id']);
                #break;
            #case 'send_message':
                #$this->sendMessage($from, $data['session_id'], $data['message']);
                #break;
            default:
                $from->send(json_encode(['status' => 'error', 'message' => 'Ação não reconhecida!'], JSON_UNESCAPED_UNICODE));
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Nova decconexão! $conn->resourceId";
    }

    public function createRoom($conn, $data) {
        $session = $this->sessionController->handleCreateSession($data);
        $session_id = $session['session']['uuid'];
        $po_name = $data['po_name'];

        $this->rooms[$session['session']['session']];
        echo "Room criada para sessão $session_id por $po_name ({$conn->resourceId})\n";
        $conn->send(json_encode([
            'success' => "Room $session_id criada!",
            'session_id' => $session_id
        ]));
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Erro: " . $e->getMessage() . "\n";
        $conn->close();
    }
}