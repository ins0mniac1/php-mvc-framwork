<?php

namespace App\Models\Auth;

use App\Core\AuthenticableTrait;
use App\Core\Model;

class User extends Model
{
    use AuthenticableTrait;

    const STATUS_NOT_ACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    public ?int $id = null;
    public ?string $firstname = '';
    public ?string $lastname = '';
    public ?string $email = '';
    public int $status = self::STATUS_NOT_ACTIVE;
    public ?string $password = '';
    public ?string $confirmPassword = '';

    protected static string $table = 'users';

    protected static array $hidden = [
        'password'
    ];

    public function create(): bool
    {
        $this->hashPassword();

        return parent::create();
    }

    private function hashPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function getDisplayName(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}
