<?php

namespace App\database\migrations;

use App\database\Migration;

class m00002_roles extends Migration
{
    public function up()
    {
        $q = "CREATE TABLE roles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
        ) ENGINE=INNODB;";

        db()->pdo->exec($q);
    }

    public function down()
    {
        $q = "DROP TABLE roles;";

        db()->pdo->exec($q);
    }

}
