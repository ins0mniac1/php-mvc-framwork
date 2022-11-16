<?php

namespace App\Core\Commands;

use App\Core\Commands\Kernel\FileGenerator;

class CreateModel extends FileGenerator
{
    protected static string $errorMessage = 'You must provide model name! Please check "php mvc.php model -h" or "php mvc.php model --help" command for more information!';

    public static function run(array $args = [])
    {
        self::chekHasHelpKey($args);
        self::prepareFileArguments($args);
        self::loadFile(rootPath());
        self::loadClassAndFolderName(rootPath());

        $stubContent = file_get_contents(self::$file);

        $stubContent = str_replace(
            [
                '^^ModelFolder^^',
                '^^Model^^'
            ],
            [
                self::$fileFolder,
                self::$fileClass,
            ],
            $stubContent
        );

        $generatedFile = fopen(self::$filePath . self::$fileClass . '.php', 'w');
        fputs($generatedFile, $stubContent);
        fclose($generatedFile);

        self::displayMessage('Model "' . self::$fileClass . '" is successfully generated in "' . self::$filePath . '" folder!');
    }

    protected static function loadClassAndFolderName($path)
    {
        $args = explode('/', self::$arguments[0]);
        self::$fileClass = ucfirst(end($args));

        array_pop($args);

        self::$filePath = $path . '/Models/';

        if (count($args) > 0) {

            foreach ($args as $arg) {
                self::createFolder(self::$filePath . $arg . '/');
            }

            self::$fileFolder = '\\' . implode('\\', $args);
        }

    }
}
