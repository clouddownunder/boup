<!DOCTYPE html>
<html>
<head>

      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta name="author" content="">

     <link rel="icon" type="image/x-icon" href="{{asset('images/favicon.png')}}">

      <title>{{ config('app.name') }}</title>

      <style type="text/css">
            body{background:#ffffff;font-family:sans-serif;font-weight:normal;font-size:16px;line-height:normal;color:#000;text-transform:none;margin:0px;padding:0px;}
            html { margin:0; padding:0;  }

            .container{max-width:1440px;width:95%;margin:0px auto;padding-left:15px;padding-right:15px;box-sizing: border-box;}


            .page-content{padding:50px 0px;}
            .page-content p{margin-bottom:1rem;line-height:1.5;}
            .header-main{display:flex;align-items:center;padding:20px 0px;}
            .header-main .header-logo{width:140px;}
            .header-main .header-logo img{max-width:100%;}
            .header-main h1{width:calc(100% - 140px);padding-right:160px;text-align:center;padding-left:20px;font-size:26px;margin:0px;box-sizing:border-box;}
            .header-top{background:#fff;position:sticky;top:0px;box-shadow:0px 4px 18px rgba(0,0,0,0.10);}
            .page-wrapper{height:100%;}

            @media (max-width: 991px) {

                .header-main .header-logo{width:100px;}
                .header-main h1{width:calc(100% - 100px);padding-right:0px;font-size:22px;}
                .page-content{padding: 30px 0px;}

            }

            @media (max-width: 767px) {
                .header-main h1{text-align:right;font-size:18px;max-width:230px;width:calc(100% - 120px);padding-left:0px;}
                .header-main{padding:15px 0px;justify-content:space-between;gap:15px;}
            }

      </style>

</head>

<body>

   <div class="page-wrapper">
       <div class="header-top">
            <div class="container">
                <div class="header-main">
                   <div class="header-logo">
                        <img src="{{ asset('assets/images/logo.svg')}}" alt="Boup">
                   </div>
                   <h1>Privacy policy</h1>
                </div>
           </div>
       </div>

       <div class="page-content">
        <div class="container">
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                </div>
        </div>
        <div class="page-content">
            <div class="container">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
            </div>
            </div>
            <div class="page-content">
                <div class="container">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                </div>
            </div>
            <div class="page-content">
                <div class="container">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                </div>
        </div>
   </div>
</body>

</html>

