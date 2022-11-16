<?php
return [
    /**
     * Base command that should use
     */
    'base_command' => 'php mvc.php',

    /**
     * Help keys that shows information for used command
     */
    'help_keys' => [
        '--help',
        '-h'
    ],

    /**
     * Information for command "php mvc.php help"
     */
    'commands_with_information' => [
        'start' => 'Execute with "^^command^^" command - run application',
        'migrate' => 'Execute with "^^command^^" command - execute DB initialization.',
        'drop' => 'Execute with "^^command^^" command - execute drop of all tables in DB',
        'fresh' => 'Execute with "^^command^^" command - drop all tables and create them again!',
        'seed' => 'Execute with "^^command^^" command - run "php mvc.php migrate" command and after that seed DB with data from Seeders (in database/seeders folder)',
        'model' => 'Execute with "^^command^^" command - create new model class and file. You should provide model name (and directory if need) - "php mvc.php model ModelName" or "php mvc.php model Directory/ModelName"',
        'controller' => 'Execute with "^^command^^" command - create new controller class and file. You should provide controller name (and directory if need) - "php mvc.php controller ControllerName" or "php mvc.php controller Directory/ControllerName". Don\' attach "Controller" after name, i.e. - If you want to create PostController, just type "php mvc.php controller Post". "Controller" extension will be attached automatically!',
        'seeder' => 'Execute with "^^command^^" command - create new seeder class and file. You should provide seeder name (and directory if need) and model name (with directory after "Models") - "php mvc.php seeder SeederName Directory/Model" or "php mvc.php seeder Directory/SeederName Directory/Model". Don\' attach "Seeder" after name, i.e. - If you want to create UsersTableSeeder, just type "php mvc.php seeder UsersTable Auth/User". "Seeder" extension will be attached automatically! After seeder creating you should register the new seeder in "database/seeders/DataBaseSeeder.php" in order it need to be!',
        'help' => 'Execute with "^^command^^" command. Provides information about all of the commands',
    ],

    'aliases' => [
        'start' => \App\Core\Commands\Start::class,
        'migrate' => \App\Core\Commands\Migrate::class,
        'drop' => \App\Core\Commands\DropDB::class,
        'fresh' => \App\Core\Commands\FreshMigrate::class,
        'seed' => \App\Core\Commands\SeedDatabase::class,
        'model' => \App\Core\Commands\CreateModel::class,
        'controller' => \App\Core\Commands\CreateController::class,
        'seeder' => \App\Core\Commands\CreateSeeder::class,
        'help' => \App\Core\Commands\Help::class,
    ]
];
