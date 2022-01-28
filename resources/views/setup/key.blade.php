@extends('layouts.app')

@section('content')
<div class="iq-comingsoon pt-5">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-sm-6 text-center">
                <div class="iq-comingsoon-info">

                    @if($type == "SETUP")
                    <h2 class="mt-4 mb-1">Setup Page</h2>

                    <p class="mb-2">Use your <a href="https://www.eventbrite.com/account-settings/apps" target="_blank">Eventbrite API Credentials</a> to setup this page</p>

                    <div class="card mt-5 text-left">
                        <div class="card-body">

                            <div class="alert bg-white alert-light mb-5" role="alert">
                                <div class="iq-alert-text">
                                    <h5 class="font-size-18 mb-2">Setup Instruction</h5>
                                    <ol>
                                        <li class="mb-2"> <span class="font-weight-500">Create an Eventbrite API Key</span>
                                            <ul>
                                                <li>Go to Account Settings > Developer Links > API Keys and</li>
                                                <li>click the "Create API Key button"</li>
                                            </ul>
                                        </li>
                                        <li class="mb-2">
                                            <p class="mb-2 font-weight-500">Under Application Details, copy ang paste the following details;</p>
                                            <p class="mb-1"><b>Application Url:</b> <br>{{url('')}}</p>
                                            <p class="mb-2"><b>OAuth Redirect URI:</b> <br>{{url('/oauth/eventbrite/redirect')}}</p>
                                        </li>
                                        <li>
                                            <span class="font-weight-500">Lastly, fill out the form below and click the "Save API Credentials button"</span>
                                        </li>
                                    </ol>
                                </div>
                            </div>

                            <form action="{{url('/oauth/eventbrite/setup/save_credentials')}}" method="post">
                                @csrf

                                @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <div class="iq-alert-text">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                @endif

                                @if(session()->has('error_msg'))
                                <div class="alert alert-danger" role="alert">
                                    <div class="iq-alert-text">
                                        {{session()->get('error_msg')}}
                                    </div>
                                </div>
                                @endif

                                <div class="form-group mb-7">
                                    <label for="api_key">API Key</label>
                                    <input type="text" class="form-control" id="api_key" name="api_key" value="{{ old('api_key') }}">
                                </div>
                                <div class="form-group mb-5">
                                    <label for="api_client_secret">Client secret</label>
                                    <input type="text" class="form-control" id="api_client_secret" name="api_client_secret" value="{{ old('api_client_secret') }}">
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Save API Credentials</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @elseif($type == "INFO")

                    <img src="{{$orgInfo['logo']['url']}}" class="rounded w-25 img-fluid rounded mb-5 mt-3" alt="Responsive image">
                    <h4 class="mb-2">{{$orgInfo['name']}}</h4>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection