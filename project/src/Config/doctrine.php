<?php
return [
    "doctrine.entities.path"=>[
        dirname(__DIR__) . DS."Entities"
    ],
    "doctrine.isDevMode"=>false,
    "doctrine.connections"=>[
        "default"=>[
            'driver'   => 'pdo_mysql',
            'user'     => 'root',
            'password' => '',
            'dbname'   => 'blog',
        ]
    ]
];