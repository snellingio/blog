<?php


require_once __DIR__ . '/vendor/autoload.php';

date_default_timezone_set('America/Chicago');
define('VIEWS_DIR', __DIR__ . '/views');
define('PAGES_DIR', __DIR__ . '/pages');

$view     = new League\Plates\Engine(VIEWS_DIR);
$markdown = new Parsedown();
$template = '_markdown';

$directories = ['/', '/2015/', '/2016/', '/2017/'];

foreach ($directories as $dir) {
    $files = glob(PAGES_DIR . $dir . '*.md', GLOB_BRACE);

    foreach ($files as $file) {
        $name = str_replace([PAGES_DIR, $dir, '.md'], '', $file);

        $content = file_get_contents($file);

        $parameters             = [];
        $parameters['title']    = substr(strtok($content, "\n"), 2);
        $parameters['markdown'] = $markdown->text($content);

        $rendered = $view->render($template, $parameters);

        if ($name === 'home') {
            $name = '';
        }

        $static_dir = 'static/' . $name;
        if (!is_dir($static_dir)) {
            mkdir($static_dir);
        }

        $file = $static_dir . '/index.html';
        file_put_contents($file, $rendered);
    }
}
