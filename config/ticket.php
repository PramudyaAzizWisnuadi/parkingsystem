<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Ticket Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for parking ticket printing
    |
    */

    'company' => [
        'name' => env('TICKET_COMPANY_NAME', env('APP_NAME', 'SISTEM PARKIR')),
        'title' => env('TICKET_TITLE', 'TIKET PARKIR'),
        'address' => env('TICKET_ADDRESS', ''),
        'phone' => env('TICKET_PHONE', ''),
    ],

    'paper' => [
        'width' => env('TICKET_PAPER_WIDTH', '58mm'),
        'padding' => env('TICKET_PAPER_PADDING', '3mm'),
        'print_padding' => env('TICKET_PRINT_PADDING', '2mm'),
    ],

    'font' => [
        'family' => env('TICKET_FONT_FAMILY', 'Courier New'),
        'size_base' => env('TICKET_FONT_SIZE_BASE', '10px'),
        'size_title' => env('TICKET_FONT_SIZE_TITLE', '12px'),
        'size_company' => env('TICKET_FONT_SIZE_COMPANY', '10px'),
        'size_info' => env('TICKET_FONT_SIZE_INFO', '8px'),
        'size_amount' => env('TICKET_FONT_SIZE_AMOUNT', '12px'),
        'size_footer' => env('TICKET_FONT_SIZE_FOOTER', '7px'),
    ],

    'spacing' => [
        'line_height' => env('TICKET_LINE_HEIGHT', '1.1'),
        'section_margin' => env('TICKET_SECTION_MARGIN', '5px'),
        'separator_margin' => env('TICKET_SEPARATOR_MARGIN', '3px'),
        'title_margin' => env('TICKET_TITLE_MARGIN', '3px'),
        'company_margin' => env('TICKET_COMPANY_MARGIN', '5px'),
    ],

    'content' => [
        'show_company_info' => env('TICKET_SHOW_COMPANY_INFO', true),
        'show_separator' => env('TICKET_SHOW_SEPARATOR', true),
        'show_thank_you' => env('TICKET_SHOW_THANK_YOU', true),
        'thank_you_text' => env('TICKET_THANK_YOU_TEXT', 'Terima kasih'),
        'date_format' => env('TICKET_DATE_FORMAT', 'd/m/y H:i'),
        'footer_date_format' => env('TICKET_FOOTER_DATE_FORMAT', 'd/m/Y H:i:s'),
    ],

    'auto_print' => [
        'enabled' => env('TICKET_AUTO_PRINT', true),
        'delay' => env('TICKET_AUTO_PRINT_DELAY', 500),
    ],

    'labels' => [
        'ticket' => env('TICKET_LABEL_TICKET', 'Tiket'),
        'license_plate' => env('TICKET_LABEL_LICENSE_PLATE', 'Plat'),
        'vehicle_type' => env('TICKET_LABEL_VEHICLE_TYPE', 'Jenis'),
        'entry_time' => env('TICKET_LABEL_ENTRY_TIME', 'Masuk'),
        'rate' => env('TICKET_LABEL_RATE', 'TARIF'),
    ],
];
