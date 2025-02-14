<?php

namespace App\Models;

class Session {
    public string $uuid;
    public string $poName;
    public string $date;
    public string $startTime;

    public function __construct(string $poName) 
    {
        $this->uuid = uniqid();
        $this->poName = $poName;
        $this->date = date('Y-m-d');
        $this->startTime = date('H:i:s');
    }
}