<?php

require_once __DIR__ . '/vendor/autoload.php';

date_default_timezone_set('America/Chicago');
define('VIEWS_DIR', __DIR__ . '/views');
define('PAGES_DIR', __DIR__ . '/pages');

$path = (new App\Server)->path();


$content  = '';
$template = '_markdown';

if (empty($path)) {
    $content = PAGES_DIR . '/home.md';
}

if (empty($content) && file_exists(PAGES_DIR . '/2015/' . $path . '.md')) {
    $content = PAGES_DIR . '/2015/' . $path . '.md';
}

if (empty($content) && file_exists(PAGES_DIR . '/2016/' . $path . '.md')) {
    $content = PAGES_DIR . '/2016/' . $path . '.md';
}

if (empty($content) && file_exists(PAGES_DIR . '/2017/' . $path . '.md')) {
    $content = PAGES_DIR . '/2017/' . $path . '.md';

}

if (empty($content)) {
    echo '404';
    exit;
}

$markdown = new Parsedown();

$parameters             = [];
$parameters['title']    = '';
$parameters['markdown'] = $markdown->text(file_get_contents($content));

$response = new App\Response();
$response->render($template, $parameters);