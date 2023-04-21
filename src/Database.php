<?php

declare(strict_types=1);

namespace App;

class Database
{
    public function __construct($config)
    {
        $dns = 'mysql:dbname=' . $config['database'] . ';host=' . $config['host'];
        $connection = new \PDO(
            $dns,
            $config['user'],
            $config['password']
        );
        dump($config);
        dump($connection);
    }
}