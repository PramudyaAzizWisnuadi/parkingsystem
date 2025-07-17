<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ParkingTransaction;

class StoreParkingTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'license_plate' => [
                'required',
                'string',
                'max:20',
                function ($attribute, $value, $fail) {
                    if (!ParkingTransaction::validateLicensePlate($value)) {
                        $fail('Format plat nomor tidak valid. Contoh format yang benar: B 1234 ABC untuk mobil, B 1234 AB untuk motor.');
                    }
                }
            ],
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'notes' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'license_plate.required' => 'Plat nomor kendaraan wajib diisi.',
            'license_plate.string' => 'Plat nomor kendaraan harus berupa teks.',
            'license_plate.max' => 'Plat nomor kendaraan tidak boleh lebih dari 20 karakter.',
            'vehicle_type_id.required' => 'Jenis kendaraan wajib dipilih.',
            'vehicle_type_id.exists' => 'Jenis kendaraan yang dipilih tidak valid.',
            'notes.string' => 'Catatan harus berupa teks.',
            'notes.max' => 'Catatan tidak boleh lebih dari 500 karakter.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'license_plate' => 'plat nomor kendaraan',
            'vehicle_type_id' => 'jenis kendaraan',
            'notes' => 'catatan',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'license_plate' => strtoupper(trim($this->license_plate ?? '')),
        ]);
    }
}
