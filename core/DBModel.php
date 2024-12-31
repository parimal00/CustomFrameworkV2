<?php

namespace app\core;

abstract class DBModel
{
    public function save()
    {
        $tableName = static::getTableName();
        $columns = implode(",", $this->getAttributes());
        $params = array_map(function ($param){
           return ":$param";
        }, $this->getAttributes());

        $statement = $this->prepareStatement("INSERT INTO ".$tableName." (".$columns.") VALUES (".implode(',', $params).")" );

        foreach ($this->getAttributes() as $attribute){
            $statement->bindParam(":$attribute", $this->{$attribute});
        }

        $statement->execute();
    }

    public static function findOne($where)
    {
        $tableName = static::getTableName();
        $attributes = array_keys($where);

        $sql = implode(" AND ", array_map(function ($attr) {
                return "$attr = :$attr";
            }, $attributes)
        );

        $statement = "SELECT * FROM $tableName WHERE $sql";

        $pdo = Application::$app->database->pdo;
        $statement = $pdo->prepare($statement);
        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    protected abstract function getAttributes();
    protected abstract static function getTableName();

    private function prepareStatement(string $sql)
    {
        $pdo = Application::$app->database->pdo;
        return $pdo->prepare($sql);
    }
}
