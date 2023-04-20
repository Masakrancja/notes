<?php
  declare(strict_types=1);
  namespace App;

  error_reporting(E_ALL);
  ini_set('display_errors', '1');

  require_once('src/Utils/debug.php');
  require_once('src/Controller.php');

  $request = [
    'get' => $_GET,
    'post' => $_POST
  ];

  //$controller = new Controller($request);
  //$controller->run();

  (new Controller($request))->run();



