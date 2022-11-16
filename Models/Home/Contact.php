<?php

namespace App\Models\Home;

use App\Core\Model;

class Contact extends Model
{
    public ?int $id = null;
    public ?string $subject = '';
    public ?string $sender = '';
    public ?string $about = '';
}
