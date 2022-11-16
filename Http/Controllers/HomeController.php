<?php

namespace App\Http\Controllers;

use App\Core\Validator\RulesAndMessages;
use App\Models\Home\Contact;

class HomeController extends Controller
{
    public function home()
    {
        setPageTitle('MVC-Framework');
        $params = [
            'name' => 'Inso',
        ];

        return $this->render('home', $params);
    }

    public function contact(): bool|array|string
    {
        $contact = new Contact();

        if (request()->isPost()) {
            request()->setRules(
                [
                    'subject' => [RulesAndMessages::RULE_REQUIRED],
                    'sender' => [RulesAndMessages::RULE_REQUIRED, RulesAndMessages::RULE_EMAIL],
                    'about' => [RulesAndMessages::RULE_REQUIRED],
                ]
            );

            $data = request()->all();
            $contact->loadData($data);


            if (!request()->validate()) {
                return $this->render('contact', [
                    'errors' => request()->getErrors(),
                    'model' => $contact,
                ]);
            }

            $contact->create();

            setFlash('success', 'We received your message and We will keep you in touch about it!');

            redirect('/contact');
        }

        return $this->render('contact', [
            'model' => $contact,
        ]);
    }
}
