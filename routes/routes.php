<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LoginPostController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

router()->get('/', [HomeController::class, 'home']);
router()->get('/logout', [LogoutController::class, 'index']);


router()->get('/contact', [HomeController::class, 'contact']);
router()->post('/contact', [HomeController::class, 'contact']);

router()->get('/login', [LoginController::class, 'index']);
router()->post('/login', [LoginPostController::class, 'index']);

router()->get('/register', [RegisterController::class, 'index']);
router()->post('/register', [RegisterController::class, 'store']);

router()->get('/profile', [ProfileController::class, 'index']);
