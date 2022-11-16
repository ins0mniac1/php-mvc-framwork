<?php

namespace App\Models\Auth;

use App\Core\Model;

class Role extends Model
{
    public ?int $id = null;
    public ?string $name = '';
}
