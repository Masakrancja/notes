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

                switch(true) {
                    case (is_array($param)):
                        $result[$key] = $this->escape($param);
                        break;
                    case (is_int($param)):
                        $result[$key] = $param;
                        break;
                    default:
                        $result[$key] = htmlentities((string) $param ?? '');
                        break;
                }
            }
            return $result;
        }
    }