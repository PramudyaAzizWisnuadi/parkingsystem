<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class TicketConfigController extends Controller
{
    /**
     * Display the ticket configuration form
     */
    public function index()
    {
        $config = config('ticket');

        return view('admin.ticket-config', compact('config'));
    }

    /**
     * Update ticket configuration
     */
    public function update(Request $request)
    {
        $request->validate([
            'company_title' => 'nullable|string|max:100',
            'company_name' => 'nullable|string|max:100',
            'company_address' => 'nullable|string|max:200',
            'company_phone' => 'nullable|string|max:50',

            'ticket_number_label' => 'nullable|string|max:50',
            'license_plate_label' => 'nullable|string|max:50',
            'vehicle_type_label' => 'nullable|string|max:50',
            'entry_time_label' => 'nullable|string|max:50',
            'amount_label' => 'nullable|string|max:50',
            'amount_prefix' => 'nullable|string|max:10',

            'footer_message' => 'nullable|string|max:200',
            'copy_label_text' => 'nullable|string|max:50',

            'entry_time_format' => 'nullable|string|max:20',
            'footer_timestamp_format' => 'nullable|string|max:20',

            'auto_print_delay' => 'nullable|integer|min:0|max:5000',

            'separator_style' => 'nullable|in:solid,dashed,dotted',
            'header_alignment' => 'nullable|in:left,center,right',
            'info_alignment' => 'nullable|in:left,center,right',
            'amount_alignment' => 'nullable|in:left,center,right',
            'footer_alignment' => 'nullable|in:left,center,right',
        ]);

        try {
            // Read current .env file
            $envPath = base_path('.env');
            $envContent = File::get($envPath);

            // Define environment variables to update
            $envVars = [
                // Company Information
                'TICKET_TITLE' => $request->company_title ?? '',
                'TICKET_COMPANY_NAME' => $request->company_name ?? '',
                'TICKET_ADDRESS' => $request->company_address ?? '',
                'TICKET_PHONE' => $request->company_phone ?? '',

                // Field Display Settings
                'TICKET_SHOW_COMPANY_INFO' => $request->has('show_company_title') ? 'true' : 'false',
                'TICKET_SHOW_COMPANY_NAME' => $request->has('show_company_name') ? 'true' : 'false',
                'TICKET_SHOW_COMPANY_ADDRESS' => $request->has('show_company_address') ? 'true' : 'false',
                'TICKET_SHOW_COMPANY_PHONE' => $request->has('show_company_phone') ? 'true' : 'false',
                'TICKET_SHOW_TICKET_NUMBER' => $request->has('show_ticket_number') ? 'true' : 'false',
                'TICKET_SHOW_LICENSE_PLATE' => $request->has('show_license_plate') ? 'true' : 'false',
                'TICKET_REQUIRE_LICENSE_PLATE' => $request->has('require_license_plate') ? 'true' : 'false',
                'TICKET_SHOW_VEHICLE_TYPE' => $request->has('show_vehicle_type') ? 'true' : 'false',
                'TICKET_SHOW_ENTRY_TIME' => $request->has('show_entry_time') ? 'true' : 'false',
                'TICKET_SHOW_AMOUNT' => $request->has('show_amount') ? 'true' : 'false',
                'TICKET_SHOW_SEPARATOR' => $request->has('show_middle_separator') ? 'true' : 'false',
                'TICKET_SHOW_THANK_YOU' => $request->has('show_footer_message') ? 'true' : 'false',

                // Messages
                'TICKET_THANK_YOU_TEXT' => $request->footer_message ?? 'Terima kasih atas kunjungan Anda',

                // Auto Print
                'TICKET_AUTO_PRINT' => $request->has('auto_print_enabled') ? 'true' : 'false',
            ];

            // Update each environment variable
            foreach ($envVars as $key => $value) {
                $pattern = "/^{$key}=.*$/m";
                $replacement = "{$key}=" . (strpos($value, ' ') !== false ? "\"{$value}\"" : $value);

                if (preg_match($pattern, $envContent)) {
                    $envContent = preg_replace($pattern, $replacement, $envContent);
                } else {
                    $envContent .= "\n{$replacement}";
                }
            }

            // Write back to .env file
            File::put($envPath, $envContent);

            // Clear config cache to apply changes
            Artisan::call('config:clear');

            return redirect()->route('admin.ticket-config')
                ->with('success', 'Konfigurasi tiket berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Gagal memperbarui konfigurasi: ' . $e->getMessage()]);
        }
    }

    /**
     * Reset configuration to default values
     */
    public function reset()
    {
        try {
            // Read current .env file
            $envPath = base_path('.env');
            $envContent = File::get($envPath);

            // Default values
            $defaultVars = [
                'TICKET_TITLE' => 'TIKET PARKIR',
                'TICKET_COMPANY_NAME' => 'Manajemen Parkir',
                'TICKET_ADDRESS' => '',
                'TICKET_PHONE' => '',
                'TICKET_SHOW_COMPANY_INFO' => 'true',
                'TICKET_SHOW_COMPANY_NAME' => 'true',
                'TICKET_SHOW_COMPANY_ADDRESS' => 'true',
                'TICKET_SHOW_COMPANY_PHONE' => 'false',
                'TICKET_SHOW_TICKET_NUMBER' => 'true',
                'TICKET_SHOW_LICENSE_PLATE' => 'true',
                'TICKET_SHOW_VEHICLE_TYPE' => 'true',
                'TICKET_SHOW_ENTRY_TIME' => 'true',
                'TICKET_SHOW_AMOUNT' => 'true',
                'TICKET_SHOW_SEPARATOR' => 'true',
                'TICKET_SHOW_THANK_YOU' => 'true',
                'TICKET_THANK_YOU_TEXT' => 'Terima kasih atas kunjungan Anda',
                'TICKET_AUTO_PRINT' => 'true',
            ];

            // Update each environment variable
            foreach ($defaultVars as $key => $value) {
                $pattern = "/^{$key}=.*$/m";
                $replacement = "{$key}={$value}";

                if (preg_match($pattern, $envContent)) {
                    $envContent = preg_replace($pattern, $replacement, $envContent);
                } else {
                    $envContent .= "\n{$replacement}";
                }
            }

            // Write back to .env file
            File::put($envPath, $envContent);

            // Clear config cache
            Artisan::call('config:clear');

            return redirect()->route('admin.ticket-config')
                ->with('success', 'Konfigurasi tiket berhasil direset ke default!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Gagal mereset konfigurasi: ' . $e->getMessage()]);
        }
    }
}
