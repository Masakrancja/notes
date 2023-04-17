<?php
  declare(strict_types=1);
  namespace App;
  require_once('src/Utils/debug.php');

  $action = null;
  if (!empty($_GET['action'])) {
    $action = $_GET['action'];
  }
?>

<html>
  <head>

  </head>
  <body>
    <div class="header">
      <h1>Nagłówek</h1>
    </div>

    <div class="container">
      <div class="menu">
        <ul>
          <li><a href="/">Lista notatek</a></li>
          <li><a href="/?action=create">Utwórz notatkę</a></li>
          <li></li>

        </ul>
      </div>
      <div class="content"></div>
    </div>

    <div class="footer">
      Stopka
    </div>

  </body>
</html>

