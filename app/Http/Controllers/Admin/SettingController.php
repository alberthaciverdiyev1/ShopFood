<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('admin.setting.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'whatsapp_link' => 'nullable',
            'telegram_link' => 'nullable',
        ]);

        $data = $request->only('whatsapp_link', 'telegram_link');

        $setting = Setting::first();

        if (!$setting) {
            $setting = Setting::create($data);
        } else {
            $setting->update($data);
        }

        return redirect()
            ->route('setting.index')
            ->with('success', 'Settings updated successfully.');
    }
}
