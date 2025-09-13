<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;

class ExchangeRateController extends Controller
{
    public function index()
    {
        $rates = ExchangeRate::all();
        return view('admin.currency.index', compact('rates'));
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
