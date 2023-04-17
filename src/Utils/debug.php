<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

function dump($name)
{
  echo '<div style="background: lightgray; display: inline-block; padding: 10px; margin: 10px;">';
  echo '<pre>';
  print_r($name);
  echo '</pre>';
  echo '</div></br>';
}