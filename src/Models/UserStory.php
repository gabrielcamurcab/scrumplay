<?php

namespace App\Models;

class UserStory {
    protected string $uuid;
    protected int $ord;
    protected string $sessionId;
    protected string $title;
    protected string $description;
    protected string $doned;

    public function __construct(int $ord, string $sessionId, string $title, string $description)
    {
        $this->uuid = uniqid();
        $this->ord = $ord;
        $this->sessionId = $sessionId;
        $this->title = $title;
        $this->description = $description;
        $this->doned = "TODO";
    }

    public function getOrd(): int {
        return $this->ord;
    }

    public function getSessionId(): string {
        return $this->sessionId;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getDescription(): string {
        return $this->description;
    }
}