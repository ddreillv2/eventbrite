@extends('layouts.app')

@section('content')
<div class="iq-comingsoon pt-5">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-sm-6 text-center">
                <div class="iq-comingsoon-info">
                    <h2 class="mt-4 mb-1">Setup Page</h2>
                    <p class="mb-2">Choose an Organization that you want to manage</p>

                    <div class="card mt-5 text-left">
                        <div class="card-body">

                            <form action="{{url('/oauth/eventbrite/setup/save_organization')}}" method="post">
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

                                <div class="form-group mt-3 mb-5">
                                    <select class="form-select form-control" id="organization" name="organization">
                                        <option value="" selected>Choose an Organization</option>
                                        @foreach ($orgInfo as $org)
                                            <option value="{{$org['id']}}">{{$org['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Save Organization</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection