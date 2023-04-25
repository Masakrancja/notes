<?php
  declare(strict_types=1);
  namespace App;

  error_reporting(E_ALL);
  ini_set('display_errors', '1');

  require_once('src/Utils/debug.php');
  require_once('src/NoteController.php');
  require_once('src/Request.php');
  require_once('src/Exception/AppException.php');
  $configuration = require_once('config/config.php');

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



