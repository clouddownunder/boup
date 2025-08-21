@extends('admin.layouts.main')
@section('header_css')
<link rel="stylesheet" href="{{ asset('/vendor/translation/css/main.css') }}">
@endsection
@section('content')
<div class="page">
<div id="app">


        @include('translation::notifications')

        @yield('body')

    </div>
</div>

    @endsection
    @section('footer_script')
    <script>
        $("document").ready(function() {
            $("#toggleMenubar").trigger('click');
        });
    </script>
    <script src="{{ asset('/vendor/translation/js/app.js') }}"></script>
    @endsection


