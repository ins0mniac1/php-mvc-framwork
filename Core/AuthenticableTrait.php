<?php

namespace App\Core;

trait AuthenticableTrait
{
    public function user(): static
    {
        return $this;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function logout()
    {
        app()->authenticate(null);
    }
}
