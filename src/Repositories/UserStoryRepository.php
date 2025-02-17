<?php

namespace App\Repositories;

use PDO;
use App\Models\UserStory;

class UserStoryRepository
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createUserStory(UserStory $userStory): bool {
        $stmt = $this->pdo->prepare("INSERT INTO user_storys (ord, session_id, title, description) VALUES (:ord, (SELECT id FROM sessions WHERE uuid = :session_id), :title, :description)");

        return $stmt->execute([
            ':ord' => $userStory->getOrd(),
            ':session_id' => $userStory->getSessionId(),
            ':title' => $userStory->getTitle(),
            ':description' => $userStory->getDescription()
        ]);
    }
}
