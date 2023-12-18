@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ __('You are logged in!') }}
                        @if(Auth::user()->getRoles->where('key',env('ADMIN'))->first() != null)
                        <h5>Here is your place to try SQL injections :)</h5>
                        <form method="POST" action="{{route('search')}}">
                            @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="items_to_be_searched" name="search" placeholder="Search ...">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit" onclick="search()">Search Here</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                        <ul>
                            @if(session('results'))
                                @foreach(session('results') as $result)
                                    <li>{{ is_object($result) ? $result->email : $result }}</li>
                                @endforeach
                            @endif
                        </ul>
                    <p>-------------------------------------------------------</p>
                        <h5>The concept of Unescaped data are presented here</h5>
                        <p>Here, the address is added with the text editor, as we know, text editors are usally displayed in other way than usual</p>
{{--                     {{$text}}--}}
{{--                    {!! $text !!}--}}
                        @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('customjs')
    <!-- Add this script tag to your HTML file -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


@endsection
