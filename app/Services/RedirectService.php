<?php

namespace App\Services;

use App\Controllers\AuthController;
use App\Models\Request;

class RedirectService
{
    const HOME = '/home';
    const DASHBOARD = '/dashboard';

    public $routes = [];

    public $aliases = [];

    public $controller;

    public Request $request;

    public function __construct(string $uri, Request $request)
    {
        unset($this->controller);
        $access = true;
        $auth = AuthController::auth($request);
        $this->request = $request;

        if ($auth[AuthController::AUTH_STATUS]) {
            if ($uri === '/' || $uri === self::HOME || $uri === '/slave') {
                $this->redirect(self::DASHBOARD);
            }
        } else {
            $message = $auth[AuthController::AUTH_MESSAGE];
            $this->request->add(['message' => $message]);

            if ($uri === '/' || $uri === self::HOME) {
                $uri = self::HOME;
            } else {
                $access = false;
            }
        }

        $this->controller = $this->getController($uri, $access);
    }

    public function redirect(string $uri)
    {
        header("Location: $uri");
        exit();
    }

    public function loadRoutes()
    {
        $this->routes = require_once 'routes/web.php';
        $this->writeAliases();
    }

    private function writeAliases()
    {
        foreach ($this->routes as $route) {
            if (file_exists($route)) {
                $class = basename($route, '.php');
                $this->aliases[$route] = "\App\Controllers\\$class";
            }
        }
    }

    public function checkRoute(string $uri) : bool
    {
        $this->loadRoutes();

        if (!isset($this->routes[$uri])) {

            return false;
        }

        return true;
    }

    public function getController(string $uri, bool $access)
    {
        if ($this->checkRoute($uri)) {
            if (!$access) {
                $this->abort(403);
            }

            return $this->routes[$uri];
        }

        return 404;
    }

    public function abort(int $code = 404)
    {
        switch ($code) {
            case 404:
                echo file_get_contents(PUBLIC_DIR.'errors/404.php');
                exit();

            case 403:
                echo file_get_contents(PUBLIC_DIR.'errors/403.php');
                exit();

            default:
                echo 'Unknown error';
                exit();
        }

    }

    public function start()
    {
        switch ($this->controller) {
            case 404:
                $this->abort(404);
                break;

            default:
                require_once $this->controller;
                break;
        }

        $c = new $this->aliases[$this->controller];
        $c->execute($this->request);
    }
}