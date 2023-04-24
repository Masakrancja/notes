<?php

declare(strict_types=1);
namespace App;

use App\Exception\ConfigurationException;

require_once('Database.php');
require_once('View.php');
require_once('src/Exception/ConfigurationException.php');

class Controller
{
    private static array $configuration = [];
    private const DEFAULT_ACTION = 'list';
    private array $request;
    private View $view;
    private Database $database;

    public static function initConfiguration(array $configuration) : void
    {
        self::$configuration = $configuration;
    }

    public function __construct(array $request)
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
        $ViewPages = [];
        switch($this->action())
        {
            case 'create':
                $page = 'create';
                $data = $this->getDataPost();
                if ($data) {
                    $noteData = ['title' => $data['title'], 'description' => $data['description']];
                    $this->database->createNote($noteData);
                    header('Location: /?before=create');
                }
            break;

            case 'show':
                $page = 'show';
                $ViewPages['title'] = 'Title';
                $ViewPages['description'] = 'Description';
            break;

            default:
                $page = 'list';
                $data = $this->getDataGet();
                $ViewPages = [
                    'before' => $data['before'] ?? null,
                    'notes' => $this->database->getNotes()
                ];
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