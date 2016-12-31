<?php
declare (strict_types = 1);

namespace App;

class Server
{

    public function path(): string
    {
        $path = $this->getPath();
        $path = substr($path, 1);
        if (strpos($path, '.') !== false) {
            $path = substr($path, 0, strpos($path, '.'));
        }

        return $path;
    }

    private function getPath(): string
    {
        $server = $_SERVER;
        $path   = '/';
        if (!empty($server['PATH_INFO'])) {
            $path = $server['PATH_INFO'];
        } elseif (!empty($server['ORIG_PATH_INFO']) && '/index.php' !== $server['ORIG_PATH_INFO']) {
            $path = $server['ORIG_PATH_INFO'];
        } else {
            if (!empty($server['REQUEST_URI'])) {
                $path = (strpos($server['REQUEST_URI'], '?') > 0) ? strstr($server['REQUEST_URI'], '?', true) : $server['REQUEST_URI'];
            }
        }
        if (strlen($path) > 1) {
            $path = rtrim($path, '/');
        }

        return $path;
    }

    public function extension(): string
    {
        $path = $this->getPath();
        $path = substr($path, strpos($path, '.'));

        return $path;
    }

}