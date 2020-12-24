<?php

return [
    'role_structure' => [
        'super_admin' => [
            'users'           => 'c,r,u,d',
            'products'        => 'c,r,u,d',
            'categories'      => 'c,r,u,d',
            'cities'          => 'c,r,u,d',
            'districts'       => 'c,r,u,d',
            'details'         => 'c,r,u,d',
            'subdetails'      => 'c,r,u,d',
            //'sales' => 'r',
            'coupons'         => 'c,r,u,d',
            'orders'          => 'r,u,d',
            'members'         => 'r',
            'notifications'   => 'c',
            'service_numbers' => 'r,u', 
            'banks'           => 'c,r,u,d',
            'about_us'        => 'u',
            'terms'           => 'u',
        ],

        'admin' => [],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
