<?php
return [
    "doctrine.entities.path"=>[
       "src/Entities"
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