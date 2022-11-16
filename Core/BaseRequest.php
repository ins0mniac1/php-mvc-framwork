<?php

namespace App\Core;

use App\Core\Validator\Validator;
use JetBrains\PhpStorm\Pure;

class BaseRequest
{
    public Validator $validator;

    #[Pure]
    public function __construct()
    {
        $this->validator = new Validator();
    }

    public function setRules($rules)
    {
        $this->validator->setRules($rules);
    }

    public function validate($data = null): bool
    {
        if (is_null($data)) {
            $data = $this->all();
        }

        return $this->validator->validate($data);
    }

    public function getValidated(): array
    {
        return $this->validator->validated;
    }

    public function getErrors(): array
    {
        return $this->validator->errors;
    }

}
