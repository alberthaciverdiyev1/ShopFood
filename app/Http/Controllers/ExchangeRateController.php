<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExchangeRate;

class ExchangeRateController extends Controller
{
    public function index()
    {
        $rates = ExchangeRate::all();
        return view('exchange_rates.index', compact('rates'));
    }

    public function edit($id)
    {
        $rate = ExchangeRate::findOrFail($id);
        return view('exchange_rates.edit', compact('rate'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rate' => 'required|numeric'
        ]);

        $rate = ExchangeRate::findOrFail($id);
        $rate->update(['rate' => $request->rate]);

        return redirect()->route('exchange-rates.index')->with('success', 'Rate updated successfully!');
    }
}
