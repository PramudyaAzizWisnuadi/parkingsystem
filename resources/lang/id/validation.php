<?php

return [
    'accepted' => 'Field :attribute harus diterima.',
    'active_url' => 'Field :attribute bukan URL yang valid.',
    'after' => 'Field :attribute harus tanggal setelah :date.',
    'after_or_equal' => 'Field :attribute harus tanggal setelah atau sama dengan :date.',
    'alpha' => 'Field :attribute hanya boleh mengandung huruf.',
    'alpha_dash' => 'Field :attribute hanya boleh mengandung huruf, angka, tanda hubung, dan garis bawah.',
    'alpha_num' => 'Field :attribute hanya boleh mengandung huruf dan angka.',
    'array' => 'Field :attribute harus berupa array.',
    'before' => 'Field :attribute harus tanggal sebelum :date.',
    'before_or_equal' => 'Field :attribute harus tanggal sebelum atau sama dengan :date.',
    'between' => [
        'numeric' => 'Field :attribute harus antara :min dan :max.',
        'file' => 'Field :attribute harus antara :min dan :max kilobytes.',
        'string' => 'Field :attribute harus antara :min dan :max karakter.',
        'array' => 'Field :attribute harus antara :min dan :max item.',
    ],
    'boolean' => 'Field :attribute harus berupa true atau false.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'date' => 'Field :attribute bukan tanggal yang valid.',
    'date_equals' => 'Field :attribute harus tanggal yang sama dengan :date.',
    'date_format' => 'Field :attribute tidak cocok dengan format :format.',
    'different' => 'Field :attribute dan :other harus berbeda.',
    'digits' => 'Field :attribute harus :digits digit.',
    'digits_between' => 'Field :attribute harus antara :min dan :max digit.',
    'dimensions' => 'Field :attribute memiliki dimensi gambar yang tidak valid.',
    'distinct' => 'Field :attribute memiliki nilai duplikat.',
    'email' => 'Field :attribute harus berupa alamat email yang valid.',
    'ends_with' => 'Field :attribute harus diakhiri dengan salah satu dari: :values.',
    'exists' => ':attribute yang dipilih tidak valid.',
    'file' => 'Field :attribute harus berupa file.',
    'filled' => 'Field :attribute harus memiliki nilai.',
    'gt' => [
        'numeric' => 'Field :attribute harus lebih besar dari :value.',
        'file' => 'Field :attribute harus lebih besar dari :value kilobytes.',
        'string' => 'Field :attribute harus lebih besar dari :value karakter.',
        'array' => 'Field :attribute harus memiliki lebih dari :value item.',
    ],
    'gte' => [
        'numeric' => 'Field :attribute harus lebih besar atau sama dengan :value.',
        'file' => 'Field :attribute harus lebih besar atau sama dengan :value kilobytes.',
        'string' => 'Field :attribute harus lebih besar atau sama dengan :value karakter.',
        'array' => 'Field :attribute harus memiliki :value item atau lebih.',
    ],
    'image' => 'Field :attribute harus berupa gambar.',
    'in' => ':attribute yang dipilih tidak valid.',
    'in_array' => 'Field :attribute tidak ada di :other.',
    'integer' => 'Field :attribute harus berupa bilangan bulat.',
    'ip' => 'Field :attribute harus berupa alamat IP yang valid.',
    'ipv4' => 'Field :attribute harus berupa alamat IPv4 yang valid.',
    'ipv6' => 'Field :attribute harus berupa alamat IPv6 yang valid.',
    'json' => 'Field :attribute harus berupa JSON string yang valid.',
    'lt' => [
        'numeric' => 'Field :attribute harus kurang dari :value.',
        'file' => 'Field :attribute harus kurang dari :value kilobytes.',
        'string' => 'Field :attribute harus kurang dari :value karakter.',
        'array' => 'Field :attribute harus memiliki kurang dari :value item.',
    ],
    'lte' => [
        'numeric' => 'Field :attribute harus kurang dari atau sama dengan :value.',
        'file' => 'Field :attribute harus kurang dari atau sama dengan :value kilobytes.',
        'string' => 'Field :attribute harus kurang dari atau sama dengan :value karakter.',
        'array' => 'Field :attribute harus memiliki :value item atau kurang.',
    ],
    'max' => [
        'numeric' => 'Field :attribute tidak boleh lebih besar dari :max.',
        'file' => 'Field :attribute tidak boleh lebih besar dari :max kilobytes.',
        'string' => 'Field :attribute tidak boleh lebih dari :max karakter.',
        'array' => 'Field :attribute tidak boleh memiliki lebih dari :max item.',
    ],
    'mimes' => 'Field :attribute harus berupa file dengan tipe: :values.',
    'mimetypes' => 'Field :attribute harus berupa file dengan tipe: :values.',
    'min' => [
        'numeric' => 'Field :attribute harus minimal :min.',
        'file' => 'Field :attribute harus minimal :min kilobytes.',
        'string' => 'Field :attribute harus minimal :min karakter.',
        'array' => 'Field :attribute harus memiliki minimal :min item.',
    ],
    'not_in' => ':attribute yang dipilih tidak valid.',
    'not_regex' => 'Format field :attribute tidak valid.',
    'numeric' => 'Field :attribute harus berupa angka.',
    'password' => 'Password salah.',
    'present' => 'Field :attribute harus ada.',
    'regex' => 'Format field :attribute tidak valid.',
    'required' => 'Field :attribute wajib diisi.',
    'required_if' => 'Field :attribute wajib diisi ketika :other adalah :value.',
    'required_unless' => 'Field :attribute wajib diisi kecuali :other ada di :values.',
    'required_with' => 'Field :attribute wajib diisi ketika :values ada.',
    'required_with_all' => 'Field :attribute wajib diisi ketika :values ada.',
    'required_without' => 'Field :attribute wajib diisi ketika :values tidak ada.',
    'required_without_all' => 'Field :attribute wajib diisi ketika tidak ada :values.',
    'same' => 'Field :attribute dan :other harus cocok.',
    'size' => [
        'numeric' => 'Field :attribute harus :size.',
        'file' => 'Field :attribute harus :size kilobytes.',
        'string' => 'Field :attribute harus :size karakter.',
        'array' => 'Field :attribute harus mengandung :size item.',
    ],
    'starts_with' => 'Field :attribute harus dimulai dengan salah satu dari: :values.',
    'string' => 'Field :attribute harus berupa string.',
    'timezone' => 'Field :attribute harus berupa zona waktu yang valid.',
    'unique' => ':attribute sudah digunakan.',
    'uploaded' => ':attribute gagal diupload.',
    'url' => 'Format field :attribute tidak valid.',
    'uuid' => 'Field :attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "rule.attribute" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'license_plate' => [
            'required' => 'Plat nomor kendaraan wajib diisi.',
            'string' => 'Plat nomor kendaraan harus berupa teks.',
            'max' => 'Plat nomor kendaraan tidak boleh lebih dari 20 karakter.',
            'format' => 'Format plat nomor tidak valid. Contoh format yang benar: B 1234 ABC untuk mobil, B 1234 AB untuk motor.',
        ],
        'vehicle_type_id' => [
            'required' => 'Jenis kendaraan wajib dipilih.',
            'exists' => 'Jenis kendaraan yang dipilih tidak valid.',
        ],
        'amount' => [
            'required' => 'Jumlah tarif wajib diisi.',
            'numeric' => 'Jumlah tarif harus berupa angka.',
            'min' => 'Jumlah tarif tidak boleh kurang dari 0.',
        ],
        'entry_time' => [
            'required' => 'Waktu masuk wajib diisi.',
            'date' => 'Waktu masuk harus berupa tanggal yang valid.',
        ],
        'notes' => [
            'string' => 'Catatan harus berupa teks.',
        ],
        'email' => [
            'required' => 'Email wajib diisi.',
            'email' => 'Format email tidak valid.',
            'unique' => 'Email sudah terdaftar.',
        ],
        'password' => [
            'required' => 'Password wajib diisi.',
            'min' => 'Password harus minimal 8 karakter.',
            'confirmed' => 'Konfirmasi password tidak cocok.',
        ],
        'name' => [
            'required' => 'Nama wajib diisi.',
            'string' => 'Nama harus berupa teks.',
            'max' => 'Nama tidak boleh lebih dari 255 karakter.',
        ],
        'role' => [
            'required' => 'Role wajib dipilih.',
            'in' => 'Role yang dipilih tidak valid.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'license_plate' => 'plat nomor kendaraan',
        'vehicle_type_id' => 'jenis kendaraan',
        'amount' => 'jumlah tarif',
        'entry_time' => 'waktu masuk',
        'notes' => 'catatan',
        'email' => 'email',
        'password' => 'password',
        'password_confirmation' => 'konfirmasi password',
        'name' => 'nama',
        'role' => 'role',
        'current_password' => 'password saat ini',
        'new_password' => 'password baru',
        'remember' => 'ingat saya',
    ],
];
