<?php

declare(strict_types=1);

namespace App\Controller;
use App\Exception\ConfigurationException;
use App\Request;
use App\Database;
use App\View;

abstract class AbstractController
{
    private static array $configuration = [];
    protected const DEFAULT_ACTION = 'list';
    protected Request $request;
    protected View $view;
    protected Database $database;

    public static function initConfiguration(array $configuration) : void
    {
        self::$configuration = $configuration;
    }

    public function __construct(Request $request)
    {
        if (empty(self::$configuration['db'])) {
            throw new ConfigurationException('Configuration Error');
        }
        $this->database = new Database(self::$configuration['db']);
        $this->request = $request;
        $this->view = new View();
    }

    final public function run()
    {
        $action = $this->action() . 'Action';
        if (!method_exists($this, $action)) {
            $action = self::DEFAULT_ACTION . 'Action';
        }
        $this->$action();
    }

    final protected function redirect(string $to, array $params): void
    {
        $location = $to;
        if (count($params)) {
            $queryParams = [];
            foreach ($params as $key => $value) {
                $queryParams[] = urlencode($key) . '=' . urlencode($value);
            }
            $queryParams = implode('&', $queryParams);
            $location .= '?' .$queryParams;
        }
        header("Location: " . $location);
        exit();
    }

    private function action() : string
    {
        return $this->request->getParam('action', self::DEFAULT_ACTION);
    }
}