<?php
return [
    "doctrine.entities.path"=>[
       "src/Domain/Entities"
    ],
    "doctrine.console.active" => true,
    "doctrine.isDevMode"=>false,
    "doctrine.connections"=>[
        "default"=>[
            'driver'   => 'pdo_mysql',
            'user'     => 'root',
            'password' => '',
            'dbname'   => 'blog',
        ]
    ],
    "doctrine.connection" => "default"
];