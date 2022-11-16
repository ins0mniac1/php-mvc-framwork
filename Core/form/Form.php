<?php

namespace App\Core\form;

use App\Core\Model;
use JetBrains\PhpStorm\Pure;

class Form
{
    use UseFieldsTrait;

    const FORM_BEGIN_STRING = '<form action="^^action^^" method="^^method^^" class="^^class^^">';

    private null|array $errors = [];

    public static function begin($action = "", $class = "" , $method = 'post'): Form
    {
        echo str_replace([
            '^^action^^',
            '^^method^^',
            '^^class^^'
        ], [
            $action,
            $method,
            $class
        ],
        self::FORM_BEGIN_STRING);

        return new Form();
    }


    public static function end(): string
    {
        return '</form>';
    }

    #[Pure] public function button($name = 'Submit', $type = 'submit', $class = ''): Button
    {
        return new Button($name, $type, $class);
    }

    public function setErrors($errors)
    {
        $this->errors = $errors;
    }
}
