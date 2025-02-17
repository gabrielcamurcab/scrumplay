<?php

namespace App\Controllers;

use App\Services\UserStoryService;

class UserStoryController {
    protected $service;

    public function __construct(UserStoryService $service)
    {
        $this->service = $service;
    }

    public function handleCreateUserStory(array $data): array {
        $requiredFields = ['ord', 'session_id', 'title', 'description'];
        $missingFields = array_diff_key(array_flip($requiredFields), $data);

        if ($missingFields) {
            $missingFieldsString = implode(', ', array_keys($missingFields));
            return ['status' => 'error', 'message' => "O(s) campo(s) $missingFieldsString estão faltando."];
        }

        $userStory = $this->service->createUserStory($data['ord'], $data['session_id'], $data['title'], $data['description']);

        if (!$userStory) {
            return ['status' => 'error', 'message' => 'Erro ao criar User Story'];
        }

        return [
            'status' => 'success',
            'message' => 'User Story cadastrado com sucesso!'
        ];
    }
}