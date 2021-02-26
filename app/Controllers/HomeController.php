<?php

namespace App\Controllers;

use App\Models\Request;

class HomeController extends HtmlController
{
    /**
     * @var string
     */
    public string $view = RESOURCES_DIR.'views/home/index.php';

    /**
     * @param array $params
     * @return array|string[]
     */
    public function buildPage($params = [])
    {
        $body = file_get_contents($this->view);
        $page = new HtmlController();

        $page->createPage($body);
        $page = $page->getPage($params);

        return $page->toArray();
    }

    public function execute(Request $request)
    {
        $params = [];

        if (!empty($request->all()['extra'])) {
            if ($request->all()['extra']['message'] === 'errorAuth') {
                $params = ['errorAuth' => 'bg-error'];
            } else {
                $params = ['errorAuth' => ''];
            }
        }

        echo implode('', $this->buildPage($params));

    }
}