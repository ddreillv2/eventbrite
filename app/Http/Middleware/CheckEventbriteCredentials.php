<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

//Controllers 

use App\Http\Controllers\OAuth\EventbriteAuthController as OAuth;
use App\Http\Controllers\Core\OrganizationController as Org;

class CheckEventbriteCredentials
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $orgInfo = (new Org)->getOrganization();
        if ($orgInfo['id'] == null) {

            return redirect()->route('coming-soon');
        } else {

            $orgDetails = (new Org)->getOrganization();
            View::share('page_logo', $orgDetails['logo']['url']);
            View::share('page_title', $orgDetails['name']);

            return $next($request);
        }
    }
}
