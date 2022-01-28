<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;

//Controllers
use App\Http\Controllers\Core\EventsController as Events;

class EventsController extends Controller
{

    public function view_eventsList()
    {
        $events = (new Events)->getAllEvents(["status" => "live,started,ended,completed", "order_by" => "start_desc"]);
        return view("admin.events_list", ["events" => $events]);
    }


    public function view_eventDetails($id)
    {
        $Events = new Events;
        $eventDetails_info = $Events->getEventDetails($id);

        if (sizeof($eventDetails_info) >= 1) {

            if ($eventDetails_info['status'] != "draft" && $eventDetails_info['status'] != "canceled") {
                return view("admin.event_details", ["has_event" => true, "eventInfo" => $eventDetails_info]);
            } else {
                return view("admin.event_details", ["has_event" => false]);
            }
        } else {
            return view("admin.event_details", ["has_event" => false]);
        }

    }


    // Axios Requests

    public function axios_retrieveAll()
    {
        return (new Events)->getAllEvents(["status" => "live,started,ended,completed", "order_by" => "start_desc"]);
    }
}
