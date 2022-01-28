<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;

class MediaController extends Controller
{
    public function getMediaInfo($media_id)
    {
        $response = Http::withToken(env('EVENTBRITE_ACCESS_TOKEN'))
            ->get(env('EVENTBRITE_API_URL') . '/media/' . $media_id);

        if ($response->successful()) {
            $respond  = json_decode($response->body(), true);
        } else if ($response->failed()) {
            $respond = [];
        }
        return $respond;
    }
}
