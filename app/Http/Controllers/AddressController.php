<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::where('user_id', Auth::id())->get();
        return response()->json($addresses);
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:20',
            'working_hours' => 'nullable|string|max:255',
            'is_default' => 'boolean'
        ]);

        if (!empty($data['is_default']) && $data['is_default'] == true) {
            Address::where('user_id', Auth::id())->update(['is_default' => false]);
        }

        $address = Address::create([
            'user_id' => Auth::id(),
            ...$data
        ]);

        return response()->json([
            'message' => 'Address added successfully',
            'address' => $address
        ], 201);
    }

    public function edit(Request $request, $id)
    {
        $address = Address::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $data = $request->validate([
            'street' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:20',
            'working_hours' => 'nullable|string|max:255',
            'is_default' => 'boolean'
        ]);

        if (!empty($data['is_default']) && $data['is_default'] == true) {
            Address::where('user_id', Auth::id())->update(['is_default' => false]);
        }

        $address->update($data);

        return response()->json([
            'message' => 'Address updated successfully',
            'address' => $address
        ]);
    }

    public function delete($id)
    {
        $address = Address::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $address->delete();

        return response()->json([
            'message' => 'Address deleted successfully'
        ]);
    }
}
