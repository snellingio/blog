<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?= $title ?> | Sam Snelling</title>

    <meta property="og:title" content="<?= $title ?> | Sam Snelling">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@snellingio">
    <meta name="twitter:creator" content="@snellingio">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="data:;base64,=">
    <style>
        body {
            font-family: 'Avenir Next', HelveticaNeue-Light, 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 1.125em;
            color: #222222;
            margin: 0;
        }

        .article {
            max-width: 620px;
            margin: 0 auto;
            padding: 10px;
        }

        a {
            color: #36b;
            overflow-wrap: break-word;
            word-wrap: break-word;
        }

        a.page {
            font-size: 1.3em;
        }

        hr {
            margin: 50px;
        }

        h1, h2 {
            font-size: 1.5em;
            line-height: 1.25;
            font-weight: 500;
        }

        h2 a,
        h2 a:active,
        h2 a:visited {
            color: #000;
            text-decoration: none;
        }

        h3 {
            font-size: 1.25em;
            font-weight: 600;
            margin-top: 2em;
            margin-bottom: 1em;
        }

        h1:first-of-type {
            font-size: 2em;
            margin-top: 50px;
            margin-bottom: 50px;
            font-weight: 600;
        }

        strong {
            font-weight: 500;
        }

        blockquote {
            margin: 0 18px 18px 18px;
            color: #666;
            padding-left: 10px;
            border-left: 4px solid #eee;
        }

        code,
        kbd,
        pre,
        samp {
            font-family: Menlo, Monaco, Consolas, "Courier New", monospace;
            overflow-wrap: break-word;
            word-wrap: break-word;
            word-break: break-all;
        }

        code {
            padding: 2px 4px;
            font-size: 90%;
            color: #c7254e;
            background-color: #f9f2f4;
            border-radius: 4px;
        }

        pre {
            display: block;
            padding: 10px;
            margin: 0 0 10px;
            font-size: 13px;
            line-height: 1.42857143;
            color: #333;
            word-break: break-all;
            word-wrap: break-word;
            background-color: #f5f5f5;
            border: 1px solid #ccc;
            border-radius: 4px;
            overflow: scroll;
        }

        pre code {
            padding: 0;
            font-size: inherit;
            border-radius: 0;
            color: #000;
            background: transparent 0 0;
            text-shadow: 0 1px #fff;
            font-family: Consolas,Monaco,'Andale Mono','Ubuntu Mono',monospace;
            text-align: left;
            white-space: pre;
            word-spacing: normal;
            word-break: normal;
            word-wrap: normal;
            line-height: 1.5;
            -moz-tab-size: 4;
            -o-tab-size: 4;
            tab-size: 4;
            -webkit-hyphens: none;
            -moz-hyphens: none;
            -ms-hyphens: none;
            hyphens: none;
        }

        code {

        }

        img {
            display: block;
            max-width: 100%;
            height: auto;
        }

        .header {
            background: #509EE3;
            color: #fff;
        }

        .header a, .header a:visited {
            color: #fff;
        }

        .footer {
            text-align: center;
        }

        .red, .red a {
            color: #e55235 !important;
            font-weight: bold;
        }

        .green, .green a {
            color: #00AF45 !important;
            font-weight: bold;
        }

        p {
            font-size: 20px;
            line-height: 1.6em;
        }

        a[href^="//"]:after,
        a[href^="http://"]:after,
        a[href^="https://"]:after {
            content: url(https://snelling.io/images/external.png);
            margin: 0 0 0 5px;
        }

        a[href^="//snelling.io/"]:after,
        a[href^="http://snelling.io/"]:after,
        a[href^="https://snelling.io/"]:after {
            content: '';
            margin: 0;
        }
    </style>

<body>

<div class="header">
    <div class="article">
        <h2><a href="/">Sam Snelling</a></h2>
        <p><i>The John Wick of PHP Software Development</i></p>
    </div>
</div>
