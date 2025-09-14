<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    // Göstərmək
    public function index()
    {
        $policy = PrivacyPolicy::first();
        return view('admin.privacyPolicy.index', compact('policy'));
    }

    // Yeniləmək
    public function update(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);
        $data = $request->only('content');
        $policy = PrivacyPolicy::first();
        if (!$policy) {
            $policy = PrivacyPolicy::create([
                'content' =>$data['content'],
            ]);
        } else {
            $policy->update([
                'content' =>$data['content'],
            ]);
        }

        return redirect()->route('privacy-policy.index')->with('success', 'Privacy policy updated successfully.');
    }

    public function privacyPolicyHome()
    {
        $policy = PrivacyPolicy::first();
        return view('privacy_policy.index', compact('policy'));
    }
}
