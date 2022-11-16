<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;

class BaseAuthController extends Controller
{
    private User $user;

    const ON_ERROR_REDIRECT_TO = 'auth/login';

    protected function authenticate(User $user)
    {
        $this->user = $user;

        if (! $this->isUserExistsAndCheckPassword()) {
            return $this->render(static::ON_ERROR_REDIRECT_TO, [
                'errors' => request()->getErrors(),
                'model' => $user,
            ]);
        }

        app()->authenticate($this->user);
        setFlash(session()::STATUS_SUCCESS, 'Welcome ' . auth()->user()->firstname . '!');
        redirect('/');
    }

    protected function logout()
    {
        app()->logout();
        redirect('/');
    }

    private function isUserExistsAndCheckPassword(): bool
    {
        $user = $this->user->findOneBy(['email' => $this->user->email]);

        $pwd = User::fetchColumn('password', $user->id);
        if (! $user) {
            request()->validator->addError('email', 'User with this email does not exist!');
            return false;
        }

        if (! password_verify($this->user->password, $pwd) && ! password_verify($this->user->confirmPassword, $pwd)) {
            request()->validator->addError('password', 'Password is incorrect!');
            return false;
        }

        $this->user = $user;

        return true;
    }
}
