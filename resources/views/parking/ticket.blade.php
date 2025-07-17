<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('ticket.company.title') }} - {{ $parking->ticket_number }}</title>
        <style>
            body {
                font-family: '{{ config('ticket.font.family') }}', monospace;
                margin: 0;
                padding: 0;
                background-color: white;
                width: {{ config('ticket.paper.width') }};
                font-size: {{ config('ticket.font.size_base') }};
                line-height: {{ config('ticket.spacing.line_height') }};
            }

            .ticket {
                width: {{ config('ticket.paper.width') }};
                padding: {{ config('ticket.paper.padding') }};
                margin: 0;
                text-align: center;
                background-color: white;
            }

            .ticket h1 {
                margin: 0 0 {{ config('ticket.spacing.title_margin') }} 0;
                font-size: {{ config('ticket.font.size_title') }};
                font-weight: bold;
            }

            .ticket h2 {
                margin: 0 0 {{ config('ticket.spacing.company_margin') }} 0;
                font-size: {{ config('ticket.font.size_company') }};
                font-weight: normal;
            }

            .company-info {
                text-align: center;
                margin: {{ config('ticket.spacing.section_margin') }} 0;
                font-size: {{ config('ticket.font.size_info') }};
            }

            .ticket-info {
                text-align: left;
                margin: {{ config('ticket.spacing.section_margin') }} 0;
                font-size: {{ config('ticket.font.size_info') }};
            }

            .ticket-info table {
                width: 100%;
                border-collapse: collapse;
                margin: 0;
            }

            .ticket-info td {
                padding: 0.5px 0;
                vertical-align: top;
                font-size: {{ config('ticket.font.size_info') }};
            }

            .ticket-info td:first-child {
                width: 35%;
            }

            .ticket-info td:last-child {
                text-align: right;
            }

            .amount {
                font-size: {{ config('ticket.font.size_amount') }};
                font-weight: bold;
                margin: {{ config('ticket.spacing.section_margin') }} 0;
                text-align: center;
                border-top: 1px dashed #000;
                border-bottom: 1px dashed #000;
                padding: 2px 0;
            }

            .footer {
                margin-top: {{ config('ticket.spacing.section_margin') }};
                font-size: {{ config('ticket.font.size_footer') }};
                text-align: center;
                line-height: 1.0;
            }

            .separator {
                border-top: 1px dashed #000;
                margin: {{ config('ticket.spacing.separator_margin') }} 0;
            }

            .no-print {
                display: none;
            }

            @media print {
                @page {
                    size: {{ config('ticket.paper.width') }} auto;
                    margin: 0;
                }

                body {
                    width: {{ config('ticket.paper.width') }};
                    margin: 0;
                    padding: 0;
                }

                .ticket {
                    width: {{ config('ticket.paper.width') }};
                    padding: {{ config('ticket.paper.print_padding') }};
                }

                .no-print {
                    display: none !important;
                }
            }

            @media screen {
                body {
                    background-color: #f0f0f0;
                    padding: 20px;
                    display: flex;
                    justify-content: center;
                    align-items: flex-start;
                    min-height: 100vh;
                }

                .ticket {
                    border: 1px solid #ccc;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    background-color: white;
                }

                .no-print {
                    display: block;
                    margin-top: 20px;
                    text-align: center;
                }

                .no-print button {
                    padding: 10px 20px;
                    margin: 0 5px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    font-size: 14px;
                }

                .btn-primary {
                    background-color: #007bff;
                    color: white;
                }

                .btn-secondary {
                    background-color: #6c757d;
                    color: white;
                }
            }
        </style>
    </head>

    <body>
        <div class="ticket">
            <h1>{{ config('ticket.company.title') }}</h1>
            <h2>{{ config('ticket.company.name') }}</h2>

            @if (config('ticket.content.show_company_info') && (config('ticket.company.address') || config('ticket.company.phone')))
                <div class="company-info">
                    @if (config('ticket.company.address'))
                        <p>{{ config('ticket.company.address') }}</p>
                    @endif
                    @if (config('ticket.company.phone'))
                        <p>{{ config('ticket.company.phone') }}</p>
                    @endif
                </div>
            @endif

            @if (config('ticket.content.show_separator'))
                <div class="separator"></div>
            @endif

            <div class="ticket-info">
                <table>
                    <tr>
                        <td>{{ config('ticket.labels.ticket') }}</td>
                        <td>{{ $parking->ticket_number }}</td>
                    </tr>
                    <tr>
                        <td>{{ config('ticket.labels.license_plate') }}</td>
                        <td>{{ $parking->license_plate }}</td>
                    </tr>
                    <tr>
                        <td>{{ config('ticket.labels.vehicle_type') }}</td>
                        <td>{{ $parking->vehicleType->name }}</td>
                    </tr>
                    <tr>
                        <td>{{ config('ticket.labels.entry_time') }}</td>
                        <td>{{ $parking->entry_time->format(config('ticket.content.date_format')) }}</td>
                    </tr>
                </table>
            </div>

            <div class="amount">
                {{ config('ticket.labels.rate') }}: Rp {{ number_format($parking->amount, 0, ',', '.') }}
            </div>

            @if (config('ticket.content.show_separator'))
                <div class="separator"></div>
            @endif

            <div class="footer">
                @if (config('ticket.content.show_thank_you'))
                    <p>{{ config('ticket.content.thank_you_text') }}</p>
                @endif
                <p>{{ $parking->entry_time->format(config('ticket.content.footer_date_format')) }}</p>
            </div>
        </div>

        <div class="no-print">
            <button onclick="window.print();" class="btn-primary">Print Tiket</button>
            <button onclick="window.close();" class="btn-secondary">Tutup</button>
        </div>

        <script>
            // Auto print when page loads
            @if (config('ticket.auto_print.enabled'))
                window.onload = function() {
                    setTimeout(function() {
                        window.print();
                    }, {{ config('ticket.auto_print.delay') }});
                };
            @endif
        </script>
    </body>

</html>
