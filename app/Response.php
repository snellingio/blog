<?php
declare (strict_types = 1);

namespace App;

use League\Plates\Engine as View;

class Response
{

    public $view;

    private $body;

    private $headers;

    private $responseCode;

    public function __construct()
    {
        $this->view = new View(VIEWS_DIR);

        $this->setResponseCode(200);
        $this->setHeader('Access-Control-Allow-Origin', '*');
        $this->setHeader('Date', date('D, d M Y H:i:s \G\M\T'));
        $this->setHeader('Server', 'onroi.com');
        $this->setHeader('X-Powered-By', 'none');
    }

    public function html(string $data): bool
    {
        $this->setHeader('X-UA-Compatible', 'IE=Edge,chrome=1');
        $this->setHeader('X-XSS-Protection', '1; mode=block');
        $this->setHeader('X-Content-Type-Options', 'nosniff');
        $this->setHeader('Content-Type', 'text/html; charset=utf-8');
        $this->setHeader('Content-Security-Policy', 'default-src * \'self\' data: \'unsafe-inline\' \'unsafe-eval\';');
        $this->setBody($data);

        return $this->output();
    }

    public function json(array $data = []): bool
    {
        $json = json_encode($data, JSON_PRETTY_PRINT);
        $this->setHeader('Content-Type', 'application/json; charset=utf-8');
        $this->setHeader('Cache-Control', 'public, max-age=60');
        $this->setBody($json);

        return $this->output();
    }

    public function jsonError(int $responseCode = 500, string $details = '')
    {
        $this->setResponseCode($responseCode);

        return $this->json(
            [
                'status'  => $responseCode,
                'object'  => 'error',
                'details' => $details,
            ]
        );
    }

    public function output(): bool
    {
        $this->setHeader('ETag', md5($this->body));
        $this->outputHeaders();
        $this->outputBody();

        return true;
    }

    public function outputBody(): bool
    {
        ob_start('ob_gzhandler');
        echo $this->body;
        ob_end_flush();

        return true;
    }

    public function outputHeaders(): bool
    {
        foreach ($this->headers as $key => $value) {
            header($key . ': ' . $value);
        }

        return true;
    }


    public function upgradeSSL(string $http_host = '', string $request_uri = ''): bool
    {
        $this->setResponseCode(301);
        $this->redirect('https://' . $http_host . $request_uri);

        return $this->outputHeaders();
    }

    public function redirect(string $location = '/'): bool
    {
        $this->setHeader('Location', $location);

        return $this->outputHeaders();
    }

    public function render(string $template, array $parameters = [], string $format = 'html'): bool
    {
        $view = $this->view->render($template, $parameters);
        if ($format === 'html') {
            return $this->html($view);
        }
        if ($format === 'json') {
            return $this->json($view);
        }
        if ($format === 'xml') {
            return $this->xml($view);
        }

        return false;
    }

    public function setBody(string $data): bool
    {
        $this->body = $data;

        return true;
    }

    public function setHeader(string $key, $value): bool
    {
        $this->headers[$key] = $value;

        return true;
    }

    public function setResponseCode(int $responseCode = 200): bool
    {
        $this->responseCode = $responseCode;

        return true;
    }

    public function xml(string $data): bool
    {
        $this->setHeader('Content-Type', 'application/xml; charset=utf-8');
        $this->setBody($data);

        return $this->output();
    }
}
