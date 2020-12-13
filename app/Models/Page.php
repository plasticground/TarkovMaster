<?php


namespace App\Models;


class Page
{
    /**
     * @var array ['up', 'body', 'end']
     */
    private array $page = ['up', 'body', 'end'];

    /**
     * Page constructor.
     * @param array $blank
     * @param string $body
     */
    public function __construct(array $blank = [], string $body = '<body></body>')
    {
        $this->setBlank($blank);
        $this->setBody($body);
    }

    /**
     * @param array $blank
     */
    public function setBlank(array $blank = []): void
    {
        if (empty($blank)) {
            $this->page = require_once 'resources/layouts/blank.php';
        } else {
            $this->page = $blank;
        }
    }

    /**
     * @param string $body
     */
    public function setBody(string $body = '<body></body>'): void
    {
        $this->page['body'] = $body;
    }

    /**
     * @return array|string[] ['up', 'body', 'end']
     */
    public function toArray()
    {
        return $this->page;
    }

    /**
     * @return mixed|string
     */
    public function getBody()
    {
        return $this->page['body'];
    }
}