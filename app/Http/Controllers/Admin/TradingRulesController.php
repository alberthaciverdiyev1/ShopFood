<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TradingRules;
use Illuminate\Http\Request;

class TradingRulesController extends Controller
{
    public function index()
    {
        $rule = TradingRules::first();
        return view('admin.tradingRules.index', compact('rule'));
    }

    // Yeniləmək
    public function update(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);
        $data = $request->only('content');
        $rule = TradingRules::first();
        if (!$rule) {
            $rule = TradingRules::create([
                'content' =>$data['content'],
            ]);
        } else {
            $rule->update([
                'content' =>$data['content'],
            ]);
        }

        return redirect()->route('trading_rules.index')->with('success', 'Trading Rules updated successfully.');
    }

    public function tradingRulesHome()
    {
        $rule = TradingRules::first();
        return view('trading_rules.index', compact('rule'));
    }
}
