<?php

namespace App\Http\Controllers\Auth;

use App\Core\Request;
use App\Core\Validator\RulesAndMessages;
use App\Models\Auth\User;

class LoginPostController extends BaseAuthController
{
    public function index(Request $request)
    {
        $user = new User();

        $request->setRules([
            'email' =>
                [
                    RulesAndMessages::RULE_REQUIRED,
                    RulesAndMessages::RULE_EMAIL,
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
        ]);

        $data = $request->all();

        $user->loadData($data);

        if (!$request->validate()) {
            return $this->render('auth/login', [
                'errors' => $request->getErrors(),
                'model' => $user,
            ]);
        }

        return $this->authenticate($user);
    }
}
