<?php

namespace App\Core\Commands;

use App\Core\Commands\Kernel\FileGenerator;

class CreateSeeder extends FileGenerator
{
    protected static string $errorMessage = 'You must provide seeder name and/or model! Please check "php mvc.php seeder -h" or "php mvc.php seeder --help" command for more information!';

    protected static string $model = '';
    protected static string $modelNameSpace = '';
    protected static string $modelConstant = '';

    public static function run(array $args = [])
    {
        self::chekHasHelpKey($args);
        self::prepareFileArguments($args);

        if (count(self::$arguments) < 2) {
            self::displayMessage(static::$errorMessage);
            exit;
        }

        self::loadFile(rootPath());
        self::loadClassAndFolderName(rootPath());

        $stubContent = file_get_contents(self::$file);

        $stubContent = str_replace(
            [
                '^^SeederFolder^^',
                '^^ModelNamespace^^',
                '^^Seeder^^',
                '^^MODEL_CONSTANT^^',
                '^^ModelClass^^',
            ],
            [
                self::$fileFolder,
                self::$modelNameSpace,
                self::$fileClass,
                self::$modelConstant,
                self::$model,
            ],
            $stubContent
        );

        $generatedFile = fopen(self::$filePath . self::$fileClass . '.php', 'w');
        fputs($generatedFile, $stubContent);
        fclose($generatedFile);

        self::displayMessage('Seeder "' . self::$fileClass . '" is successfully generated in "' . self::$filePath . '!');
    }

    protected static function loadClassAndFolderName($path)
    {
        $args = explode('/', self::$arguments[0]);
        self::$fileClass = ucfirst(end($args)) . 'Seeder';

        array_pop($args);

        self::$filePath = $path . '/database/seeders/';

        if (count($args) > 0) {

            foreach ($args as $arg) {
                self::createFolder(self::$filePath . $arg . '/');
            }

            self::$fileFolder = '\\' . implode('\\', $args);
        }

        $modelArgs = explode('/', self::$arguments[1]);
        $model = end($modelArgs);

        self::$modelNameSpace = '\\' . implode('\\', $modelArgs);
        self::$model = 'new ' . $model . '()';
        self::$modelConstant = strtoupper($model) . 'S';
    }
}
