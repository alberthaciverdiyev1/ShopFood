<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Bu sətirlər Laravel Validator tərəfindən istifadə olunan standart
    | doğrulama mesajlarını ehtiva edir.
    |
    */

    'accepted'             => ':attribute qəbul edilməlidir.',
    'active_url'           => ':attribute düzgün URL deyil.',
    'after'                => ':attribute :date tarixindən sonra olmalıdır.',
    'after_or_equal'       => ':attribute :date tarixindən sonra və ya ona bərabər olmalıdır.',
    'alpha'                => ':attribute yalnız hərflərdən ibarət ola bilər.',
    'alpha_dash'           => ':attribute yalnız hərflər, rəqəmlər və tirelərdən ibarət ola bilər.',
    'alpha_num'            => ':attribute yalnız hərflər və rəqəmlərdən ibarət ola bilər.',
    'array'                => ':attribute massiv olmalıdır.',
    'before'               => ':attribute :date tarixindən əvvəl olmalıdır.',
    'before_or_equal'      => ':attribute :date tarixindən əvvəl və ya ona bərabər olmalıdır.',
    'between'              => [
        'numeric' => ':attribute :min ilə :max arasında olmalıdır.',
        'file'    => ':attribute :min və :max kilobayt arasında olmalıdır.',
        'string'  => ':attribute :min və :max simvol arasında olmalıdır.',
        'array'   => ':attribute :min və :max element arasında olmalıdır.',
    ],
    'boolean'              => ':attribute yalnız doğru və ya yanlış ola bilər.',
    'confirmed'            => ':attribute təsdiqi uyğun gəlmir.',
    'date'                 => ':attribute düzgün tarix deyil.',
    'date_equals'          => ':attribute :date tarixinə bərabər olmalıdır.',
    'date_format'          => ':attribute :format formatına uyğun deyil.',
    'different'            => ':attribute və :other fərqli olmalıdır.',
    'digits'               => ':attribute :digits rəqəmdən ibarət olmalıdır.',
    'digits_between'       => ':attribute :min ilə :max rəqəm arasında olmalıdır.',
    'dimensions'           => ':attribute düzgün ölçülərdə şəkil deyil.',
    'distinct'             => ':attribute dublikat dəyərdir.',
    'email'                => ':attribute düzgün e-mail olmalıdır.',
    'exists'               => 'Seçilmiş :attribute düzgün deyil.',
    'file'                 => ':attribute fayl olmalıdır.',
    'filled'               => ':attribute dəyər olmalıdır.',
    'gt'                   => [
        'numeric' => ':attribute :value-dan böyük olmalıdır.',
        'file'    => ':attribute :value kilobaytdan böyük olmalıdır.',
        'string'  => ':attribute :value simvoldan uzun olmalıdır.',
        'array'   => ':attribute :value-dan çox elementə malik olmalıdır.',
    ],
    'gte'                  => [
        'numeric' => ':attribute :value-dan böyük və ya bərabər olmalıdır.',
        'file'    => ':attribute :value kilobaytdan böyük və ya bərabər olmalıdır.',
        'string'  => ':attribute :value simvoldan uzun və ya bərabər olmalıdır.',
        'array'   => ':attribute :value və ya daha çox elementə malik olmalıdır.',
    ],
    'image'                => ':attribute şəkil olmalıdır.',
    'in'                   => 'Seçilmiş :attribute düzgün deyil.',
    'in_array'             => ':attribute :other içində mövcud deyil.',
    'integer'              => ':attribute tam ədəd olmalıdır.',
    'ip'                   => ':attribute düzgün IP ünvanıdır.',
    'ipv4'                 => ':attribute düzgün IPv4 ünvanıdır.',
    'ipv6'                 => ':attribute düzgün IPv6 ünvanıdır.',
    'json'                 => ':attribute düzgün JSON string olmalıdır.',
    'lt'                   => [
        'numeric' => ':attribute :value-dan kiçik olmalıdır.',
        'file'    => ':attribute :value kilobaytdan kiçik olmalıdır.',
        'string'  => ':attribute :value simvoldan qısa olmalıdır.',
        'array'   => ':attribute :value-dan az elementə malik olmalıdır.',
    ],
    'lte'                  => [
        'numeric' => ':attribute :value-dan kiçik və ya bərabər olmalıdır.',
        'file'    => ':attribute :value kilobaytdan kiçik və ya bərabər olmalıdır.',
        'string'  => ':attribute :value simvoldan qısa və ya bərabər olmalıdır.',
        'array'   => ':attribute :value və ya az elementə malik olmalıdır.',
    ],
    'max'                  => [
        'numeric' => ':attribute :max-dan böyük ola bilməz.',
        'file'    => ':attribute :max kilobaytdan böyük ola bilməz.',
        'string'  => ':attribute :max simvoldan uzun ola bilməz.',
        'array'   => ':attribute :max elementdən çox ola bilməz.',
    ],
    'mimes'                => ':attribute :values tipli fayl olmalıdır.',
    'mimetypes'            => ':attribute :values tipli fayl olmalıdır.',
    'min'                  => [
        'numeric' => ':attribute ən az :min olmalıdır.',
        'file'    => ':attribute ən az :min kilobayt olmalıdır.',
        'string'  => ':attribute ən az :min simvoldan ibarət olmalıdır.',
        'array'   => ':attribute ən az :min elementə malik olmalıdır.',
    ],
    'not_in'               => 'Seçilmiş :attribute düzgün deyil.',
    'numeric'              => ':attribute rəqəm olmalıdır.',
    'present'              => ':attribute mövcud olmalıdır.',
    'regex'                => ':attribute düzgün formatda deyil.',
    'required'             => ':attribute doldurulması tələb olunur.',
    'required_if'          => ':attribute :other :value olduqda tələb olunur.',
    'required_unless'      => ':attribute :other :values olmadıqca tələb olunur.',
    'required_with'        => ':attribute :values olduqda tələb olunur.',
    'required_with_all'    => ':attribute :values olduqda tələb olunur.',
    'required_without'     => ':attribute :values olmadıqda tələb olunur.',
    'required_without_all' => ':attribute :values olmadıqda tələb olunur.',
    'same'                 => ':attribute və :other eyni olmalıdır.',
    'size'                 => [
        'numeric' => ':attribute :size olmalıdır.',
        'file'    => ':attribute :size kilobayt olmalıdır.',
        'string'  => ':attribute :size simvol olmalıdır.',
        'array'   => ':attribute :size element olmalıdır.',
    ],
    'string'               => ':attribute sətir olmalıdır.',
    'timezone'             => ':attribute düzgün zaman zonası olmalıdır.',
    'unique'               => ':attribute artıq mövcuddur.',
    'uploaded'             => ':attribute yükləmə uğursuz oldu.',
    'url'                  => ':attribute düzgün URL deyil.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Messages
    |--------------------------------------------------------------------------
    */
    'custom' => [
        'full_name' => [
            'required' => '"Ad Soyad" doldurulması tələb olunur.',
        ],
        'email' => [
            'required' => '"Email" doldurulması tələb olunur.',
            'email' => 'Düzgün Email daxil edin.',
            'unique' => 'Bu Email artıq mövcuddur.',
        ],
        'password' => [
            'required' => '"Şifrə" doldurulması tələb olunur.',
            'min' => 'Şifrə ən az :min simvoldan ibarət olmalıdır.',
        ],
        // Digər sahələri əlavə edə bilərsən
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Attributes
    |--------------------------------------------------------------------------
    */
    'attributes' => [
        'full_name' => 'Ad Soyad',
        'email' => 'Email',
        'password' => 'Şifrə',
        'register_number' => 'Qeydiyyat nömrəsi',
        'vat_number' => 'VAT nömrəsi',
        'phone' => 'Telefon',
        'street' => 'Küçə',
        'city' => 'Şəhər',
        'address' => 'Ünvan',
    ],

];
