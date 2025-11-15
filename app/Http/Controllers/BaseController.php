<?php

namespace App\Http\Controllers;

use App\Jobs\CompressImage;
use App\Jobs\FetchFlexibeeData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class BaseController extends Controller
{
    public function changeLocale(Request $request)
    {
        $request->validate([
            'locale' => ['required', 'in:cz,en'],
        ]);

        session(['app-locale' => $request->input('locale')]);

        return back();
    }

    public function startQueue()
    {
        FetchFlexibeeData::dispatch(1880, 20);

        return response()->json([
            'success' => true,
            'message' => 'Product sync started. Queue will process all data.',
        ]);
    }

    public function startStockQueue()
    {
        FetchFlexibeeData::dispatch(0, 20,true);

        return response()->json([
            'success' => true,
            'message' => 'Warehouse sync started. Queue will process all data.',
        ]);
    }

}
