<?php
define("APP_PATH",dirname(__DIR__));
define("BASE_PATH",dirname(dirname(__DIR__)));
return [
    "app.host" => "http://localhost:8000",
    "app.path"=>APP_PATH,
    "app.cache.path"=>BASE_PATH.DS."cache",
    "app.views.folder"=>BASE_PATH.DS."resources".DS."views",
    "app.environment"=>"development"
];