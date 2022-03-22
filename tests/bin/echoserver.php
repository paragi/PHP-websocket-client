<?php

/*
 * This is a simple echo server implemented with Ratchet
 * See https://github.com/ratchetphp/Ratchet
 */

require_once __DIR__ . '/../../vendor/autoload.php';

$app = new Ratchet\App('127.0.0.1', 9999, '0.0.0.0');
$app->route('/', new Ratchet\Server\EchoServer(), ['*']);
$app->run();
