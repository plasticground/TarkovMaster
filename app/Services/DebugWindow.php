<?php


namespace App\Services;

use App\Models\Request;
use Templates\DebugWindowTemplate;

class DebugWindow
{
    /** @var array|mixed  */
    private $server;

    /** @var array|mixed  */
    private $post;

    /** @var array|mixed  */
    private $get;

    /** @var array|mixed  */
    private $session;

    /** @var array|mixed  */
    private $cookie;

    /** @var array|mixed  */
    private $env;

    /** @var array|mixed  */
    private $files;

    /** @var array|mixed  */
    private $request;

    /** @var string  */
    private $data;

    /**
     * DebugWindow constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->server = $request->all('server');
        $this->post = $request->all('post');
        $this->get = $request->all('get');
        $this->session = $request->all('session');
        $this->cookie = $request->all('cookie');
        $this->env = $request->all('env');
        $this->files = $request->all('files');
        $this->request = $request->all('request');

        $this->data = new DebugWindowTemplate();
        $this->data = $this->data->getData();
        $this->getDebug();
    }

    /**
     * @param $param
     */
    public function print()
    {
        echo $this->data;
    }

    /**
     * @return $this
     */
    public function getDebug()
    {
        $replacements = [
            '~server~' => $this->server,
            '~post~' => $this->post,
            '~get~' => $this->get,
            '~session~' => $this->session,
            '~cookie~' => $this->cookie,
            '~env~' => $this->env,
            '~request~' => $this->request,
        ];

        $this->data = $this->replace($this->data, $replacements);

        return $this;
    }

    /**
     * @param $data
     * @param array $replacements
     * @return string|string[]
     *
     */
    private function replace(&$data, array $replacements)
    {
        foreach ($replacements as $search => $replacement) {
            $replacement = var_export($replacement, true);
            $data = str_ireplace($search, $replacement, $data);
        }

        return $data;
    }
}