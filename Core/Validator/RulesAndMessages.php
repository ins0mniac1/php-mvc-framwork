<?php

namespace App\Core\Validator;

use JetBrains\PhpStorm\ArrayShape;

class RulesAndMessages
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';

    #[ArrayShape(
        [
            self::RULE_REQUIRED => "string",
            self::RULE_EMAIL => "string",
            self::RULE_MIN => "string",
            self::RULE_MAX => "string",
            self::RULE_MATCH => "string",
            self::RULE_UNIQUE => "string"
        ]
    )]
    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be an valid email address',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
            self::RULE_MATCH => 'This field must be the same as {match}',
            self::RULE_UNIQUE => 'This {unique} already exists',
        ];
    }
}
