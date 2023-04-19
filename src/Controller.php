<?php

declare(strict_types=1);
namespace App;

require_once('View.php');

class Controller
{
    private const DEFAULT_ACTION = 'list';
    private array $getData;
    private array $postData;

    public function __construct(array $getData, array $postData)
    {
        $this->getData = $getData;
        $this->postData = $postData;   
    }

    public function run()
    {
        $action = htmlentities($this->getData['action'] ?? self::DEFAULT_ACTION);
        $view = new View();
        $ViewPages = [];

        switch($action)
        {
            case 'create':
            $page = 'create';
            $created = false;
            if ($this->postData) {
                $ViewPages = [
                'title' => $this->postData['title'],
                'description' => $this->postData['description']
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
        $view->render($action, $ViewPages);
    }
}