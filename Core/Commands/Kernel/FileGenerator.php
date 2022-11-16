<?php

namespace App\Core\Commands\Kernel;

use App\Core\SystemTraits\DisplayMessageTrait;

abstract class FileGenerator extends Command
{
    use DisplayMessageTrait;

    protected static string $errorMessage = 'You must provide name! Please check "php mvc.php help" command for more information!';
    protected static string $stubExtension = '.stub';
    protected static string $file = 'file.txt';
    protected static array $arguments;
    protected static string $fileClass = '';
    protected static string $fileFolder = '';
    protected static string $filePath = '/';

    abstract protected static function loadClassAndFolderName($path);

    protected static function prepareFileArguments(array $arg)
    {
        unset($arg[0], $arg[1]);

        if (count($arg) < 1) {
            self::displayMessage(static::$errorMessage);
            exit;
        }

        self::$arguments = array_values($arg);
    }

    protected static function loadFile($path)
    {
        $fileName = substr(static::class, 24) . self::$stubExtension;
        self::$file = $path . '\Core\stubs\\' .  $fileName;
    }

    protected static function createFolder($folder)
    {
        if (! is_dir($folder)) {
            mkdir($folder);
        }

        self::$filePath = $folder;
    }

    protected static function displayMessage($msg)
    {
        self::log($msg);
    }
}
