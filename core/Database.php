<?php

namespace app\core;

class Database
{
    public \PDO $pdo;

    public function __construct(array $config)
    {
        $this->pdo = new \PDO($config['dsn'], $config['user'], $config['password']);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigrations()
    {
        $this->createMigrationTable();
        $migrationsToApply = array_diff(scandir('./migrations'), $this->getAppliedMigrations());

        foreach ($migrationsToApply as $migration)
        {
            if($migration == '.' || $migration == '..'){
                continue;
            }
            include_once "./migrations/$migration";
            $className = pathinfo($migration, PATHINFO_FILENAME);

            $class = new $className();
            $class->up();
            $this->addMigration($migration);
        }
    }

    private function createMigrationTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migrations VARCHAR(255) NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                deleted_at DATETIME
            )";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }

    private function getAppliedMigrations(){
        $sql = "SELECT migrations from migrations";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    private function addMigration($migration)
    {
        $sql = "INSERT INTO migrations(`migrations`) VALUES (:migration)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam('migration', $migration);
        $stmt->execute();
    }
}
