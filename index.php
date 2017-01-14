<?php

require_once __DIR__ . '/vendor/autoload.php';

date_default_timezone_set('America/Chicago');
define('VIEWS_DIR', __DIR__ . '/views');
define('PAGES_DIR', __DIR__ . '/pages');

$path = (new App\Server)->path();

$file  = '';
$template = '_markdown';

if (empty($path)) {
    $file = PAGES_DIR . '/home.md';
}

if (empty($file) && file_exists(PAGES_DIR . '/2015/' . $path . '.md')) {
    $file = PAGES_DIR . '/2015/' . $path . '.md';
}

if (empty($file) && file_exists(PAGES_DIR . '/2016/' . $path . '.md')) {
    $file = PAGES_DIR . '/2016/' . $path . '.md';
}

if (empty($file) && file_exists(PAGES_DIR . '/2017/' . $path . '.md')) {
    $file = PAGES_DIR . '/2017/' . $path . '.md';

}

if (empty($file)) {
    exit;
}

$markdown = new Parsedown();

$content = file_get_contents($file);

$parameters             = [];
$parameters['title']    = substr(strtok($content, "\n"), 2);
$parameters['markdown'] = $markdown->text($content);

$response = new App\Response();
$response->render($template, $parameters);