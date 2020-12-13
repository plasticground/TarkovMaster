<?php

namespace Templates;

class ControllerTemplate
{
    /** @var string  */
    private string $data;

    /**
     * ControllerTemplate constructor.
     */
    public function __construct()
    {
$this->data = "<?php

namespace App\Controllers;

use App\Models\Request;

class ~controller_name~ extends HtmlController
{
    /**
     * @var string
     */
    public string \$view = ~view~;

    /**
     * @param array \$params
     * @return array|string[]
     */
    public function buildPage(\$params = [])
    {
        \$body = file_get_contents(\$this->view);
        \$page = new HtmlController();

        \$page->createPage(\$body);
        \$page = \$page->getPage(\$params);

        return \$page->toArray();
    }

    public function execute(Request \$request)
    {
        \$params = [];

        echo implode('', \$this->buildPage(\$params));

    }
}";
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }
}
