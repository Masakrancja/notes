<?php

declare(strict_types=1);

namespace App;

require_once('Database.php');
require_once('View.php');
require_once('src/Exception/ConfigurationException.php');

use App\Exception\ConfigurationException;

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

    public function run()
    {
        $action = $this->action() . 'Action';
        if (!method_exists($this, $action)) {
            $action = self::DEFAULT_ACTION . 'Action';
        }
        $this->$action();
    }

    private function action() : string
    {
        return $this->request->getParam('action', self::DEFAULT_ACTION);
    }
}