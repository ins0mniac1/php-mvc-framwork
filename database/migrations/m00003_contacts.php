<?php

namespace App\database\migrations;

use App\database\Migration;

class m00003_contacts extends Migration
{
    public function up()
    {
        $q = "CREATE TABLE contacts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            subject VARCHAR(255) NOT NULL,
            sender VARCHAR(255) NOT NULL,
            about LONGTEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
        ) ENGINE=INNODB;";

        db()->pdo->exec($q);
    }

    public function down()
    {
        $q = "DROP TABLE contacts;";

        db()->pdo->exec($q);
    }

}
