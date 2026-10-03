<?php

return [
    'hst_rate' => (float) env('BILL_OF_SALE_HST_RATE', 0.13),
    'dealer' => [
        'name' => env('BILL_OF_SALE_DEALER_NAME', env('APP_NAME', '')),
        'address' => env('BILL_OF_SALE_DEALER_ADDRESS', '6610 Turner Valley Road Mississauga ON L5N-2P1 unit 201'),
        'phone' => env('BILL_OF_SALE_DEALER_PHONE', '647-521-7186'),
        'email' => env('BILL_OF_SALE_DEALER_EMAIL', 'xtremeinc.86@gmail.com'),
        'registration_number' => env('BILL_OF_SALE_DEALER_REGISTRATION_NUMBER', ''),
        'hst_registration_number' => env('BILL_OF_SALE_HST_REGISTRATION_NUMBER', ''),
    ],
];
