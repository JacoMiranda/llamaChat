<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function sendMessage(Request $request)
    {
        $text = $request->input('text');
        $client = new \GuzzleHttp\Client();
        $response = $client->post('http://127.0.0.1:3100/ai', [
            'json' => ['text' => $text]
        ]);

        return response()->json(json_decode($response->getBody()->getContents()));
    }
}
