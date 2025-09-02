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

            $response = $client->get('https://demo.flexibee.eu:5434/c/demo/cenik.xml?detail=full', [
                'auth' => ['winstrom', 'winstrom'],
                'verify' => false
            ]);

            $xmlContent = $response->getBody()->getContents();

            // XML-i parse et
            $xml = simplexml_load_string($xmlContent, "SimpleXMLElement", LIBXML_NOCDATA);

            // JSON formatına çevir
            $json = json_encode($xml);

            // Array formatına çevir (istəyə görə)
            $data = json_decode($json, true);

            return response()->json($data);

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
