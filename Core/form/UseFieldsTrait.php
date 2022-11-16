<?php

namespace App\Core\form;

use App\Core\Model;
use JetBrains\PhpStorm\Pure;

trait UseFieldsTrait
{
    #[Pure] public function inputField(Model $model, $name, $attrib, $type = 'text'): InputField
    {
        return new InputField($model, $name, $attrib, $type, $this->errors[$attrib] ?? null);
    }

    #[Pure] public function textareaField(Model $model, $name, $attrib): TextAreaField
    {
        return new TextAreaField($model, $name, $attrib, $this->errors[$attrib] ?? null);
    }
}
