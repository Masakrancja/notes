<?php
  declare(strict_types=1);
  namespace App;

  error_reporting(E_ALL);
  ini_set('display_errors', '1');

  spl_autoload_register(function($name){
    $path = __DIR__ .'\\src' . $name . '.php';
    $path = str_replace(['\\', __NAMESPACE__], ['/', ''], $path);
    require_once($path);
  });

  require_once('src/Utils/debug.php');
  $configuration = require_once('config/config.php');

  use App\Request;
  use App\Controller\AbstractController;
  use App\Controller\NoteController;
  use App\Exception\AppException;
  use App\Exception\ConfigurationException;
  use Throwable;
  $request = new Request($_GET, $_POST);

  try {
    //$controller = new Controller($request);
    //$controller->run();

    AbstractController::initConfiguration($configuration);
    (new NoteController($request))->run();
  } catch (ConfigurationException $e) {
    echo '<h3>Błąd konfiguracji. Skontaktuj się z administratorem</h3>';
  } catch (AppException $e) {
    echo '<h3>' . $e->getMessage() . '</h3>';
  } catch (Throwable $e) {
    dump($e);
    echo '<h1>Application Error</h1>';
  }



