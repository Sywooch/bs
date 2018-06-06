<?php

return [
    'site_name' => 'The Bike Shop',
    'infoEmail' => 'info@bike-shop.com',
    'adminEmail' => 'admin@bike-shop.com',
    'patterns' => [
        'alpha-x' => '/^[a-zа-яёєії\-\ ]+$/iu',
        'alphanum' => '/^[a-zа-яёєії0-9]+$/iu',
        'alphanum-x' => '/^[a-zа-яёєії0-9\-\.\,\)\(\ ]+$/iu',
        'phone' => '/^\+?[0-9-\(\)]+$/',
    ],
    'max_image_size' => 1024*1024*3,
    'product_images' => 'uploads' . DIRECTORY_SEPARATOR . 'products',
];
