<?php


namespace App\Controllers;


use App\Models\Page;

class HtmlController
{
    /**
     * @var Page
     */
    public Page $page;

    /**
     * @param array $blank DOM body
     * @param string $body DOM without body
     */
    public function createPage(string $body = self::EMPTY_BODY, array $blank = [])
    {
        $this->page = new Page($blank, $body);
    }

    /**
     * @param array $params ['paramName' => 'paramResult']
     * @return Page DOM with body & paramResults
     */
    public function getPage(array $params = [])
    {
        $body = $this->page->getBody();

        if (!empty($params) && stripos($body, '@param(') !== false) {
            $body = $this->replaceParams($body, $params);
        }

        $this->page->setBody($body);

        return $this->page;
    }

    /**
     * @param string $body
     * @param array $params
     * @return string|string[]
     */
    public function replaceParams(string $body, array $params)
    {
        foreach ($params as $paramName => $paramResult) {
            $body = str_replace("@param($paramName)", $paramResult, $body);
        }

        return $body;
    }

    /**
     * @param array|string[] $container ['< div >', '< /div >']
     * @param string $repeatableRow '< p >@insertData< /p >>'
     * @param array|string[] $params ['foo', 'bar', 'baz']
     * @return string
     */
    public static function foreachGenerate(array $container, string $repeatableRow, array $params)
    {
        $data = [];

        $data['startContainer'] = $container[0];

        foreach ($params as $n => $param) {
            $data['rows'][$n] = str_replace('@insertData', $param, $repeatableRow);
        }

        $data['rows'] = implode(PHP_EOL, $data['rows']);
        $data['endContainer'] = $container[1];
        $data = implode(PHP_EOL, $data);

        return $data;
    }
}