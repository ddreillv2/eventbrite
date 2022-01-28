<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;

class EventsController extends Controller
{

    public function getEventDetails($event_id)
    {

        $response = Http::withToken(env('EVENTBRITE_ACCESS_TOKEN'))
            ->get(env('EVENTBRITE_API_URL') . '/events/' . $event_id);

        if ($response->successful()) {
            $respond = json_decode($response->body(), true);

            // Check Location details
            if ($respond['online_event']) {
                $respond['location'] = "Online event";
            } else if (!$respond['online_event'] && $respond['venue_id']) {
                $respond['location'] = $this->getEventVenue($respond['venue_id'])['name'];
            } else {
                $respond['location'] = "To be announced";
            }

            //Check ticket availability for LIVE or STARTED events
            if ($respond['status'] == "live" || $respond['status'] == "started") {
                $tickets = $this->getEventTickets($respond['id'])['ticket_classes'];

                $available_tickets = 0;
                $latest_reg_date = null;
                $a = 0;
                foreach ($tickets as $ticket) {
                    if ($ticket['on_sale_status'] == "AVAILABLE") {
                        $available_tickets++;
                    }

                    if (!$latest_reg_date) {
                        $latest_reg_date = $ticket['sales_start'];
                    } else {
                        if (strtotime($ticket['sales_start']) > strtotime($latest_reg_date)) {
                            $latest_reg_date = $ticket['sales_start'];
                        }
                    }

                    $a++;
                }

                if ($available_tickets >= 1) {
                    $respond['registration_status'] = "AVAILABLE";
                } else {
                    $respond['registration_status'] = "NOT_YET_AVAILABLE";
                }

                $respond['registration_date'] = $latest_reg_date;
            } else {
                $respond['registration_status'] = "UNAVAILABLE";
            }

            //Get event full html description
            $respond['description']['html'] = $this->getEventDescription($respond['id'])['description'];

        } else if ($response->failed()) {
            $respond = [];
        }

        return $respond;
    }

    public function getEventDescription($event_id)
    {
        $response = Http::withToken(env('EVENTBRITE_ACCESS_TOKEN'))
            ->get(env('EVENTBRITE_API_URL') . '/events/' . $event_id . '/description/');

        if ($response->successful()) {
            $respond = json_decode($response->body(), true);
        } else if ($response->failed()) {
            $respond = ["description" => "No description"];
        }

        return $respond;
    }

    public function getEventOrders($event_id)
    {
        return Http::withToken(env('EVENTBRITE_ACCESS_TOKEN'))
            ->get(env('EVENTBRITE_API_URL') . '/events/' . $event_id . '/orders/');
    }

    public function getEventAttendees($event_id, $filter)
    {
        return Http::withToken(env('EVENTBRITE_ACCESS_TOKEN'))
            ->get(env('EVENTBRITE_API_URL') . '/events/' . $event_id . '/attendees/', $filter);
    }

    public function getEventVenue($venue_id)
    {
        $response = Http::withToken(env('EVENTBRITE_ACCESS_TOKEN'))
            ->get(env('EVENTBRITE_API_URL') . '/venues/' . $venue_id);

        if ($response->successful()) {
            $respond = json_decode($response->body(), true);
        } else if ($response->failed()) {
            $respond = ["name" => "To be announced"];
        }

        return $respond;
    }

    public function getEventTickets($event_id)
    {
        $response = Http::withToken(env('EVENTBRITE_ACCESS_TOKEN'))
            ->get(env('EVENTBRITE_API_URL') . '/events/' . $event_id . '/ticket_classes/');

        if ($response->successful()) {
            $respond = json_decode($response->body(), true);
        } else if ($response->failed()) {
            $respond = [];
        }

        return $respond;
    }

    public function getAllEvents($filter)
    {
        $response = Http::withToken(env('EVENTBRITE_ACCESS_TOKEN'))
            ->get(env('EVENTBRITE_API_URL') . '/organizations/' . env('EVENTBRITE_ORG_ID') . '/events/', $filter);

        if ($response->successful()) {
            $respond  = json_decode($response->body(), true);

            $i = 0;
            foreach ($respond['events'] as $event) {

                // Check location details
                if ($event['online_event']) {
                    $respond['events'][$i]['location'] = "Online event";
                } else if (!$event['online_event'] && $event['venue_id']) {
                    $respond['events'][$i]['location'] = $this->getEventVenue($event['venue_id'])['name'];
                } else {
                    $respond['events'][$i]['location'] = "To be announced";
                }

                //Check ticket availability for LIVE or STARTED events
                if ($event['status'] == "live" || $event['status'] == "started") {
                    $tickets = $this->getEventTickets($event['id'])['ticket_classes'];

                    $available_tickets = 0;
                    $latest_reg_date = null;
                    $a = 0;
                    foreach ($tickets as $ticket) {
                        if ($ticket['on_sale_status'] == "AVAILABLE") {
                            $available_tickets++;
                        }

                        if (!$latest_reg_date) {
                            $latest_reg_date = $ticket['sales_start'];
                        } else {
                            if (strtotime($ticket['sales_start']) > strtotime($latest_reg_date)) {
                                $latest_reg_date = $ticket['sales_start'];
                            }
                        }

                        $a++;
                    }

                    if ($available_tickets >= 1) {
                        $respond['events'][$i]['registration_status'] = "AVAILABLE";
                    } else {
                        $respond['events'][$i]['registration_status'] = "NOT_YET_AVAILABLE";
                    }

                    $respond['events'][$i]['registration_date'] = $latest_reg_date;
                }

                $i++;
            }
        } else if ($response->failed()) {
            $respond = [];
        }

        return $respond;
    }
}
