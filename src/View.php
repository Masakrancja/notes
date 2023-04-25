<?php
    declare(strict_types=1);
    namespace App;
    class View
    {
        public function render(string $page, array $params = []) : void
        {   
            $params = $this->escape($params);
            require_once('templates/layout.php');
        }

        private function escape(array $params): array
        {
            $result = [];
            foreach ($params as $key => $param) {
                if (is_array($param)) {
                    $result[$key] = $this->escape($param);
                } else {
                    $result[$key] = htmlentities((string) $param ?? '');
                }
            }
            return $result;
        }
    }