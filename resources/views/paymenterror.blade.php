<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  <meta http-equiv="X-UA-Compatible" content="IE=edge">


  <!-- CSRF Token -->
  <!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->

  <!-- <title>Super Admin || {{ config('app.name', 'Laravel') }}</title> -->
  <title>Error</title>
  <?php
    // $base_url = url();
  $currentPath = $_SERVER['PHP_SELF']; 
  
  // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index ) 
  $pathInfo = pathinfo($currentPath); 
  
  // output: localhost
  $hostName = $_SERVER['HTTP_HOST']; 
  
  // output: http://
  $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
  
  // return: http://localhost/myproject/
  $base_url = $protocol.$hostName.$pathInfo['dirname']."/";
  // echo "http://".$_SERVER['SERVER_NAME'].dirname($_SERVER["REQUEST_URI"].'?').'/';
  ?>
  
  {{-- <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
   --}}
   <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
   <link rel="icon" href="{{ asset('admin-asset/images//favicon.ico') }}" type="image/x-icon">
   <link rel="stylesheet" href="<?=$base_url?>admin-asset/css/custom.css">
   <link rel="stylesheet" href="<?=$base_url?>admin-asset/css/simple-line-icons.css">
   <link rel="stylesheet" href="<?=$base_url?>admin-asset/bower_components/bootstrap/dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="<?=$base_url?>admin-asset/bower_components/font-awesome/css/font-awesome.min.css">
   <link rel="stylesheet" href="<?=$base_url?>admin-asset/bower_components/Ionicons/css/ionicons.min.css">
   <link rel="stylesheet" href="<?=$base_url?>admin-asset/bower_components/select2/dist/css/select2.min.css" />
   <link rel="stylesheet" href="<?=$base_url?>admin-asset/dist/css/AdminLTE.min.css">
   <link rel="stylesheet" href="<?=$base_url?>admin-asset/dist/css/skins/_all-skins.min.css">
   <link rel="stylesheet" href="<?=$base_url?>admin-asset/bower_components/morris.js/morris.css">
   <link rel="stylesheet" href="<?=$base_url?>admin-asset/bower_components/jvectormap/jquery-jvectormap.css">
   <link rel="stylesheet" href="<?=$base_url?>admin-asset/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
   <link rel="stylesheet" href="<?=$base_url?>admin-asset/bower_components/bootstrap-daterangepicker/daterangepicker.css">
   <link rel="stylesheet" href="<?=$base_url?>admin-asset/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;background-color:#fff;color:#000;display:flex;justify-content:center;align-items:center;min-height:100vh;padding:20px;flex-direction:column;}
        .container{text-align:center;width:100%;max-width:700px;}
        .logo{color:#0000ee;text-decoration:underline;display:block;margin-bottom:45px;font-size:16px;}
        .card{background-color:#f3f3f3;padding:80px 40px;box-shadow:0 10px 15px rgba(0,0,0,0.15);border-radius:2px;}
        .icon{font-size:50px;color:green;margin-bottom:20px;}
        .thank-you-page-content h1{position: relative; width: 100%; float: left; margin-bottom: 45px; padding-top: 30px; font-size: 30px; font-weight: 200; line-height: 40px;}
        /* .thank-you-page-content h1::before { content: "\f00c"; top: 0; transform: translateX(-50%); -webkit-transform: translateX(-50%); -ms-transform: translateX(-50%); left: 50%; position: absolute; font-family: "FontAwesome"; font-size:60px; text-align: center; float: left; width: 100px; color: green; height: 100px; text-align: center; line-height: 100px; border: 2px solid green;  border-radius:100%;  -webkit-border-radius:100%; -ms-border-radius:100%;} */
        h2{font-size:22px;margin-bottom:25px;line-height:1.5;}
        .btn{display:inline-block;background-color:#00587a;color:white;text-decoration:none;padding:10px 20px;border-radius:5px;font-weight:500;transition:background-color 0.3s ease;font-size:15px;}
        .btn:hover{background-color:#00405b;}
        footer{margin-top:30px;font-size:15px;color:#335;}
        footer a{color:#00587a;text-decoration:none;margin:0 5px;}
        footer a:hover{text-decoration:underline;}
        footer .copyright{margin-top:8px;color:#666;}
        @media (max-width:500px){
          .card{padding:25px 20px;}
          h2{font-size:18px;}
          .btn{padding:8px 16px;font-size:14px;}
          .icon{font-size:40px;}
          footer{font-size:13px;}
        }
  </style>
</head>
<body>
  <div class="container">
    <div class="card thank-you-page-content">
      <a href="#" class="logo"><img src="{{ asset('images/header-logo.svg') }}" alt="#"> </a>
      <!-- <div class="icon">&#10003;</div> -->
      <h1>Oops, your payment is failed.</h1>
      {{-- <a  class="btn">Go back to App</a> --}}
    </div>
    <footer>
     
      <div class="copyright">
        <strong>Copyright &copy; <?php echo date('Y');?> <a href="">{{ config('app.name', 'Laravel') }}</a>.</strong> All rights reserved.

      </div>
    </footer>
  </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- jQuery 3 -->
    <script src="{{ asset('admin-asset/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('admin-asset/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('admin-asset/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin-asset/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    
    <script src="{{ asset('admin-asset/js/jquery.form.js') }}"></script>
    <script src="{{ asset('admin-asset/sweetalert2-master/dist/sweetalert-dev.js') }}"></script>
    <link href="{{ asset('admin-asset/sweetalert2-master/dist/sweetalert.css') }}" rel="stylesheet">
    
    <script src="{{ asset('admin-asset/js/loadingnew.js') }}"></script>
    <link href="{{ asset('admin-asset/css/loading-ajax.css') }}" rel="stylesheet">
    <!-- daterangepicker -->
    <script src="{{ asset('admin-asset/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('admin-asset/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- datepicker -->
    <script src="{{ asset('admin-asset/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset('admin-asset/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <!-- Slimscroll -->
    <script src="{{ asset('admin-asset/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('admin-asset/bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin-asset/dist/js/adminlte.min.js') }}"></script>
    <link href="{{ asset('admin-asset/lib/videojs-resolution-switcher.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-asset/lib/video-js.min.css') }}" rel="stylesheet" type="text/css" />
    
    <script type="text/javascript" src="{{ asset('admin-asset/lib/video.js') }}"></script>
    <script type="text/javascript">
        videojs.options.flash.swf = "{{ asset('admin-asset/lib/video-js.swf') }}"
    </script>
    <script src="{{ asset('admin-asset/lib/videojs-resolution-switcher.js') }}" type="text/javascript"></script>
    
    <link rel="stylesheet" href="{{ asset('admin-asset/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <script src="{{ asset('admin-asset/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin-asset/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    
    <link rel="stylesheet" href="{{ asset('admin-asset/fancybox-master/dist/jquery.fancybox.css') }}">
    <script src="{{ asset('admin-asset/fancybox-master/dist/jquery.fancybox.js') }}"></script>
    <script src="{{ asset('admin-asset/js/bootbox.min.js') }}"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('admin-asset/dist/js/demo.js') }}"></script>
</body>
</html>
