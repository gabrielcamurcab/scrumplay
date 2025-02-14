<?php

namespace App\Repositories;

use PDO;
use App\Models\Session;

class SessionRepository {
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createSession(Session $session): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO sessions (uuid, po_name, date, start_time) VALUES (:uuid, :po_name, :date, :start_time)");

        return $stmt->execute([
            ':uuid' => $session->uuid,
            ':po_name' => $session->poName,
            ':date' => $session->date,
            ':start_time' => $session->startTime
        ]);
    }
}