<?php

namespace App\Controllers;

use App\Models\Request;
use App\Services\RedirectService;

class DashboardController extends HtmlController
{
    /**
     * @var string
     */
    public string $view = 'resources/views/dashboard/index.php';

    /**
     * @return array|string[]
     */
    public function buildPage()
    {
        $body = file_get_contents($this->view);

        $page = new HtmlController();
        $page->createPage($body);

        $page = $page->getPage($params = []);

        return $page->toArray();
    }
    
    public function execute(Request $request)
    {
        echo implode('', $this->buildPage());
    }
}