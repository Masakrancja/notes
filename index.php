<?php
  declare(strict_types=1);
  namespace App;
  error_reporting(E_ALL);
  ini_set('display_errors', '1');

  require_once('src/Utils/debug.php');
  require_once('src/View.php');

  $view = new View();

  const DEFAULT_ACTION = 'list';
  $ViewPages = [];
  $action = htmlentities($_GET['action'] ?? DEFAULT_ACTION);

  switch($action)
  {
    case 'create':
      $page = 'create';
      $created = false;
      if ($_POST) {
        $ViewPages = [
          'title' => $_POST['title'],
          'description' => $_POST['description']
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



