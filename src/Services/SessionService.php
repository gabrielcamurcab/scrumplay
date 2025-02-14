<?php

namespace App\Services;

use App\Repositories\SessionRepository;
use App\Models\Session;

class SessionService {
    protected $sessionRepo;

    public function __construct(SessionRepository $sessionRepo) 
    {
        $this->sessionRepo = $sessionRepo;
    }

    public function createSession(string $poName): ?Session 
    {
        $session = new Session($poName);

        if ($this->sessionRepo->createSession($session)) {
            return $session;
        }

        return null;
    }
}