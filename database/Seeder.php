<?php

namespace App\database;

use App\Core\Model;
use App\Core\SystemTraits\DisplayMessageTrait;

abstract class Seeder
{
    use DisplayMessageTrait;
    protected ?Model $model;
    private array $data = [];

    abstract public function seed();

    protected function bindData($data)
    {
        $this->data = $data;
    }
    protected function loadModelAndExecute()
    {
        if (!empty($this->data)) {
            $this->model->loadData($this->data);
            $this->seedIntoDB();
            $this->log(static::class . ' is successfully seeded!');
        } else {
            $this->log('No data to be seeded!');
        }
    }

    private function seedIntoDB(): bool
    {
        return $this->model->create();
    }
}
