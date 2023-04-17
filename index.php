<?php
  declare(strict_types=1);
  namespace App;
  require_once('src/Utils/debug.php');

  $action = null;
  if (!empty($_GET['action'])) {
    $action = htmlentities($_GET['action']);
  }

  if ($action === 'create') {
    include_once('templates/pages/create.php');
  } else {
    include_once('templates/pages/list.php');
  }

