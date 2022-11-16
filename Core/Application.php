<?php

namespace App\Core;

use App\Core\DB\Database;
use App\Models\Auth\User;

class Application
{
    public static Application $app;
    public static string $ROOT_DIR;
    public static string $currentMethod;
    public View $view;
    public Router $router;
    public Request $request;
    public Response $response;
    public Database $db;
    public Session $session;
    public ?User $authenticatedUser = null;

    public string $autheticableClassName;

    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->autheticableClassName = $config['authClassName'];
        $this->request = new Request();
        $this->response = new Response();
        $this->view = new View();
        $this->router = new Router();
        $this->db = new Database($config['db']);
        $this->session = new Session();
        $this->checkAuth();
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $exception) {

            response()->setStatusCode($exception->getCode());

            echo view()->renderView('help-pages/_error', [
                'e' => $exception,
            ]);
        }
    }

    public function authenticate(User $user)
    {
        $this->authenticatedUser = $user;

        $primaryKey = $user::primaryKey();

        $primaryValue = $user->{$primaryKey};

        session()->set('authCredentials', $primaryValue);
        session()->set('user', $user);
    }

    public function logout()
    {
        $this->authenticatedUser = null;
        session()->remove('authCredentials');
    }

    private function checkAuth()
    {
        $primaryValue = session()->get('authCredentials');
        $primaryKey = $this->autheticableClassName::primaryKey();

        if ($primaryValue && ($user = $this->autheticableClassName::findOneBy([$primaryKey => $primaryValue]))) {
            $this->authenticatedUser = $user;
        } else {
            $this->authenticatedUser = null;
        }
    }
}
