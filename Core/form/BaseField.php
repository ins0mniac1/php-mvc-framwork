<?php

namespace App\Core\form;

use App\Core\Model;
use JetBrains\PhpStorm\Pure;

abstract class BaseField
{
    abstract public function renderField(): string;

    protected Model $model;
    protected ?string $attrib;
    protected null|array $errors;
    protected string $name;

    public function __construct(
        Model $model,
        string $name,
        string $attrib,
        ?array $errors)
    {
        $this->model = $model;
        $this->attrib = $attrib;
        $this->errors = $errors;
        $this->name = $name;
    }

    #[Pure]
    public function __toString(): string
    {
        $errorDiv = $this->composeErrors();

        return sprintf('
        <div class="mb-3">
            <label for="%s" class="form-label">%s</label>
            %s
            %s            
        </div>
        ',
            $this->attrib,
            $this->name,
            $this->renderField(),
            $errorDiv,
        );
    }

    private function composeErrors(): string
    {
        $errorMessage = '<div class="invalid-feedback">';

        if (! is_null($this->errors)) {
            foreach ($this->errors as $error) {

                $errorMessage .= sprintf('
            <p>
            %s
            </p>
            ', $error);
            }
        }

        $errorMessage .= '</div>';

        return $errorMessage;
    }

}
