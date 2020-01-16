<?php
use Zend\Diactoros\ServerRequestFactory;
$app = require_once "../src/application.php";
$request = ServerRequestFactory::fromGlobals();
$response = $app->handle($request);
$app->emit($response);