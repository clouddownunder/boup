<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>404 - Page Not Found</title>
  <style>
    *{margin:0;padding:0;box-sizing:border-box;}
    body,html{width:100%;font-family:sans-serif;background:linear-gradient(to bottom,#0a013d,#FF5221);display:flex;justify-content:center;align-items:center;min-height:100vh;padding:0px;flex-direction:column;position:relative;}
    .container_404{color:#fff;padding:40px 20px;z-index:2;position:relative;text-align:center;}
    .error-image{width:100%;max-width:700px;margin:0 auto;animation:pulse 2s ease-in-out infinite;}
    @keyframes pulse{
      0%,100%{transform:scale(1);filter:drop-shadow(0 0 10px #00eaff);}
      50%{transform:scale(1.02);filter:drop-shadow(0 0 20px #8f00ff);}
    }
    .error-text{font-size:30px;margin-top:40px;color:#ffffff;}
    .home-btn{display:inline-block;margin-top:30px;padding:15px 30px;background-color:#29bdfc;color:#fff;border-radius:8px;text-decoration:none;font-weight:bold;font-size:16px;box-shadow:0 4px 20px rgba(0,200,255,0.4);transition:background-color 0.3s,transform 0.3s;}
    .home-btn:hover{background-color:#1a91cc;}
    .bg-grid{position:absolute;top:0;left:0;width:100%;height:100%;background-image:linear-gradient(#ffffff10 1px,transparent 1px),linear-gradient(to right,#ffffff10 1px,transparent 1px);background-size:40px 40px;z-index:0;}
  </style>
</head>
<body>
  <div class="page_404_main">
    <div class="bg-grid"></div>
    <div class="container_404">
      <img src="{{ asset('images/page-404-image.png')}}" alt="404 Page Not Found" class="error-image" />
      <p class="error-text">Oops, Password link has been expired, Please try again to forgot password.</p>
      {{-- <a href="#" class="home-btn">Go back to homepage</a> --}}
    </div>
  </div>  
</body>
</html>


