<?php

return [
    'defaults' => [
        'basic_fee_rate' => 0.1,
        'storage_fee_usd' => 100,
    ],
    'vehicule_types' => [
        'common' => [
            // 'basic_fee_rate' => 0.1,
            'basic_fee_min_usd' => 10,
            'basic_fee_max_usd' => 50,
            'special_fee_rate' => 0.02,
            // 'storage_fee_usd' => 100,
        ],
        'luxury' => [
            // 'basic_fee_rate' => 0.1,
            'basic_fee_min_usd' => 25,
            'basic_fee_max_usd' => 200,
            'special_fee_rate' => 0.04,
            // 'storage_fee_usd' => 100,
        ],
    ],
];
