<?php

declare(strict_types=1);
namespace  App;

class Request
{
    private array $get = [];
    private array $post = [];
    private array $serwer = [];

    public function __construct(array $get, array $post, array $serwer)
    {
        $this->get = $get;
        $this->post = $post;
        $this->serwer = $serwer;
    }
    
    public function isGet(): bool
    {
        return $this->serwer['REQUEST_METHOD'] === 'GET';
    }

    public function isPost(): bool
    {
        return $this->serwer['REQUEST_METHOD'] === 'POST';
    }

    public function getParam(string $name, $default = null)
    {
        return $this->get[$name] ?? $default;
    }

    public function postParam(string $name, $default = null)
    {
        return $this->post[$name] ?? $default;
    }

    public function hasPost(): bool
    {
        return !empty($this->post);
    }

}