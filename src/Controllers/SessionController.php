<?php

namespace App\Controllers;

use App\Services\SessionService;

class SessionController {
    protected $service;

    public function __construct(SessionService $service) 
    {
        $this->service = $service;
    }

    public function handleCreateSession(array $data): array {
        if (!isset($data['po_name'])) {
            return ['status' => 'error', 'message' => 'Nome do PO é obrigatório'];
        }

        $session = $this->service->createSession($data['po_name']);

        if (!$session) {
            return ['status' => 'error', 'message' => 'Erro ao criar sessão'];
        }

        return [
            'status' => 'success',
            'message' => 'Sessão criada com sucesso',
            'session' => [
                'uuid' => $session->uuid,
                'po_name' => $session->poName,
                'date' => $session->date,
                'start_time' => $session->startTime
            ]
        ];
    }
}