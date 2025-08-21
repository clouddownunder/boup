<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name='robots' content='noindex, nofollow' />
  <title>{{Config::get('constant.APP_NAME')}} - Admin</title>

  <link rel="shortcut icon" href="{{URL(Config::get('constant.LOGO_FAVICON'))}}" />

  <!-- Stylesheets -->

  <link rel="stylesheet" href="{{ asset('themes/admin/assets/global/css/bootstrap.minfd53.css') }}">
<link rel="stylesheet" href="{{ asset('themes/admin/assets/global/css/bootstrap-extend.minfd53.css') }}">
<link rel="stylesheet" href="{{ asset('themes/admin/assets/css/site.minfd53.css') }}">
<link rel="stylesheet" href="{{ asset('themes/admin/assets/examples/css/pages/login-v2.minfd53.css') }}">
<link rel="stylesheet" href="{{ asset('themes/admin/assets/global/fonts/material-design/material-design.minfd53.css') }}">
<link rel="stylesheet" href="{{ asset('themes/admin/assets/global/fonts/brand-icons/brand-icons.minfd53.css') }}">
<link rel="stylesheet" href="{{ asset('themes/admin/assets/global/vendor/formvalidation/formValidation.minfd53.css') }}">
  <link rel='stylesheet' href="https://fonts.googleapis.com/css?family=Roboto:400,400italic,700">
  <link rel="stylesheet" href="{{ asset('themes/admin/assets/css/custom.css') }}">

<!--   <link rel="stylesheet" href="../../global/vendor/animsition/animsition.minfd53.css?v4.0.1">
  <link rel="stylesheet" href="../../global/vendor/asscrollable/asScrollable.minfd53.css?v4.0.1">
  <link rel="stylesheet" href="../../global/vendor/switchery/switchery.minfd53.css?v4.0.1">
  <link rel="stylesheet" href="../../global/vendor/intro-js/introjs.minfd53.css?v4.0.1">
  <link rel="stylesheet" href="../../global/vendor/slidepanel/slidePanel.minfd53.css?v4.0.1">
  <link rel="stylesheet" href="../../global/vendor/flag-icon-css/flag-icon.minfd53.css?v4.0.1">
  <link rel="stylesheet" href="../../global/vendor/waves/waves.minfd53.css?v4.0.1"> -->
<style type="text/css">
.page-login-v2 .page-login-main form a {
    font-size: 15px;
    line-height: 18px;
    font-weight: 500;
    color: #989898;
}
.pass-toggle {
    position: relative;
  }

  .toggle-password {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 18px;
    color:#FF5221;
}


.page-login-v2 .page-login-main form a:hover {
    color: #FF5221;
    ;
}
  .form-material.has-warning .form-control-label, .form-control-feedback, .error {
      color: #f44336;
  }
  .form-control-feedback{
    margin-left: 15px;
  }
  @media only screen and (min-width: 768px) {
    .page-login-v2 .page-login-main{
      height: 100vh;
    }
  }
</style>


  <script src="{{ asset('themes/admin/assets/global/vendor/html5shiv/html5shiv.min.js') }}"></script>
  <script src="{{ asset('themes/admin/assets/global/vendor/media-match/media.match.min.js') }}"></script>
  <script src="{{ asset('themes/admin/assets/global/vendor/respond/respond.min.js') }}"></script>

<script src="{{ asset('themes/admin/assets/global/vendor/breakpoints/breakpoints.minfd53.js') }}"></script>
  <script>
    Breakpoints();
  </script>
</head>
<body class="animsition page-login-v2 layout-full page-dark">
  <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->


  <!-- Page -->
  <div class="page" data-animsition-in="fade-in" data-animsition-out="fade-out">
    <div class="page-content text-center login-left-v2">
      <div class="page-brand-info">
        <div class="login-left-img">
          <img src="{{asset('images/Boup.png')}}" alt="#">
          {{-- <h2>DiverHub Login image</h2> --}}
        </div>
      </div>

      <div class="page-login-main form-horizontal">
        <div >
          <img class="brand-img" src="{{ asset('images/header-logo.svg') }}" alt="Logo" width="300px">
          {{-- <h2>DiverHub Logo</h2> --}}

        </div>
        <h3 class="font-size-24">Reset Password</h3>
        
        <form action="{{ route('userResetPassword') }}" method="post" id="adminresetpassword">
         @csrf    
         <input type="hidden" name="token" value="{{$token}}">
         
          <div class="form-group row form-material text-left">
            <?php 
              if(session('status'))
              {
              ?>
              <div class="col-xl-12 text-left alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            <?php } ?>
            @if ($errors->any())
              <div class="col-xl-12 text-left alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
            @endif
            <label class="col-xl-12 text-left form-control-label">Email
              <span class="required">*</span>
            </label>
            <div class=" col-xl-12">
              <input type="email" class="form-control empty @error('email') is-invalid @enderror" id="inputEmail" name="email" value="{{$email}} " autocomplete="off" required autofocus disabled>
              @error('email')
                <label id="email-error" class="error" for="email">{{ $message }}</label>
              @enderror
            </div>
          </div>

          <div class="form-group row form-material text-left">
            <label class="col-xl-12 text-left form-control-label">Password
              <span class="required">*</span>
            </label>
            <div class=" col-xl-12">
              <div class="pass-toggle">
                <input class="form-control password-field empty @error('password') is-invalid @enderror" type="password" id="password" value="{{ old('password') }}" name="password" autocomplete="off" minlength="6" required/>
                <i class="md-eye toggle-password"></i>
                @error('password')
                  <label id="password-error" class="error" for="email">{{ $message }}</label>
                @enderror
              </div>
            </div>
          </div>

          <div class="form-group row form-material text-left">
            <label class="col-xl-12 text-left form-control-label">Confirm Password
              <span class="required">*</span>
            </label>
            <div class=" col-xl-12">
              <div class="pass-toggle">
                <input class="form-control password-field empty @error('password_confirmation') is-invalid @enderror" type="password" value="{{ old('password_confirmation') }}" name="password_confirmation" autocomplete="off" required/>
                <i class="md-eye toggle-password"></i>
                @error('password_confirmation')
                  <label id="password_confirmation-error" class="error" for="password_confirmation">{{ $message }}</label>
                @enderror
              </div>
            </div>
          </div>


          <button type="submit" class="btn btn-primary btn-block rotate-color-combo" id="kt_sign_in_submit">Change Password</button>
        </form>

      </div>

    </div>
  </div>
  <!-- End Page -->


  <!-- Core  -->
<script src="{{ asset('themes/admin/assets/global/vendor/babel-external-helpers/babel-external-helpersfd53.js') }}"></script>
<script src="{{ asset('themes/admin/assets/global/vendor/jquery/jquery.minfd53.js') }}"></script>
<script src="{{ asset('themes/admin/assets/global/vendor/popper-js/umd/popper.minfd53.js') }}"></script>
<script src="{{ asset('themes/admin/assets/global/vendor/bootstrap/bootstrap.minfd53.js') }}"></script>
<script src="{{ asset('themes/admin/assets/global/vendor/animsition/animsition.minfd53.js') }}"></script>
<script src="{{ asset('themes/admin/assets/global/vendor/jquery-placeholder/jquery.placeholder.minfd53.js') }}"></script>
<script src="{{ asset('themes/admin/assets/global/vendor/formvalidation/formValidation.minfd53.js') }}"></script>
<script src="{{ asset('themes/admin/assets/global/vendor/formvalidation/framework/bootstrap4.minfd53.js') }}"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      const form = document.getElementById('adminresetpassword');
      $('#adminresetpassword')
        .formValidation({
          framework: 'bootstrap4',
          // icon: {
          //     valid: 'glyphicon glyphicon-ok',
          //     invalid: 'glyphicon glyphicon-remove',
          //     validating: 'glyphicon glyphicon-refresh'
          // },
          fields: {
            email: { 
              validators: { 
                notEmpty: { 
                  message: "Email address is required." 
                }, 
                emailAddress: { 
                  message: "Enter valid email." 
                }
              } 
            },
            password: { 
              validators: { 
                notEmpty: { 
                  message: "Password is required." 
                }
              } 
            },
            password_confirmation: { 
              validators: { 
                notEmpty: { 
                  message: "Confirm password is required." 
                },
                identical: {
                  field: 'password',
                  message: 'Password and confirm password does not match.'
                }
                /*identical: {
                  compare: function() {
                    return form.querySelector('[name="password"]').value;
                  },
                  message: 'Password and confirm password does not match.'
                },*/
              } 
            },
          }
        });
        
        $('.toggle-password').on('click', function() {
          const $icon = $(this);
          const $input = $icon.siblings('.password-field');
          const isPassword = $input.attr('type') === 'password';

          $input.attr('type', isPassword ? 'text' : 'password');
          $icon.toggleClass('md-eye md-eye-off');
        });
       
      });
    
    </script>
</body>

</html>