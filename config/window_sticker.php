<?php

return [
    // This is the public dealership site used for links printed on stickers.
    // It deliberately does not fall back to APP_URL, which is commonly local
    // while an admin is developing the application.
    'public_website_url' => env(
        'WINDOW_STICKER_PUBLIC_WEBSITE_URL',
        'https://www.xtrememotorsinc.ca'
    ),
];
