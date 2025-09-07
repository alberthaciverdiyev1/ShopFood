<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{
    public function index()
    {
        try {
            $client = new \GuzzleHttp\Client();

            $url = 'https://shop-food.flexibee.eu/c/shop_food_s_r_o_/cenik.json';

            $response = $client->get($url, [
                'auth' => ['shopify_integration2', 'Salam123!'], // Basic Auth
                'headers' => [
                    'Accept' => 'application/json' // JSON format
                ],
                'verify' => false // SSL
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }



    public function welcome()
    {
        return view('welcome');
    }
}
