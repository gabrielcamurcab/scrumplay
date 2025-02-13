<?php

require 'vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use React\EventLoop\Loop;
use React\Socket\SocketServer;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class ScrumPlayServer implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "Nova conexão: ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        echo "Mensagem recebida de ({$from->resourceId}): $msg\n";

        foreach ($this->clients as $client) {
            if ($client !== $from) {
                $client->send("Usuário {$from->resourceId} disse: $msg");
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Conexão encerrada: ({$conn->resourceId})\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Erro na conexão ({$conn->resourceId}): {$e->getMessage()}\n";
        $conn->close();
    }
}

$loop = Loop::get();
$server = new IoServer(
    new HttpServer(
        new WsServer(
            new ScrumPlayServer()
        )
    ),
    new SocketServer('0.0.0.0:8080', [], $loop),
    $loop
);

echo "Servidor WebSocket rodando na porta 8080...\n";
$server->run();