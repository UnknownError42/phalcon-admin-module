<?php

return [
    'application' => [
        'controllersDir' => __DIR__ . '/../controllers/',
        'modelsDir'      => __DIR__ . '/../models/',
        'viewsDir'       => __DIR__ . '/../views/',
        'adminControllersDir' => APP_PATH . '/modules/admin/controllers/',
    ],
    'gravatar' => [
        'default_image' => 'identicon',
        'size'          => 160,
    ],
    'privateResources' => [
        'administrators' => [
            'profile',
            'deleteAccount'
        ],
        'sessions' => [
            'signOut'
        ],
        'index' => [
            'error'
        ]
    ]
];
