<?php

namespace App\Core\form;

class TextAreaField extends BaseField
{

    public function renderField(): string
    {
        $errorClass = empty($this->errors) ? '' : ' is-invalid';
        return sprintf('
            <textarea name="%s" id="%s"
                   class="form-control%s">%s</textarea>',
            $this->attrib,
            $this->attrib,
            $errorClass,
            $this->model->{$this->attrib},
        );
    }
}
