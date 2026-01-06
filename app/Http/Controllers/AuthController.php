<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function update(Request $request, int $id)
    {
//        $request->validate([
//            'name' => 'required|string|max:255',
//            'email' => 'required|email',
//            'discount_percentage' => 'nullable|integer|min:0|max:100',
//        ]);

        $validated = $request->validate([
            'reg_number' => 'sometimes|required|string|max:50',            // ИНН Регистрационный номер
            'tax_number' => 'sometimes|required|string|max:50',            // ДРН (VAT) Налоговый номер
            'password' => 'sometimes|required|string|max:20|min:6',                 // Телефон
            'email' => 'sometimes|required|email|max:255',                 // Email
            'street' => 'sometimes|required|string|max:255',              // Улица, дом
            'city' => 'sometimes|required|string|max:100',                // Город
            'country' => 'sometimes|required|string|max:100',             // Страна
            'zip' => 'sometimes|required|string|max:20',                  // Индекс
            'contact_name' => 'sometimes|required|string|max:255',        // Имя, Фамилия
            'contact_phone' => 'sometimes|required|string|max:20',        // Телефон
        ]);

        $user = auth()->user();
        $user->update($validated);

        return redirect()->route('profile')->with('success', 'User updated successfully!');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);
            $user = User::where('email', $credentials['email'])->where('is_active', '=', true)->first();
            dd(
                Hash::check('salam123', $user->password)
            );
            if ($user && Auth::attempt($credentials)) {
                $request->session()->regenerate();

                return redirect()->intended('/');
            }

            return back()->withErrors([
                'email' => 'Email və ya şifrə yanlışdır.',
            ])->withInput();
        }

        return view('login');
    }

//    public function register(Request $request)
//    {
//        if ($request->isMethod('post')) {
//
//            // Validation
//            $validated = $request->validate([
//                'reg_number' => 'required|string|max:50',            // ИНН Регистрационный номер
//                'tax_number' => 'required|string|max:50',            // ДРН (VAT) Налоговый номер
//                'email' => 'required|email|max:255',                 // Email
//                'street' => 'required|string|max:255',              // Улица, дом
//                'city' => 'required|string|max:100',                // Город
//                'country' => 'required|string|max:100',             // Страна
//                'zip' => 'required|string|max:20',                  // Индекс
//                'contact_name' => 'required|string|max:255',        // Имя, Фамилия
//                'contact_phone' => 'required|string|max:20',        // Телефон
//            ]);
//
//            $user = User::create([
//                'reg_number' => $validated['reg_number'],
//                'tax_number' => $validated['tax_number'],
//                'password' => Hash::make(str()->random(10)), // Random password
//                'email' => $validated['email'] ?? null,
//                'street' => $validated['street'] ?? null,
//                'city' => $validated['city'] ?? null,
//                'country' => $validated['country'] ?? null,
//                'zip' => $validated['zip'] ?? null,
//                'contact_name' => $validated['contact_name'] ?? null,
//                'contact_phone' => $validated['contact_phone'] ?? null,
//                'is_active' => false,
//            ]);
//
//            return redirect()
//                ->route('web:register')
//                ->with('success', 'Yeni istifadeci uğurla qeydiyyatdan keçdi!');
//        }
//
//        return view('register');
//    }

    public function register(Request $request)
    {
        if ($request->isMethod('post')) {

            $validated = $request->validate([
                'reg_number'     => 'required|string|max:50',
                'tax_number'     => 'required|string|max:50',
                'email'          => 'required|email|max:255',
                'street'         => 'required|string|max:255',
                'city'           => 'required|string|max:100',
                'country'        => 'required|string|max:100',
                'zip'            => 'required|string|max:20',
                'contact_name'   => 'required|string|max:255',
                'contact_phone'  => 'required|string|max:20',
            ]);

            $user = User::create([
                'reg_number'   => $validated['reg_number'],
                'tax_number'   => $validated['tax_number'],
                'password'     => Hash::make(str()->random(10)),
                'email'        => $validated['email'],
                'street'       => $validated['street'],
                'city'         => $validated['city'],
                'country'      => $validated['country'],
                'zip'          => $validated['zip'],
                'contact_name' => $validated['contact_name'],
                'contact_phone'=> $validated['contact_phone'],
                'is_active'    => false,
            ]);

            try {
                $response = Http::withBasicAuth('shopify_integration2', 'Salam123!')
                    ->withoutVerifying()
                    ->post("https://shop-food.flexibee.eu/c/shop_food_s_r_o_/adresar.json", [
                        "winstrom" => [
                            "adresar" => [
                                [
                                    "kod"   => "CUST-" . $user->id,
                                    "nazev" => $validated['contact_name'],
                                    "mobil" => $validated['contact_phone'],
                                    "email" => $validated['email'],
                                    "ulice" => $validated['street'],
                                    "mesto" => $validated['city'],
                                    "psc"   => $validated['zip'],
                                    "stat"  => 203,
                                    //"stat"  => $validated['country'],
                                    "ic"    => $validated['reg_number'],
                                    "dic"   => $validated['tax_number'],
                                ]
                            ]
                        ]
                    ]);


                if (!$response->successful()) {
                    \Log::error('FLEXI REGISTER ERROR', $response->json());
                    info('FLEXI REGISTER ERROR', $response->json());
                }

            } catch (Exception $e) {
                \Log::error('FLEXI REGISTER ERROR', $response->json());
                info("FLEXI REGISTER EXCEPTION → ".$e->getMessage());
            }

            return redirect()->back()->with('success', 'Müşteri sisteme kaydedildi ve Flexi’ye iletildi.');
        }

        return view('register');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect('/welcome');
    }

    public function profile()
    {
//        $response = Http::withBasicAuth('shopify_integration2', 'Salam123!')
//            ->withoutVerifying()
//            ->get('https://shop-food.flexibee.eu/c/shop_food_s_r_o_/adresar.json', [
//                'detail' => 'full',
//                'limit'  => 0,
//            ]);
//
//        $data = $response->json();
//
//        $items = data_get($data, 'winstrom.adresar', []);
//
//        foreach ($items as $item) {
//
//            $email = data_get($item, 'email');
//            if (empty($email)) {
//                $email = 'external_'.$item['id'].'@shopfood.cz';
//            }
//
//            User::updateOrCreate(
//                ['email' => $email],
//                [
//                    'password' => bcrypt(Str::random(12)),
//
//                    'code'         => data_get($item, 'kod'),
//                    'name'         => data_get($item, 'nazev'),
//                    'contact_name' => data_get($item, 'nazev'),
//
//                    'reg_number' => data_get($item, 'ic'),
//                    'tax_number' => data_get($item, 'dic'),
//
//                    'phone'         => data_get($item, 'tel'),
//                    'contact_phone'=> data_get($item, 'mobil'),
//
//                    'street'  => data_get($item, 'ulice'),
//                    'city'    => data_get($item, 'mesto'),
//                    'zip'     => data_get($item, 'psc'),
//                    'country' => data_get($item, 'stat@showAs'),
//                ]
//            );
//        }


        //END

//        $response = Http::withBasicAuth('shopify_integration2','Salam123!')
//            ->withoutVerifying()
//            ->get("https://shop-food.flexibee.eu/c/shop_food_s_r_o_/stat.json", [
//                'detail' => 'full'
//            ]);
//
//        return $response->json();


        $user = auth()->user();
        return view('auth.profile', compact('user'));
    }

}
