<?php

namespace App\Http\Controllers\Auth;

class LogoutController extends BaseAuthController
{
    public function index()
    {
        $this->logout();
    }
}
