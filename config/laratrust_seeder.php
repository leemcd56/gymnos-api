<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'administrator' => [
            'blog'     => 'c,r,u,d',
            'cron'     => 'r',
            'files'    => 'c,r,u,d',
            'payments' => 'c,r,u,d',
            'profile'  => 'r,u',
            'users'    => 'c,r,u,d',
        ],

        'cronjob' => [
            'cron' => 'r',
        ],

        'muted' => [],

        'user' => [
            'blog'     => 'c,r,u,d',
            'files'    => 'c,r,u,d',
            'payments' => 'c,r,u',
            'profile'  => 'r,u',
            'users'    => 'r',
        ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],
];
