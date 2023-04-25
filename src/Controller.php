<?php

declare(strict_types=1);
namespace App;

require_once('Database.php');
require_once('View.php');
require_once('src/Exception/ConfigurationException.php');
require_once('src/Exception/NotFoundException.php');

use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;


class Controller
{
    private static array $configuration = [];
    private const DEFAULT_ACTION = 'list';
    private Request $request;
    private View $view;
    private Database $database;

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

    public function createAction()
    {
        if ($this->request->hasPost()) {
            $noteData = ['title' => $this->request->postParam('title'), 'description' => $this->request->postParam('description')];
            $this->database->createNote($noteData);
            header('Location: /?before=create');
            exit();
        }
        $this->view->render('create');
    }

    public function showAction()
    {
        $noteId = (int) $this->request->getParam('id');
        if (!$noteId) {
            header('Location: /?error=missingNoteId');
            exit();
        }
        try {
            $note = $this->database->getNote($noteId);
        } catch (NotFoundException $e) {
            header('Location: /?error=noteNotFound');
            exit();
        }
        $this->view->render(
            'show', 
            ['note' => $note]
        );
    }

    public function listAction()
    {
        $ViewPages = [
        ];
        $this->view->render(
            'list', 
            [
                'before' => $this->request->getParam('before'),
                'error' => $this->request->getParam('error'),
                'notes' => $this->database->getNotes()
            ]
        );
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