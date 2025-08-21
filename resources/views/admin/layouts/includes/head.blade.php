<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="bootstrap material admin template">
  <meta name="author" content="">
  {{-- <title>{{Config::get('constant.APP_NAME')}} - Admin</title> --}}
  <meta name='robots' content='noindex, nofollow' />
  <link rel="shortcut icon" href="{{URL(Config::get('constant.LOGO_FAVICON'))}}" />
  {{-- <title>{{ config('app.name') }} - Admin</title> --}}
  <title>{{Config::get('constant.APP_NAME')}} - Admin</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/jquery-clockpicker.css">
  <!-- Stylesheets -->
  <link rel="stylesheet" href="{{ asset('themes/admin/assets/global/css/bootstrap.minfd53.css') }}">
  <link rel="stylesheet" href="{{ asset('themes/admin/assets/global/css/bootstrap-extend.minfd53.css') }}">
  <link rel="stylesheet" href="{{ asset('themes/admin/assets/css/site.minfd53.css') }}">

  <!-- Plugins -->
  <link rel="stylesheet" href="{{ asset('themes/admin/assets/global/vendor/animsition/animsition.minfd53.css') }}">
  <link rel="stylesheet" href="{{ asset('themes/admin/assets/global/vendor/asscrollable/asScrollable.minfd53.css') }}">
  <link rel="stylesheet" href="{{ asset('themes/admin/assets/global/vendor/switchery/switchery.minfd53.css') }}">
  <link rel="stylesheet" href="{{ asset('themes/admin/assets/global/vendor/intro-js/introjs.minfd53.css') }}">
  <link rel="stylesheet" href="{{ asset('themes/admin/assets/global/vendor/flag-icon-css/flag-icon.minfd53.css') }}">
  <link rel="stylesheet" href="{{ asset('themes/admin/assets/global/vendor/waves/waves.minfd53.css') }}">
  <link rel="stylesheet" href="{{ asset('themes/admin/assets/global/vendor/toastr/toastr.minfd53.css') }}">

  <link rel="stylesheet" href="{{ asset('themes/admin/assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.minfd53.css?v4.0.1') }}">

  <!-- Page -->
  <link rel="stylesheet" href="{{ asset('themes/admin/assets/examples/css/dashboard/v1.minfd53.css') }}">

  <link rel="stylesheet" href="{{ asset('themes/admin/assets/global/vendor/datatables.net-bs4/dataTables.bootstrap4.minfd53.css?v4.0.1') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css" />

  <link rel="stylesheet" href="{{asset('themes/admin/assets/css/croppie.css')}}">
  <!-- Fonts -->
  <link rel="stylesheet" href="{{ asset('themes/admin/assets/global/fonts/material-design/material-design.minfd53.css') }}">
  <link rel="stylesheet" href="{{ asset('themes/admin/assets/global/fonts/brand-icons/brand-icons.minfd53.css') }}">
  <link rel='stylesheet' href="https://fonts.googleapis.com/css?family=Roboto:400,400italic,700">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('themes/admin/assets/css/custom.css') }}">

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('themes/admin/assets/global/vendor/breakpoints/breakpoints.minfd53.js') }}"></script>



  {{-- <link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css' rel='stylesheet'> --}}

 

  <script>
    Breakpoints();
  </script>
</head>
