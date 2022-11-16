<?php

namespace App\database\migrations;

use App\database\Migration;

class m00001_users extends Migration
{
    public function up()
    {
        $q = "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            firstname VARCHAR(255) NULL,
            lastname VARCHAR(255) NULL,
            status TINYINT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;";

        db()->pdo->exec($q);
    }

    public function down()
    {
        $q = "DROP TABLE users;";

        db()->pdo->exec($q);
    }

}
