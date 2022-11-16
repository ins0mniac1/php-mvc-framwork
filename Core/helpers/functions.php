<?php

use App\Core\Application;
use App\Core\DB\Database;
use App\Core\Request;
use App\Core\Response;
use App\Core\Router;
use App\Core\Session;
use App\Core\View;
use App\Models\Auth\User;
use JetBrains\PhpStorm\NoReturn;
use JetBrains\PhpStorm\Pure;

const CONFIG_FOLDER = '/config/';
const PHP_EXTENSION = '.php';

/**
 * Start application
 * @param $rootPath
 * @param null $routes
 * @param bool $shouldRun
 *
 */
function startApp($rootPath, $routes = null, bool $shouldRun = true)
{
    $dotenv = Dotenv\Dotenv::createImmutable($rootPath);
    $dotenv->load();

    $config = config('app', $rootPath);

    $app = new Application($rootPath, $config);

    if (! is_null($routes)) {
        require $routes;
    }

    if ($shouldRun) {
        $app->run();
    }
}

/**
 * Get provided root directory
 */
#[Pure]
function rootPath(): string
{
    return Application::$ROOT_DIR;
}

/**
 * Load file or file's content from config folder
 */
function config($relativePath = '', $rootPath = null)
{
    if (is_null($rootPath)) {
        $rootPath = rootPath();
    }
    $pathAsComponents = explode('.', $relativePath);

    $file = include($rootPath . CONFIG_FOLDER . $pathAsComponents[0] . PHP_EXTENSION);
    if (count($pathAsComponents) === 1) {
        return $file;
    }
    unset($pathAsComponents[0]);

    $valueToReturn = $file;

    foreach ($pathAsComponents as $component) {
        $valueToReturn = $valueToReturn[$component];
    }

    return $valueToReturn;
}

/**
 * Get loaded instance of Application
 */
function app(): Application
{
    return Application::$app;
}

/**
 * Get loaded instance of Request
 */
#[Pure]
function request(): Request
{
    return app()->request;
}

/**
 * Get loaded instance of Response
 */
#[Pure]
function response(): Response
{
    return app()->response;
}

/**
 * Redirect to path
 */
function redirect(string $path = '/')
{
    response()->redirect($path);
}

/**
 * Get loaded instance of Database
 */
#[Pure]
function db(): Database
{
    return app()->db;
}

/**
 * Get loaded instance of View
 */
#[Pure]
function view(): View
{
    return app()->view;
}

/**
 * Set title
 */
function setPageTitle($title)
{
    view()->title = $title;
}

/**
 * Get title
 */
#[Pure]
function getPageTitle(): ?string
{
        return view()->title;
}

/**
 * Get loaded instance of Router
 */
#[Pure]
function router(): Router
{
    return app()->router;
}

/**
 * Get loaded Session
 */
#[Pure]
function session(): Session
{
    return app()->session;
}

/**
 * Set flash message to session
 */
function setFlash($key, $value)
{
    session()->setFlash($key, $value);
}


/**
 * Get flash messages from session
 */
function getFlash($key)
{
    return session()->getFlash($key);
}

/**
 * Return authenticated user
 */
function auth(): ?User
{
    return Application::$app->authenticatedUser;
}

#[Pure]
function getAction(): ?string
{
    return Application::$currentMethod;
}

function setAction($action)
{
    Application::$currentMethod = $action;
}

/**
 * Check is user non-authenticated
 */
#[Pure]
function isGuest(): bool
{
    return auth() === null;
}

/**
 * Check is user authenticated
 */
#[Pure]
function isAuth(): bool
{
    return auth() !== null;
}

/**
 * @param ...$data
 * Dump provided data and show results
 */
#[NoReturn]
function dd(...$data)
{
    echo '<div class="w-full m-5" style="background: black; color: greenyellow; font-weight: bold; padding: 1em;">';
    foreach ($data as $item) {
        echo '<pre>';
        var_dump($item);
        echo '</pre>';
    }
    echo '</div>';
    die();
}

