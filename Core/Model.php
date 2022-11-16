<?php

namespace App\Core;

use App\Core\DB\DbModel;

abstract class Model extends DbModel
{
    public static function primaryKey(): string
    {
        return 'id';
    }

    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
}
