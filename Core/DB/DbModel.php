<?php

namespace App\Core\DB;

abstract class DbModel
{
    protected static string $table = '';
    protected static array $hidden = [];
    protected static array $attributes = [];

    abstract public static function primaryKey();

    public function __construct()
    {
        $this->initDBModel();
    }

    public function create(): bool
    {
        $params = array_map(fn($attr) => ':' . $attr, static::$attributes);

        $stmt = db()->prepare("INSERT INTO " . static::$table . " (" . implode(', ', static::$attributes) . ")
                VALUES(". implode(', ', $params) .")
        ");

        foreach (static::$attributes as $attribute) {
            $stmt->bindValue(":$attribute", $this->{$attribute});
        }

        $stmt->execute();

        return true;
    }

    public function update()
    {

    }

    public static function findOneById($id)
    {
        static::setTable();

        return self::findOneBy(['id' => $id]);
    }

    public static function findOneBy(array $params)
    {
        static::setTable();

        $attributes = array_keys($params);
        $where = implode(' AND ', array_map(fn($attr) => "$attr = :$attr", $attributes));

        $query = "SELECT * FROM " . static::$table ." WHERE $where";

        $stmt = db()->prepare($query);

        foreach ($params as $key => $item) {
            $stmt->bindValue(":$key", $item);
        }

        $stmt->execute();

        $obj =  $stmt->fetchObject(static::class);

        if ($obj) {
            foreach (static::$hidden as $hiddenProperty) {
                $obj->{$hiddenProperty} = '';
            }
        }

        return $obj;
    }

    public static function fetchColumn($column, $id)
    {
        static::setTable();

        $query = "SELECT $column FROM " . static::$table ." WHERE id = :id";

        $stmt = db()->prepare($query);
        $stmt->bindValue(":id", $id);

        $stmt->execute();

        return $stmt->fetchObject(static::class)->{$column};
    }

    public static function setTable()
    {
        if (static::$table === '') {
            $model = explode('\\', static::class);
            static::$table = strtolower(end($model) . 's');
        }
    }

    public function initDBModel()
    {
        static::setTable();

        $class = get_class($this);

        $refClass = new \ReflectionClass($this);
        $attributes = [];

        foreach ($refClass->getProperties() as $property) {
            if ($property->class === $class && ! str_starts_with($property->name, 'confirm') && $property->name !== 'id' && $property->name !== 'hidden' && $property->name !== 'table') {
                $attributes[] = $property->name;
            }
        }

        static::$attributes = $attributes;
    }
}
