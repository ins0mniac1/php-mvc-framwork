<?php

namespace App\Core\form;

use App\Core\Model;
use JetBrains\PhpStorm\Pure;

class InputField extends BaseField
{
    protected ?string $type;

    public function __construct(
        Model $model,
        string $name,
        string $attrib,
        string $type,
        ?array $errors)
    {
        $this->type = $type;
        parent::__construct($model, $name, $attrib, $errors);
    }

    public function renderField(): string
    {
        $errorClass = empty($this->errors) ? '' : ' is-invalid';
        return sprintf('
            <input name="%s" id="%s" value="%s"
                   class="form-control%s" type="%s" />',
            $this->attrib,
            $this->attrib,
            $this->model->{$this->attrib},
            $errorClass,
            $this->type,
        );
    }
}
