<?php

namespace App\Exports;

use App\Models\ParkingTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ParkingReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return [
            'No. Tiket',
            'Plat Nomor',
            'Jenis Kendaraan',
            'Tarif',
            'Waktu Masuk',
            'Catatan'
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->ticket_number,
            $transaction->license_plate,
            $transaction->vehicleType->name,
            $transaction->amount,
            $transaction->formatted_entry_time,
            $transaction->notes
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
