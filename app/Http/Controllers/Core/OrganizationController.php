<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;

//Controllers
use App\Http\Controllers\Core\MediaController as Media;
class OrganizationController extends Controller
{
    public function getOrganization()
    {
        $response = Http::withToken(env('EVENTBRITE_ACCESS_TOKEN'))
            ->get(env('EVENTBRITE_API_URL') . '/users/me/organizations/');

        if ($response->successful()) {
            $respond_raw = json_decode($response->body(), true);

            $found_org = 0;
            $i = 0;
            foreach ($respond_raw['organizations'] as $organization) {

                if ($organization['id'] == env('EVENTBRITE_ORG_ID')) {
                    $respond = $respond_raw['organizations'][$i];
                    $respond['logo'] = (new Media)->getMediaInfo($organization['image_id']);
                    $found_org++;
                }

                $i++;
            }

            if ($found_org == 0) {
                $respond['id'] = null;
            }
        } else if ($response->failed()) {
            $respond['id'] = null;
        }

        return $respond;
    }

    public function getAllOrganization()
    {
        $response = Http::withToken(env('EVENTBRITE_ACCESS_TOKEN'))
            ->get(env('EVENTBRITE_API_URL') . '/users/me/organizations/');

        if ($response->successful()) {
            $respond  = json_decode($response->body(), true);
        } else if ($response->failed()) {
            $respond = [];
        }
        return $respond;
    }
}
