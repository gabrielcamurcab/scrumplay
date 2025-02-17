<?php

namespace App\Services;

use App\Repositories\UserStoryRepository;
use App\Models\UserStory;

class UserStoryService {
    protected $userStoryRepo;

    public function __construct(UserStoryRepository $userStoryRepo)
    {
        $this->userStoryRepo = $userStoryRepo;
    }

    public function createUserStory(int $ord, string $sessionId, string $title, string $description): ?UserStory {
        $userStory = new UserStory($ord, $sessionId, $title, $description);

        if ($this->userStoryRepo->createUserStory($userStory)) {
            return $userStory;
        }

        return null;
    }
}