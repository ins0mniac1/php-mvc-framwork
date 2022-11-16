<?php

namespace App\Http\Controllers;

use App\Http\Middlewares\AuthMiddleware;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return $this->render('auth/profile');
    }
}
