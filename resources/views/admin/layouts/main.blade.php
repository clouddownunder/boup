<!doctype html>
<html>
<head>
    @include('admin.layouts.includes.head')
    @yield('header_css')
    <meta name='robots' content='noindex, nofollow' />
</head>

<body id="" class="">
    {{-- <div class="preloader" style="display: none; "></div> --}}
    
	    @include('admin.layouts.includes.sidebar')
	    @include('admin.layouts.includes.header')

	    @yield('content')

	    @include('admin.layouts.includes.footer')
	    
    @yield('footer_script')

</body>
</html>