<?php

namespace App\Http\Controllers\OAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Session;

//Controllers
use App\Http\Controllers\Core\OrganizationController as Org;

class EventbriteAuthController extends Controller
{
    public function redirect(Request $request)
    {
        $response = Http::asForm()
            ->post(env('EVENTBRITE_AUTH_URL') . '/oauth/token', [
                'grant_type' => 'authorization_code',
                'client_id' => env('EVENTBRITE_API_KEY'),
                'client_secret' => env('EVENTBRITE_API_CLIENT_SECRET'),
                'code' => $request->input('code'),
                'redirect_uri' => url('/oauth/eventbrite/redirect'),
            ]);

        put_permanent_env('EVENTBRITE_ACCESS_CODE',  $request->input('code'));

        if ($response->successful()) {

            $respond  = json_decode($response->body(), true);
            put_permanent_env('EVENTBRITE_ACCESS_TOKEN',  $respond['access_token']);

            Session::flash("setup_status", "SUCCESS");
            return redirect()->route('eventbrite-setup-org');
        } else if ($response->failed()) {

            Session::flash("setup_status", "FAILED");
            Session::flash("error_msg", $response['error_description']);
            put_permanent_env('EVENTBRITE_ACCESS_TOKEN',  "");
            return redirect()->route('eventbrite-setup');
        }
    }

    public function getUserDetails()
    {

        $response = Http::withToken(env('EVENTBRITE_ACCESS_TOKEN'))
            ->get(env('EVENTBRITE_API_URL') . '/users/me/');

        if ($response->successful()) {
            $respond  = json_decode($response->body(), true);
        } else if ($response->failed()) {
            $respond['id'] = null;
        }

        return $respond;
    }

    public function view_setup()
    {
        $EVENTBRITE_ACCESS_TOKEN = env('EVENTBRITE_ACCESS_TOKEN');
        $EVENTBRITE_ORG_ID = env('EVENTBRITE_ORG_ID');

        if ($EVENTBRITE_ACCESS_TOKEN != "" && $EVENTBRITE_ORG_ID != "") {
            if ($this->getUserDetails()['id'] == null) {

                Session::flash("error_msg", "API Credentials is invalid, please provide a correct credentials");
                put_permanent_env('EVENTBRITE_ACCESS_TOKEN',  "");
                put_permanent_env('EVENTBRITE_ORG_ID',  "");

                return view('setup.key', ['type' => 'SETUP']);
            } else {

                $orgInfo = (new Org)->getOrganization();
                if ($orgInfo['id'] == null) {

                    return redirect()->route('eventbrite-setup-org');
                } else {

                    return view('setup.key', ['type' => 'INFO', 'orgInfo' => $orgInfo]);
                }
            }
        } else if ($EVENTBRITE_ACCESS_TOKEN == "" && $EVENTBRITE_ORG_ID == "") {

            return view('setup.key', ['type' => 'SETUP']);
        } else if ($EVENTBRITE_ACCESS_TOKEN == "" && $EVENTBRITE_ORG_ID != "") {

            put_permanent_env('EVENTBRITE_ORG_ID',  "");
            return view('setup.key', ['type' => 'SETUP']);
        } else if ($EVENTBRITE_ACCESS_TOKEN != "" && $EVENTBRITE_ORG_ID == "") {

            if ($this->getUserDetails()['id'] == null) {

                Session::flash("error_msg", "API Credentials is invalid, please provide a correct credentials");
                put_permanent_env('EVENTBRITE_ACCESS_TOKEN',  "");
                put_permanent_env('EVENTBRITE_ORG_ID',  "");

                return view('setup.key', ['type' => 'SETUP']);
            } else {

                Session::flash("error_msg", "Please choose an Organization");
                return redirect()->route('eventbrite-setup-org');
            }
        }
    }

    public function view_setupOrg()
    {
        $EVENTBRITE_ACCESS_TOKEN = env('EVENTBRITE_ACCESS_TOKEN');
        $EVENTBRITE_ORG_ID = env('EVENTBRITE_ORG_ID');

        if ($EVENTBRITE_ACCESS_TOKEN != "" && $EVENTBRITE_ORG_ID != "") {
            if ($this->getUserDetails()['id'] == null) {

                Session::flash("error_msg", "API Credentials is invalid, please provide a correct credentials");
                put_permanent_env('EVENTBRITE_ACCESS_TOKEN',  "");
                put_permanent_env('EVENTBRITE_ORG_ID',  "");

                return redirect()->route('eventbrite-setup');
            } else {

                $orgInfo = (new Org)->getOrganization();
                if ($orgInfo['id'] == null) {

                    Session::flash("error_msg", "Organization details is not found, please setup your Organization");
                    $orgInfo = (new Org)->getAllOrganization()['organizations'];
                    return view('setup.org', ['orgInfo' => $orgInfo]);
                } else {

                    return redirect()->route('eventbrite-setup');
                }
            }
        } else if ($EVENTBRITE_ACCESS_TOKEN == "" && $EVENTBRITE_ORG_ID == "") {

            return redirect()->route('eventbrite-setup');
        } else if ($EVENTBRITE_ACCESS_TOKEN == "" && $EVENTBRITE_ORG_ID != "") {

            put_permanent_env('EVENTBRITE_ORG_ID',  "");
            return redirect()->route('eventbrite-setup');
        } else if ($EVENTBRITE_ACCESS_TOKEN != "" && $EVENTBRITE_ORG_ID == "") {

            if ($this->getUserDetails()['id'] == null) {

                return redirect()->route('eventbrite-setup');
            } else {

                if (!Session::has("setup_status")) {
                    Session::flash("error_msg", "Please choose an Organization");
                }

                $orgInfo = (new Org)->getAllOrganization()['organizations'];
                return view('setup.org', ['orgInfo' => $orgInfo]);
            }
        }
    }

    public function save_credentials(Request $request)
    {
        $request->validate([
            'api_key' => 'required',
            'api_client_secret' => 'required'
        ]);

        put_permanent_env('EVENTBRITE_API_KEY', $request->api_key);
        put_permanent_env('EVENTBRITE_API_CLIENT_SECRET', $request->api_client_secret);

        return redirect()->away(env('EVENTBRITE_AUTH_URL') . "/oauth/authorize?response_type=code&client_id=" . env('EVENTBRITE_API_KEY') . "&redirect_uri=" . url('/oauth/eventbrite/redirect'));
    }

    public function save_organization(Request $request)
    {
        $request->validate([
            'organization' => 'required'
        ]);

        put_permanent_env('EVENTBRITE_ORG_ID', $request->organization);

        Session::flash("setup_status", "SUCCESS");
        return redirect()->route('eventbrite-setup');
    }
}
