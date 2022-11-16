<?php

namespace App\Core\form;

class Button
{
    private string $name;
    private string $type;
    private string $class;

    public function __construct(string $name, string $type, string $class)
    {
        $this->name = $name;
        $this->type = $type;
        $this->class = $class;
    }

    public function __toString(): string
    {
        return sprintf('
        <button type="%s" class="%s">%s</button>
        ',
            $this->type, $this->class, $this->name
        );
    }
}
