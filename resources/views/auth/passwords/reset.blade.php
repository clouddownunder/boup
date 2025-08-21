<!DOCTYPE html>
<html>
<head>
  <meta name='robots' content='noindex, nofollow' />
    @include('parent.layouts.includes.head')
</head>
<script>
 document.title = "Boup - Student";
 </script>
<body>
  <!-- ====== /WRAPPER BOC ====== -->
  <div class="page-wrapper ">

    <div class="sign-main-wp">
        <div class="sign-page-content">
          <div class="login-row">
            <div class="login-left">
              <div class="brand-img">
                    <img src="{{asset('parent_assets/images/logo.png')}}" alt="login-img">
              </div>
              <div class="sign-img">
                    <img src="{{asset('parent_assets/images/Boup.png')}}" alt="login-img">
                </div>
            </div>
            <div class="login-right">
              <div class="page-login-main">
                  <div class="sign-form-wp">
                      <div class="sign-form-main">
                        <div class="sign-form-inner">
                          <div class="form-title">
                              <h1 class="title-main orange-text">Reset Password</h1>
                          </div>
                          <div class="form-main">
                            <form id="resetPassword" action="{{ route('password.update') }}" method="POST">
                                                @csrf
                          <div class="form-main-inner">
                            <div class="form-group">
                              <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-12 col-12">
                                  <label>Email</label>
                                </div>
                                <div class="col-lg-9 col-md-8 col-sm-12 col-12">
                                  <input type="hidden" name="token" value="{{$token}}"/>
                                  <input readonly type="text" class="form-control" placeholder="Enter Email" name="email" value="{{ $email ?? old('email') }}"/>
                                                                @if ($errors->has('email'))
                                                                <span class="text-danger">
                                                                    {{ $errors->first('email') }}
                                                                </span>
                                                                @endif
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-12 col-12">
                                  <label>New Password</label>
                                </div>
                                <div class="col-lg-9 col-md-8 col-sm-12 col-12">
                                  <input type="password" class="form-control" name="password" placeholder="Enter Password"/>
                                                                @if ($errors->has('password'))
                                                                <span class="text-danger">
                                                                    {{ $errors->first('password') }}
                                                                </span>
                                                                @endif
                                </div>
                              </div>
                            </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-4 col-sm-12 col-12">
                                                                <label>Confirm Password</label>
                                                            </div>
                                                            <div class="col-lg-9 col-md-8 col-sm-12 col-12">
                                                                <input  type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Enter Password" />
                                                              @if ($errors->has('password_confirmation'))
                                                                  <span class="text-danger">
                                                                      {{ $errors->first('password_confirmation') }}
                                                                  </span>
                                                              @endif
                                                            </div>
                                                        </div>
                                                    </div>
                            <div class="row">
                              <div class="col-lg-3 col-md-4 col-sm-12 col-12">
                              </div>
                              <div class="col-lg-9 col-md-8 col-sm-12 col-12">
                                <div class="form-btn">
                                  <button type="submit" class="btn w-100">Reset Password                                                                </button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </form>
                          </div>
                        </div>
                      </div>
                      <div class="login-bottom-text">
                        <div class="row">
                          <div class="col-lg-3 col-md-4 col-sm-12 col-12">
                      </div>
                     
                        </div>
                      </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</body>
</html>




