<?php

namespace App\Http\Controllers\Auth;

use App\Core\Request;
use App\Core\Validator\RulesAndMessages;
use App\Models\Auth\User;

class RegisterController extends BaseAuthController
{
    public function __construct()
    {
        $this->setLayout('layouts/guest');
    }

    public function index(): bool|array|string
    {
        $user = new User();

        return $this->render('auth/register', [
            'model' => $user,
        ]);
    }

    public function store(Request $request)
    {
        $user = new User();

        $request->setRules([
            'firstname' =>
                [
                    RulesAndMessages::RULE_REQUIRED,
                    [
                        RulesAndMessages::RULE_MIN,
                        3
                    ],
                    [
                        RulesAndMessages::RULE_MAX,
                        20
                    ]
                ],
            'lastname' =>
                [
                    RulesAndMessages::RULE_REQUIRED,
                    [
                        RulesAndMessages::RULE_MIN,
                        3
                    ],
                    [
                        RulesAndMessages::RULE_MAX,
                        20
                    ]
                ],
            'email' =>
                [
                    RulesAndMessages::RULE_REQUIRED,
                    RulesAndMessages::RULE_EMAIL,
                    [
                        RulesAndMessages::RULE_UNIQUE,
                        'users'
                    ],
                    [
                        RulesAndMessages::RULE_MIN,
                        5
                    ]
                ],
            'password' =>
                [
                    RulesAndMessages::RULE_REQUIRED,
                    [
                        RulesAndMessages::RULE_MIN,
                        3
                    ]
                ],
            'confirmPassword' =>
                [
                    RulesAndMessages::RULE_REQUIRED,
                    [
                        RulesAndMessages::RULE_MATCH,
                        'password'
                    ]
                ],
        ]);

        $data = $request->all();

        $user->loadData($data);

        if (!$request->validate()) {
            return $this->render('auth/register', [
                'errors' => $request->getErrors(),
                'model' => $user,
            ]);
        }

        if ($user->create()) {
            setFlash(session()::STATUS_SUCCESS, 'You are registered now!');
            return $this->authenticate($user);

        }

        setFlash(session()::STATUS_ERROR, 'Oops, something is wrong. Please try again!');

        return $this->render('auth/register', [
            'errors' => $request->getErrors(),
            'model' => $user,
        ]);

    }
}
