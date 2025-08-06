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

    /*
    |--------------------------------------------------------------------------
    | Field Display Configuration
    |--------------------------------------------------------------------------
    |
    | Configure which fields to show/hide on the ticket
    |
    */
    'fields' => [
        'company_title' => [
            'show' => env('TICKET_SHOW_COMPANY_TITLE', true),
            'label' => env('TICKET_LABEL_COMPANY_TITLE', 'TIKET PARKIR'),
        ],
        'company_name' => [
            'show' => env('TICKET_SHOW_COMPANY_NAME', true),
            'label' => env('TICKET_LABEL_COMPANY_NAME', 'Manajemen Parkir'),
        ],
        'company_address' => [
            'show' => env('TICKET_SHOW_COMPANY_ADDRESS', true),
        ],
        'company_phone' => [
            'show' => env('TICKET_SHOW_COMPANY_PHONE', true),
        ],
        'ticket_number' => [
            'show' => env('TICKET_SHOW_TICKET_NUMBER', true),
            'label' => env('TICKET_LABEL_TICKET_NUMBER', 'No. Tiket'),
        ],
        'license_plate' => [
            'show' => env('TICKET_SHOW_LICENSE_PLATE', true),
            'label' => env('TICKET_LABEL_LICENSE_PLATE', 'Plat Nomor'),
            'required' => env('TICKET_REQUIRE_LICENSE_PLATE', false), // Show even if empty
        ],
        'vehicle_type' => [
            'show' => env('TICKET_SHOW_VEHICLE_TYPE', true),
            'label' => env('TICKET_LABEL_VEHICLE_TYPE', 'Jenis Kendaraan'),
        ],
        'entry_time' => [
            'show' => env('TICKET_SHOW_ENTRY_TIME', true),
            'label' => env('TICKET_LABEL_ENTRY_TIME', 'Waktu Masuk'),
            'format' => env('TICKET_ENTRY_TIME_FORMAT', 'd/m/Y H:i'),
        ],
        'amount' => [
            'show' => env('TICKET_SHOW_AMOUNT', true),
            'label' => env('TICKET_LABEL_AMOUNT', 'Tarif'),
            'prefix' => env('TICKET_AMOUNT_PREFIX', 'Rp '),
            'format' => env('TICKET_AMOUNT_FORMAT', '0,0.'), // Laravel number format style
        ],
        'footer_message' => [
            'show' => env('TICKET_SHOW_FOOTER_MESSAGE', true),
            'text' => env('TICKET_FOOTER_MESSAGE', 'Terima kasih atas kunjungan Anda'),
        ],
        'footer_timestamp' => [
            'show' => env('TICKET_SHOW_FOOTER_TIMESTAMP', true),
            'format' => env('TICKET_FOOTER_TIMESTAMP_FORMAT', 'd-m-Y H:i:s'),
        ],
        'copy_label' => [
            'show' => env('TICKET_SHOW_COPY_LABEL', true),
            'text' => env('TICKET_COPY_LABEL_TEXT', '-- COPY --'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Layout Options
    |--------------------------------------------------------------------------
    |
    | Configure layout and visual elements
    |
    */
    'layout' => [
        'show_top_separator' => env('TICKET_SHOW_TOP_SEPARATOR', true),
        'show_middle_separator' => env('TICKET_SHOW_MIDDLE_SEPARATOR', true),
        'show_bottom_separator' => env('TICKET_SHOW_BOTTOM_SEPARATOR', true),
        'separator_style' => env('TICKET_SEPARATOR_STYLE', 'dashed'), // solid, dashed, dotted
        'header_alignment' => env('TICKET_HEADER_ALIGNMENT', 'center'), // left, center, right
        'info_alignment' => env('TICKET_INFO_ALIGNMENT', 'left'), // left, center, right
        'amount_alignment' => env('TICKET_AMOUNT_ALIGNMENT', 'center'), // left, center, right
        'footer_alignment' => env('TICKET_FOOTER_ALIGNMENT', 'center'), // left, center, right
    ],
];
