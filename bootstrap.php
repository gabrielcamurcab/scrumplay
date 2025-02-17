<?php

require 'vendor/autoload.php';
require 'config/database.php';

use DI\ContainerBuilder;
use App\WebSocket\WebSocketHandler;
use App\Controllers\SessionController;
use App\Controllers\UserStoryController;
use App\Models\UserStory;
use App\Services\SessionService;
use App\Services\UserStoryService;
use App\Repositories\SessionRepository;
use App\Repositories\UserStoryRepository;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    SessionRepository::class => function() use ($pdo) {
        return new SessionRepository($pdo);
    },
    SessionService::class => function($container) {
        return new SessionService($container->get(SessionRepository::class));
    },
    SessionController::class => function($container) {
        return new SessionController($container->get(SessionService::class));
    },
    UserStoryRepository::class => function() use ($pdo) {
        return new UserStoryRepository($pdo);
    },
    UserStoryService::class => function($container) {
        return new UserStoryService($container->get(UserStoryRepository::class));
    },
    UserStoryController::class => function($container) {
        return new UserStoryController($container->get(UserStoryService::class));
    },
    WebSocketHandler::class => function($container) {
        return new WebSocketHandler(
            $container->get(SessionController::class),
            $container->get(UserStoryController::class)
        );
    }
]);

$container = $containerBuilder->build();