<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'verify.api.credentials'], function () {

    Route::get('events', 'Front\EventsController@view_eventsList');
    Route::get('event/{id}', 'Front\EventsController@view_eventDetails');
    Route::get('events/retrieveAll', 'Front\EventsController@axios_retrieveAll');

    Route::get('about', function () {
        return view('errors.coming-soon-2', ['page_title' => "Coming Soon"]);
    });
    Route::get('sponsor', function () {
        return view('errors.coming-soon-2', ['page_title' => "Coming Soon"]);
    });
    Route::get('terms', function () {
        return view('errors.coming-soon-2', ['page_title' => "Coming Soon"]);
    });
    Route::get('privacy-policy', function () {
        return view('errors.coming-soon-2', ['page_title' => "Coming Soon"]);
    });
});





Route::get('oauth/eventbrite/redirect', 'OAuth\EventbriteAuthController@redirect');
Route::get('oauth/eventbrite/setup', 'OAuth\EventbriteAuthController@view_setup')->name('eventbrite-setup');
Route::get('oauth/eventbrite/setup-organization', 'OAuth\EventbriteAuthController@view_setupOrg')->name('eventbrite-setup-org');

Route::post('oauth/eventbrite/setup/save_credentials', 'OAuth\EventbriteAuthController@save_credentials');
Route::post('oauth/eventbrite/setup/save_organization', 'OAuth\EventbriteAuthController@save_organization');


Route::get('coming-soon', function () {
    return view('errors.coming-soon', ['page_title' => "Coming Soon"]);
})->name('coming-soon');
