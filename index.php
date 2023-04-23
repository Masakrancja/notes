<?php
  declare(strict_types=1);
  namespace App;

  use App\Exception\AppException;
use App\Exception\ConfigurationException;
use Throwable;

  error_reporting(E_ALL);
  ini_set('display_errors', '1');

  require_once('src/Utils/debug.php');
  require_once('src/Controller.php');
  #require_once('src/Exception/AppException.php');

  $request = [
    'get' => $_GET,
    'post' => $_POST
  ];

  try {
    //$controller = new Controller($request);
    //$controller->run();
    $configuration = require_once('config/config.php');
    Controller::initConfiguration($configuration);
    (new Controller($request))->run();
  } catch (ConfigurationException $e) {
    echo '<h3>Błąd konfiguracji. Skontaktuj się z administratorem</h3>';
  } catch (AppException $e) {
    echo '<h3>' . $e->getMessage() . '</h3>';
  } catch (Throwable $e) {
    echo '<h1>Application Error</h1>';
  }



