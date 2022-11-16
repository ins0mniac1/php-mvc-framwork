<?php

namespace App\Core\DB;


use App\Core\SystemTraits\DisplayMessageTrait;

class Database
{
    use DisplayMessageTrait;
    const NAMESPACE_PREFIX = 'App\database\migrations\\';
    public \PDO $pdo;

    public function __construct(array $config)
    {
        $dsn = $this->constructDSN($config) ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';
        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigrations()
    {
        $this->createMigrationTable();
        $migrations = $this->getAppliedMigrations();

        $files = scandir(rootPath() . '/database/migrations');
        $diff = array_diff($files, $migrations);
        $newMigrations = [];

        foreach ($diff as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }

            require_once rootPath() . '/database/migrations/' . $migration;

            $className = pathinfo($migration, PATHINFO_FILENAME);

            $executableMigration = new (self::NAMESPACE_PREFIX . $className)();
            $this->log('Applying migration ' . $migration);
            $executableMigration->up();
            $this->log('Applied migration ' . $migration);
            $newMigrations[] = $migration;
        }

        if (empty($newMigrations)) {
            $this->log('No new migrations to apply!');
        }

        if (! empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
            $this->log('All migrations are applied!');
        }
    }

    public function dropTables()
    {
        try {
            $this->getAppliedMigrations();

            $files = scandir(rootPath() . '/database/migrations');
            $droppedMigrations = [];

            foreach ($files as $migration) {
                if ($migration === '.' || $migration === '..') {
                    continue;
                }

                require_once rootPath() . '/database/migrations/' . $migration;

                $className = pathinfo($migration, PATHINFO_FILENAME);

                $executableMigration = new (self::NAMESPACE_PREFIX . $className)();
                $this->log('Dropping migration ' . $migration);
                $executableMigration->down();
                $this->log('Dropped migration ' . $migration);
                $droppedMigrations[] = $migration;
            }

            if (empty($droppedMigrations)) {
                $this->log('The DB is empty!');
            }

            $this->deleteMigrationsTable();
            if (! empty($droppedMigrations)) {
                $this->log('All migrations are applied!');
            }
        } catch (\Exception $exception) {
            $this->log('The DB is empty!');
        }
    }

    public function createMigrationTable()
    {
       $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
            ) ENGINE=INNODB;");
    }

    public function getAppliedMigrations(): bool|array
    {
        $stmt = $this->pdo->prepare("SELECT migration from migrations");
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function prepare($sql): bool|\PDOStatement
    {
        return $this->pdo->prepare($sql);
    }

    private function constructDSN($config): string
    {
        $type = $config['type'];
        unset($config['type']);

        $dbString = '';

        foreach ($config as $key => $dbItem) {
            $dbString .= $key . '=' . $dbItem;
            if (end($config) !== $dbItem) {
                $dbString .= ';';
            }
        }
        return $type . ':' . $dbString;
    }

    private function saveMigrations(array $migrations)
    {
        $migrations = implode(',', array_map(fn($m) => "('$m')", $migrations));

        $stmt = $this->pdo->prepare("INSERT INTO migrations (migration) VALUE
            $migrations
        ");

        $stmt->execute();
    }

    private function deleteMigrationsTable()
    {
        $stmt = $this->pdo->prepare("DROP TABLE migrations");
        $stmt->execute();
    }
}
