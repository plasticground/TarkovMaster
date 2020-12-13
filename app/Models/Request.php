<?php


namespace App\Models;


class Request
{
    public array $data = [];

    public string $method;

    public function __construct(array $data, string $method)
    {
        $this->data = $data;
        $this->method = strtolower($method);
    }

    public function allCurrent()
    {
        return $this->data[$this->method];
    }

    public function all(string $method = '')
    {
        if ($method === '') {
            return $this->data;
        }

        return $this->data[$method];
    }

    public function get(string $key = '')
    {
        if (isset($this->allCurrent()[$key])) {
            return $this->allCurrent()[$key];
        }

        return null;
    }

    public function add(array $params = []) {
        $this->data['extra'] = $params;
    }
}