<?php

return [
    'site_name' => 'The Bike Shop',
    'infoEmail' => 'info@bike-shop.com',
    'adminEmail' => 'admin@bike-shop.com',
    'patterns' => [
        'name' => '/^[a-zа-яёєії]+$/iu',
        'phone' => '/^\+?[0-9-\(\)]+$/',
        'address' => '/^[a-zа-яёєії0-9-\., ]+$/iu',
    ],
];
