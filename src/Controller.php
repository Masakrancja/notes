<?php

declare(strict_types=1);
namespace App;

require_once('Database.php');
require_once('View.php');


class Controller
{
    private static array $configuration = [];
    private const DEFAULT_ACTION = 'list';
    private array $request;
    private View $view;

    public static function initConfiguration(array $configuration) : void
    {
        self::$configuration = $configuration;
    }

    public function __construct(array $request)
    {
        $db = new Database(self::$configuration['db']);
        $this->request = $request;
        $this->view = new View();
        
    }

    public function run()
    {
        $ViewPages = [];
        switch($this->action())
        {
            case 'create':
            $page = 'create';
            $created = false;
            $data = $this->getDataPost();
            if ($data) {
                $ViewPages = [
                'title' => $data['title'],
                'description' => $data['description']
                ];
                $created = true;
            }
            $ViewPages['created'] = $created;
            break;

            case 'show':
            $page = 'show';
            $ViewPages['title'] = 'Title';
            $ViewPages['description'] = 'Description';
            break;

            default:
            $page = 'list';
            $ViewPages['actionList'] = 'wyświetlam listę';
            break;
        }
        $this->view->render($page, $ViewPages);
    }

    private function getDataGet() : array
    {
        return $this->request['get'] ?? [];
    }

    private function getDataPost() : array
    {
        return $this->request['post'] ?? [];
    }

    private function action() : string
    {
        $data = $this->getDataGet();
        return $data['action'] ?? self::DEFAULT_ACTION;
    }

}