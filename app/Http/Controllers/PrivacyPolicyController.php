<?php

namespace App\Http\Controllers;

use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    // Göstərmək
    public function index()
    {
        $policy = PrivacyPolicy::first();
        return response()->json($policy);
    }

    // Yeniləmək
    public function update(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $policy = PrivacyPolicy::first();
        if (!$policy) {
            $policy = PrivacyPolicy::create([
                'content' => $request->content,
            ]);
        } else {
            $policy->update([
                'content' => $request->content,
            ]);
        }

        return response()->json($policy);
    }
}
