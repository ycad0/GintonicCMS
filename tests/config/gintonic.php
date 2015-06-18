<?php
return [
    'Gintonic' => [
        'cookie' => [
            'key' => '__UNDEFINED__',
            'name' => 'gintonic',
            'loginDuration' => '+2 weeks',
        ],
        'install' => [
            'migration' => true,
            'admin' => true,
            'config' => true,
            'npmInstalled' => true,
            'bowerInstalled' => true,
            'grunt' => true,
            'lock' => true,
        ],
        'website' => [
            'name' => 'GintonicCMS'
        ]
    ],
];
