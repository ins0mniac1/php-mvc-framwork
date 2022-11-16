<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;

class LoginController extends Controller
{
    public function index(): bool|array|string
    {
        $this->setLayout('/layouts/guest');

        $user = new User();

        return $this->render('auth/login', [
            'model' => $user,
        ]);
    }
}
