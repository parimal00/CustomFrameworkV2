<?php

class M001_initial_migration{
    public function up()
    {
        $db = \app\core\Application::$app->database;
        $sql = "CREATE TABLE users(
    id int primary key AUTO_INCREMENT,
    name varchar(255),
    email varchar(255),
    password varchar(255)
)";
        $stmt = $db->pdo->prepare($sql);
        $stmt->execute();
    }

    public function down()
    {
        echo "down migration";
    }
}
