<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TicketConfigController extends Controller
{
    public function index()
    {
        $config = config('ticket');
        return view('admin.ticket-config', compact('config'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_title' => 'required|string|max:255',
            'company_address' => 'nullable|string|max:255',
            'company_phone' => 'nullable|string|max:255',
            'paper_width' => 'required|string|max:10',
            'font_size_base' => 'required|string|max:10',
            'font_size_title' => 'required|string|max:10',
            'font_size_info' => 'required|string|max:10',
            'thank_you_text' => 'required|string|max:255',
        ]);

        // Update .env file
        $envFile = base_path('.env');
        $env = File::get($envFile);

        $updates = [
            'TICKET_COMPANY_NAME' => $request->company_name,
            'TICKET_TITLE' => $request->company_title,
            'TICKET_ADDRESS' => $request->company_address ?? '',
            'TICKET_PHONE' => $request->company_phone ?? '',
            'TICKET_PAPER_WIDTH' => $request->paper_width,
            'TICKET_FONT_SIZE_BASE' => $request->font_size_base,
            'TICKET_FONT_SIZE_TITLE' => $request->font_size_title,
            'TICKET_FONT_SIZE_INFO' => $request->font_size_info,
            'TICKET_THANK_YOU_TEXT' => $request->thank_you_text,
            'TICKET_SHOW_COMPANY_INFO' => $request->has('show_company_info') ? 'true' : 'false',
            'TICKET_SHOW_SEPARATOR' => $request->has('show_separator') ? 'true' : 'false',
            'TICKET_SHOW_THANK_YOU' => $request->has('show_thank_you') ? 'true' : 'false',
            'TICKET_AUTO_PRINT' => $request->has('auto_print') ? 'true' : 'false',
        ];

        foreach ($updates as $key => $value) {
            $pattern = "/^{$key}=.*$/m";
            if (preg_match($pattern, $env)) {
                $env = preg_replace($pattern, "{$key}=\"{$value}\"", $env);
            } else {
                $env .= "\n{$key}=\"{$value}\"";
            }
        }

        File::put($envFile, $env);

        return redirect()->back()->with('success', 'Konfigurasi tiket berhasil diperbarui.');
    }
}
