<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrivacyPolicy;

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
        $content = $request->only('content');

        $policy = PrivacyPolicy::first();
        if (!$policy) {
            $policy = PrivacyPolicy::create([
                'content' =>$content,
            ]);
        } else {
            $policy->update([
                'content' =>$content,
            ]);
        }

        return response()->json($policy);
    }
}
