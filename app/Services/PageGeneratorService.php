<?php

namespace App\Services;

class PageGeneratorService
{
    public function __construct(string $view)
    {
        include_once $this->getView($view);
    }

    private function getView(string $name)
    {
        $view = include_once 'routes/web.php';

        return $view[$name];
    }
}
