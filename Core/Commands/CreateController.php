<?php

namespace App\Core\Commands;

use App\Core\Commands\Kernel\FileGenerator;

class CreateController extends FileGenerator
{
    protected static string $errorMessage = 'You must provide controller name! Please check "php mvc.php controller -h" or "php mvc.php controller --help" command for more information!';


    public static function run(array $args = [])
    {
        self::chekHasHelpKey($args);
        self::prepareFileArguments($args);
        self::loadFile(rootPath());
        self::loadClassAndFolderName(rootPath());

        $stubContent = file_get_contents(self::$file);

        $stubContent = str_replace(
            [
                '^^ControllerFolder^^',
                '^^Controller^^'
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

        self::displayMessage('Controller "' . self::$fileClass . '" is successfully generated in "' . self::$filePath . '!');
    }

    protected static function loadClassAndFolderName($path)
    {
        $args = explode('/', self::$arguments[0]);
        self::$fileClass = ucfirst(end($args)) . 'Controller';

        array_pop($args);

        self::$filePath = $path . '/Http/Controllers/';

        if (count($args) > 0) {

            foreach ($args as $arg) {
                self::createFolder(self::$filePath . $arg . '/');
            }

            self::$fileFolder = '\\' . implode('\\', $args);
        }

    }
}
