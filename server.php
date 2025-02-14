<?php

require 'vendor/autoload.php';
require 'config/database.php';

date_default_timezone_set('America/Sao_Paulo');

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use React\Socket\SocketServer;
use React\EventLoop\Loop;
use App\WebSocket\WebSocketHandler;
use App\Controllers\SessionController;
use App\Services\SessionService;
use App\Repositories\SessionRepository;

$sessionRepo = new SessionRepository($pdo);
$sessionService = new SessionService($sessionRepo);
$sessionController = new SessionController($sessionService);
$webSocketHandler = new WebSocketHandler($sessionController);

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
