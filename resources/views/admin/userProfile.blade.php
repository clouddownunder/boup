@extends('admin.layouts.main')

@section('header_css')

  <link rel="stylesheet" href="{{ asset('themes/admin/assets/examples/css/pages/profile.minfd53.css') }}">

@endsection

@section('content')
<div class="page-profile">
<!-- Page -->
  <div class="page">
    <div class="page-content container-fluid">
      <div class="row">
        <div class="col-lg-3">
          <!-- Page Widget -->
          <div class="card card-shadow text-center">
            <div class="card-block">
              <a class="avatar avatar-lg" href="javascript:void(0)">
                <img style="cursor: default;" src="{{!empty(Auth::guard('admin')->user()->profile_pics) ? url('admin_bkp/profile_pics/'.Auth::guard('admin')->user()->profile_pics) : asset('images/default_image.png') }}" alt="{{Auth::guard('admin')->user()->name}}">
              </a>
              <h4 class="profile-user">{{Auth::guard('admin')->user()->name}}</h4>
              <p class="profile-job"><i class="icon md-email" aria-hidden="true"></i> {{Auth::guard('admin')->user()->email}}</p>
              {{-- <p class="profile-job"><i class="icon md-phone" aria-hidden="true"></i> {{Auth::guard('admin')->user()->mobile}}</p> --}}

            </div>

          </div>
          <!-- End Page Widget -->
        </div>

        <div class="col-lg-9">
          <!-- Panel -->
          <div class="panel">
            <div class="panel-body nav-tabs-animate nav-tabs-horizontal" data-plugin="tabs">
              <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                <li class="nav-item" role="presentation"><a class="active nav-link" data-toggle="tab" href="#profile" aria-controls="profile"
                    role="tab">Profile Info</a></li>
              </ul>

              <div class="tab-content">

                <div class="tab-pane active animation-slide-left" id="profile" role="tabpanel">
                  <ul class="list-group">
                    <li class="list-group-item">
                      <div class="row row-lg">
			            <div class="col-md-6">
			              <!-- Example Basic Form (Form grid) -->
			              <div class="example-wrap">
			                <h4 class="example-title">Update Profile Details</h4>
			                <div class="example">
			                 
                        <form method="POST" action="{{ route('user-profile.update', $user->id) }}" enctype="multipart/form-data" id="userProfileForm">
                          @method('PUT') 
                          @csrf 
			                    <div class="row">
			                      <div class="form-group form-material col-md-12 @error('name') has-danger @enderror">
			                        <label class="form-control-label" for="inputBasicFirstName">Name <span class="text-danger">*</span></label>
			                        <input type="text" class="form-control" placeholder="Name" value="{{ucfirst(Auth::guard('admin')->user()->name)}}" name="name" autocomplete="off" required />
			                        @error('name')
						                <label class="form-control-label" for="name">{{ $message }}</label>
					              	@enderror
			                      </div>
			                      {{-- <div class="form-group form-material col-md-12 ">
			                        <label class="form-control-label" for="inputBasicLastName">Mobile Number <span class="text-danger">*</span></label>
			                        <input type="text" class="form-control" value="{{ucfirst(Auth::guard('admin')->user()->mobile)}}" required name="mobile" placeholder="Mobile Number" autocomplete="off" />
			                        @error('mobile')
						                <label class="form-control-label" for="name">{{ $message }}</label>
					              	@enderror
			                      </div> --}}
			                        <!-- <div class="form-group form-material col-md-12" data-plugin="">
					                  <label class="form-control-label" for="inputFile">Profile Pic</label>
					                  <input type="text" class="form-control custom-file-label" placeholder="Browse.." readonly="" />
					                  <input type="file" accept="image/png, image/jpeg, image/jpg, image/gif" id="inputFile" name="profile_pics" />
					                </div> -->

					                 <div class="form-group form-material col-md-12" data-plugin="">
						                <label class="form-control-label" for="inputGroupFile01">Profile Pic</label>
						                <input type="text" class="form-control custom-file-label" placeholder="Browse.." readonly="" />

						                <input type="file" accept="image/png, image/jpeg, image/jpg, image/gif" id="inputGroupFile01" name="profile_pics" />
						                <span id="brTagAdd"></span>
						                <div id='img_contain' class="col-lg-12 col-md-12 col-sm-12">

						                  <img style="display: none;" id="profile-pics-preview" align='middle'   width="100px" />
						                </div>
						                <input type="hidden" name="user_profile_pic" id="imagebase64">
						            </div>
			                    </div>

			                    <div class="form-group form-material">
			                      <button type="submit" class="btn btn-primary">Update</button>
			                    </div>
                        </form>
			                  
			                </div>
			              </div>
			              <!-- End Example Basic Form -->
			            </div>
			            <div class="col-md-6">
			              <!-- Example Basic Form (Form grid) -->
			              <div class="example-wrap">
			                <h4 class="example-title">Change Password</h4>
			                <div class="example">
			                  <form class="" method="POST" action="{{ route('changePassword',$user->id) }}" id="changePassword">
                      			{{ csrf_field() }}
			                    <div class="row">
			                      <div class="form-group form-material col-md-12 @error('current_password') has-danger @enderror">
			                        <label class="form-control-label" for="inputBasicFirstName">Current Password <span class="text-danger">*</span></label>
			                        <input type="password" class="form-control" placeholder="Current Password" name="current_password" required autocomplete="off" />
                              {{-- <span class="password-toggle-icon field-icon" ><i class="fas fa-eye password-show"></i></span> --}}
			                        @error('current_password')
						                <label class="form-control-label" for="name">{{ $message }}</label>
					              	@enderror
			                      </div>
			                      <div class="form-group form-material col-md-12 @error('new_password') has-danger @enderror">
			                        <label class="form-control-label" for="inputBasicLastName">New Password <span class="text-danger">*</span></label>
			                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password" required autocomplete="off" />
			                        @error('new_password')
						                <label class="form-control-label" for="name">{{ $message }}</label>
					              	@enderror
			                      </div>
			                      <div class="form-group form-material col-md-12 @error('new_password_confirmation') has-danger @enderror">
			                        <label class="form-control-label" for="inputBasicLastName">Confirm New Password <span class="text-danger">*</span></label>
			                        <input type="password" class="form-control" name="new_password_confirmation" id="new_password_confirmation" required placeholder="Confirm New Password" autocomplete="off" />
			                        @error('new_password_confirmation')
						                <label class="form-control-label" for="name">{{ $message }}</label>
					              	@enderror
			                      </div>
			                    </div>

			                    <div class="form-group form-material">
			                      <button type="submit" class="btn btn-primary">Change Password</button>
			                    </div>
			                  </form>
			                </div>
			              </div>
			              <!-- End Example Basic Form -->
			            </div>
			        </div>
                    </li>
                  </ul>
                </div>

              </div>
            </div>
          </div>
          <!-- End Panel -->
        </div>
      </div>
    </div>
  </div>
  <!-- End Page -->
</div>
@stop

@section('footer_script')
<script type="text/javascript">
	$('#inputFile').on('change',function(e){
        if($(this).val() != ""){
	        var fileName = e.target.files[0].name;
	        $('.custom-file-label').val(fileName);
        }
        else{
        	$('.custom-file-label').val("");
        }
    })
</script>

 <script type="text/javascript">


        if(!$('#image_demo').data('croppie')){
          $image_crop = $('#image_demo').croppie({
            enableExif: true,
            viewport: {
              width:350,
              height:350,

            },
            boundary:{
              width:600,
              height:400
            }
          });
        }
        else{
          $('#image_demo').data('croppie').destroy();
          $image_crop = $('#image_demo').croppie({
            enableExif: true,
            viewport: {
              width:350,
              height:350,
            },
            boundary:{
              width:600,
              height:400
            }
          });
        }

        $(document).on('change','#inputGroupFile01',function() {
          var name = $(this).attr('name');
          var noImage = "{{asset('admin-theme/assets/images/default-img.png')}}";
          var ext = $(this).val().split('.').pop().toLowerCase();
          if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
              alert("Please select only image");
              return false;
          }
          else{
  var reader = new FileReader();
              reader.onload = function (event) {
                $image_crop.croppie('bind', {
                  url: event.target.result
                }).then(function(){
                  // console.log('jQuery bind complete');
                });
              }
              reader.readAsDataURL(this.files[0]);
              $(".crop_image").attr('id',name);
              $('#insertimageModal').modal('show');

          }

        });

        $('.crop_image').click(function(event){

            var className = $(this).attr('id');
          $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
          }).then(function(response){
          	$("#brTagAdd").after("<br/>");
            $("#profile-pics-preview").css("display","block");
            $("#profile-pics-preview").attr("src",response);
            $("#imagebase64").val(response);

            $('#insertimageModal').modal('hide');
            $("#feed_image_error").html("");
          });
        });

        $('.deletemodel').click(function(event){
          $('#modalConfirmDelete').modal('hide');
          });

  </script>
  @stop
