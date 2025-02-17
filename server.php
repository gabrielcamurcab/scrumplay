<?php

require 'vendor/autoload.php';
require 'config/database.php';
require 'bootstrap.php';

date_default_timezone_set('America/Sao_Paulo');

use App\WebSocket\WebSocketHandler;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use React\Socket\SocketServer;
use React\EventLoop\Loop;

$webSocketHandler = $container->get(WebSocketHandler::class);

$loop = Loop::get();
$server = new IoServer(
    new HttpServer(
        new WsServer($webSocketHandler)
    ),
    new SocketServer('0.0.0.0:8080', [], $loop),
    $loop
);

echo "Servidor rodando...\n";
$server->run();
