<div class="modal-dialog modal-dialog-slideout" role="document">
  <div class="modal-content">
    <div class="modal-header slidePanel-header bg-light-green-600">
      <div class="overlay-top overlay-panel overlay-background bg-light-green-600 rotate-color-combo">
        <div class="slidePanel-actions btn-group btn-group-flat" aria-label="actions" role="group">
          <!-- <button type="button" class="btn btn-pure icon md-edit subtask-toggle custom-nav-buttons" id="openEditForm" aria-hidden="true" data-target="#editForm" target-discard="#viewForm" title="Edit"></button> -->
          <button type="button" class="btn btn-pure icon md-delete subtask-toggle" style="color:white" aria-hidden="true" id="deleteDetails" title="Delete"></button>
          <button type="button" class="btn btn-pure slidePanel-close icon md-close" style="color:white" data-dismiss="modal" aria-hidden="true" title="Close"></button>
        </div>
        <h5 class="stage-name taskboard-stage-title">
          @if ($type == 1)
            Buyer Details
          @else
            Vendor Details
          @endif
        </h5>
      </div>
    </div>
    <div class="modal-body custom-nav-tabs">
      <div id="viewForm" class="active">
        <table class="table">
            @if ($type == 2)
              <tr>
                <td width="25%"><label class="text-bold">Logo</label></td>
                <td>
                  @if($user->business_logo)
                    <img width="100" class="img-fluid" src="{{asset('storage/business/logo/' . $user->business_logo)}}">
                  @else
                    <img width="100" class="img-fluid" src="{{asset('assets/images/businesslogo.png')}}">    
                  @endif
                </td>
              </tr>
              <tr>
                <td width="25%"><label class="text-bold">Email</label></td>
                <td>{{$user->email ?? 'N/A'}}</td>
              </tr>
              <tr>
                <td width="25%"><label class="text-bold">Name</label></td>
                <td>{{$user->business_name ?? 'N/A'}}</td>
              </tr>

              <tr>
                <td width="25%"><label class="text-bold">Profile Link</label></td>
                <td>{{$user->business_profile_link ?? 'N/A'}}</td>
              </tr>
              <tr>
                <td width="25%"><label class="text-bold">Setup Profile</label></td>
                <td>
                  @if ($user->is_setup_profile == 1)
                    Done
                  @else
                    Pending
                  @endif
                </td>
              </tr>
              <tr>
                <td width="25%"><label class="text-bold">Registered On</label></td>
                <td>@empty($user->created_at) N/A @else {{ fetchDateFormate($user->created_at) }} @endEmpty</td>
              </tr> 
              <tr>
                <td width="25%"><label class="text-bold">Status</label></td>
                @if ($user->status == 1)
                    <td><span class="badge badge-danger">Block</span></td> 
                @elseif ($user->status == 2)
                  <td><span class="badge badge-danger">Suspend</span></td> 
                @else
                  <td><span class="badge badge-success">Active</span></td> 
                @endif
              </tr> 
              @if ($user->status != 2)
                <tr>
                  <td width="25%"><label class="text-bold">Action</label></td>
                  <td>   
                    <form id="actionForm">
                        <input type="hidden" id="userId" value="{{ $user->id }}">
                        <input type="hidden" name="actionType" id="actionType">
                        @if ($user->status == 1)
                        <input type="hidden" id="reasonInput" class="reasonInput" placeholder="Please enter reason">
                          <a href="javascript:void(0)" class="btn btn-primary m-1" onclick="submitAction('unblock')">
                            <span>Unblock</span>
                          </a>
                        @else
                          

                          
                         
                          <a href="javascript:void(0)" class="btn btn-danger" id="blockDetail" >
                            
                            <span>Block</span>
                          </a>

                          <a href="javascript:void(0)" class="btn btn-danger" id="suspendDetail" >
                            <span>Suspend</span>
                          </a>
                        @endif
                    </form>
                  </td>
                </tr> 
              @else
                <tr>
                  <td width="25%"><label class="text-bold">Suspend end Date</label></td>
                  <td>@empty($user->suspend_end_date) N/A @else {{ fetchDateFormate($user->suspend_end_date) }} @endEmpty</td>
                </tr> 
                <tr>
                  <td width="25%"><label class="text-bold">Action</label></td>
                  <td>   
                    <form id="actionForm">
                        <input type="hidden" id="userId" value="{{ $user->id }}">
                        <input type="hidden" name="actionType" id="actionType">

                        @if ($user->status == 2)
                          <input type="hidden" id="reasonInput" class="reasonInput" placeholder="Please enter reason">
                            <a href="javascript:void(0)" class="btn btn-primary   m-1" onclick="submitAction('unsuspend')">
                              <span>Revoke</span>
                            </a>
                        @endif
                    </form>
                  </td>
                </tr> 
              
              @endif

              <tr class="deviceInfo">
                <td width="25%"><label class="text-bold">Device Type</label></td>
                @if($user->device_type == 0)
                <td>Web</td>
                @elseif($user->device_type == 1)
                <td>iOS</td>
                @elseif($user->device_type == 2)
                <td>Android</td>
                @endif

              </tr>
              {{-- <tr class="deviceInfo">
                <td width="25%"><label class="text-bold">App Version</label></td>
                <td>{{$user->app_version ?? 'N/A'}}</td>
              </tr>
              <tr class="deviceInfo">
                <td width="25%"><label class="text-bold">OS Version</label></td>
                <td>{{$user->os_version ?? 'N/A'}}</td>
              </tr>
              <tr class="deviceInfo">
                <td width="25%"><label class="text-bold">Device Name</label></td>
                <td>{{$user->device_name ?? 'N/A'}}</td>
              </tr> --}}
                <tr>
                  @if($show_device_info == "1")
                  <td colspan="2" class="text-right">
                    <a href="javascript:void(0)" role="button" id="deviceInfobtn">Device Info</a>
                  </td>
                </tr>
                @endif
            @else
              <tr>
                <td width="25%"><label class="text-bold">Profile Photo</label></td>
                <td>
                  @if($user->profile_pic)
                    <img width="100" class="img-fluid" src="{{asset('storage/profileImg/' . $user->profile_pic)}}">
                  @else
                    <img width="100" class="img-fluid" src="{{asset('images/default_image.png')}}">    
                  @endif
                </td>
              </tr>

              <tr>
                <td width="25%"><label class="text-bold">Email</label></td>
                <td>{{$user->email ?? 'N/A'}}</td>
              </tr>
              <tr>
                <td width="25%"><label class="text-bold">First Name</label></td>
                <td>{{$user->first_name ?? 'N/A'}}</td>
              </tr>
              <tr>
                <td width="25%"><label class="text-bold">Last Name</label></td>
                <td>{{$user->last_name ?? 'N/A'}}</td>
              </tr>
              <tr>
                <td width="25%"><label class="text-bold">Mobile</label></td>
                <td>+61 {{$user->mobile_no ?? 'N/A'}}</td>
              </tr>

              <tr>
                <td width="25%"><label class="text-bold">Gender</label></td>
                  <td>
                    @if($user->gender == 1)
                      Male
                    @elseif ($user->gender == 2)
                      Female
                    @else
                      N/A
                    @endif
                  </td>
              </tr>
              <tr>
                <td width="25%"><label class="text-bold">Suburb</label></td>
                <td>{{$user->suburb ?? 'N/A'}}</td>
              </tr>
              <tr>
                <td width="25%"><label class="text-bold">Interested State</label></td>
                <td>{{$user->interested_state ?? 'N/A'}}</td>
              </tr>

              <tr>
                <td width="25%"><label class="text-bold">Setup Profile</label></td>
                <td>
                  @if ($user->is_setup_profile == 1)
                    Done
                  @else
                    Pending
                  @endif
              </td>
              </tr>

              <tr>
                <td width="25%"><label class="text-bold">Registered On</label></td>
                <td>@empty($user->created_at) N/A @else {{ fetchDateFormate($user->created_at) }} @endEmpty</td>
              </tr> 
              <tr>
                <td width="25%"><label class="text-bold">Status</label></td>
                @if ($user->status == 1)
                    <td><span class="badge badge-danger">Block</span></td> 
                @elseif ($user->status == 2)
                  <td><span class="badge badge-danger">Suspend</span></td> 
                @else
                  <td><span class="badge badge-success">Active</span></td> 
                @endif
              </tr> 
              @if ($user->status != 2)
                <tr>
                  <td width="25%"><label class="text-bold">Action</label></td>
                  <td>   
                    <form id="actionForm">
                        <input type="hidden" id="userId" value="{{ $user->id }}">
                        <input type="hidden" name="actionType" id="actionType">
                        @if ($user->status == 1)
                        <input type="hidden" id="reasonInput" class="reasonInput" placeholder="Please enter reason">
                          <a href="javascript:void(0)" class="btn btn-primary m-1" onclick="submitAction('unblock')">
                            <span>Unblock</span>
                          </a>
                        @else
                          

                          <a href="javascript:void(0)" class="btn btn-danger" id="blockDetail" >
                            
                            <span>Block</span>
                          </a>
                          

                          
                          <a href="javascript:void(0)" class="btn btn-danger" id="suspendDetail" >
                            <span>Suspend</span>
                          </a>
                        @endif
                    </form>
                  </td>
                </tr> 
              @else
                <tr>
                  <td width="25%"><label class="text-bold">Suspend end Date</label></td>
                  <td>@empty($user->suspend_end_date) N/A @else {{ fetchDateFormate($user->suspend_end_date) }} @endEmpty</td>
                </tr> 
                <tr>
                  <td width="25%"><label class="text-bold">Action</label></td>
                  <td>   
                    <form id="actionForm">
                        <input type="hidden" id="userId" value="{{ $user->id }}">
                        <input type="hidden" name="actionType" id="actionType">

                        @if ($user->status == 2)
                          <input type="hidden" id="reasonInput" class="reasonInput" placeholder="Please enter reason">
                            <a href="javascript:void(0)" class="btn btn-primary   m-1" onclick="submitAction('unsuspend')">
                              <span>Revoke</span>
                            </a>
                        @endif
                    </form>
                  </td>
                </tr> 
              
              @endif

              <tr class="deviceInfo">
                <td width="25%"><label class="text-bold">Device Type</label></td>
                @if($user->device_type == 0)
                <td>Web</td>
                @elseif($user->device_type == 1)
                <td>iOS</td>
                @elseif($user->device_type == 2)
                <td>Android</td>
                @endif

              </tr>
              <tr class="deviceInfo">
                <td width="25%"><label class="text-bold">App Version</label></td>
                <td>{{$user->app_version ?? 'N/A'}}</td>
              </tr>
              <tr class="deviceInfo">
                <td width="25%"><label class="text-bold">OS Version</label></td>
                <td>{{$user->os_version ?? 'N/A'}}</td>
              </tr>
              <tr class="deviceInfo">
                <td width="25%"><label class="text-bold">Device Name</label></td>
                <td>{{$user->device_name ?? 'N/A'}}</td>
              </tr>
                <tr>
                  @if($show_device_info == "1")
                  <td colspan="2" class="text-right">
                    <a href="javascript:void(0)" role="button" id="deviceInfobtn">Device Info</a>
                  </td>
                </tr>
                @endif

            @endif
          </table>
      </div>
      {{-- <div id="editForm" class="hide">
        <!-- <div class="box-body">
            <div class="col-md-12">
              <div class="row">
                <div class="form-group form-material col-md-6 @error('name') has-danger @enderror">
                  <label class="form-control-label" for="inputBasicFirstName">First Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="First name" value="{{ucfirst($user->first_name)}}" name="name" autocomplete="off" required />
                    @error('name')
                    <label class="form-control-label" for="name">{{ $message }}</label>
                    @enderror
                </div>
              </div>
             </div>
              <br>
              <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-secondary custom-nav-buttons" target-discard="#editForm" data-target="#viewForm">Close</button>
              </div>
          </div> -->

      </div> --}}
    </div>
  </div>
</div>

<!-- /.delete Model-open -->
<div class="modal fade modal-fade-in-scale-up block-popup-main" id="modalConfirmDelete" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close deletemodel" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Boup</h4>
      </div>
      <div class="modal-body">
        <p class="delete-conform-p">Are you sure you want to delete this @if ($user->user_type == 1) buyer @elseif ($user->user_type == 2) vendor @else user @endif ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary deletemodel">Close</button>
        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
          @csrf
          @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- /.delete Model-close -->

<!-- Block user Model -->
<div class="modal fade modal-fade-in-scale-up block-popup-main" id="modalConfirmBlock" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close blockmodel" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Boup</h4>
      </div>
      <div class="modal-body">
        <p class="delete-conform-p">Are you sure you want to block this @if ($user->user_type == 1) buyer @elseif ($user->user_type == 2) vendor @else user @endif ?</p>

        <form id="actionForm">
          <div class="form-group mb-3">
            <label >Reason for block (optional):</label>
            <input type="hidden" id="userId" value="{{ $user->id }}">
            <input type="hidden" name="actionType" id="actionType">
              <input type="text" class="form-control" id="reasonInput" class="reasonInput" placeholder="Please enter reason">
              {{-- <a href="javascript:void(0)" class="btn btn-danger m-1" onclick="submitAction('suspend')">
                <span>Suspend</span>
              </a> --}}
          </div>
        </form>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary blockmodel">Close</button>
        <a href="javascript:void(0)" class="btn btn-danger  m-1" onclick="submitAction('block')">
          <span>Block</span>
        </a>
      </div>
    </div>
  </div>
</div>


<!-- Suspend user Model -->
<div class="modal fade modal-fade-in-scale-up block-popup-main" id="modalConfirmSuspend" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close suspendmodel" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Boup</h4>
      </div>
      <div class="modal-body">
        <p class="delete-conform-p">Are you sure you want to suspend this @if ($user->user_type == 1) buyer @elseif ($user->user_type == 2) vendor @else user @endif ?</p>

        <form id="actionForm">
          <div class="form-group mb-3">
            <label >Reason for suspend (optional):</label>
            <input type="hidden" id="userId" value="{{ $user->id }}">
            <input type="hidden" name="actionType" id="actionType">
              <input type="text" class="form-control" id="reasonInput" class="reasonInput" placeholder="Please enter reason">
              {{-- <a href="javascript:void(0)" class="btn btn-danger m-1" onclick="submitAction('suspend')">
                <span>Suspend</span>
              </a> --}}
          </div>
        </form>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary suspendmodel">Close</button>
        <a href="javascript:void(0)" class="btn btn-danger  m-1" onclick="submitAction('suspend')">
          <span>Suspend</span>
        </a>
      </div>
    </div>
  </div>
</div>



<script src="{{ asset('themes/admin/assets/js/form-validation.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $(".deviceInfo").hide();
    var deviceInfoShow = 0;
    $("#deviceInfobtn").on('click', function() {
      if (deviceInfoShow == 0) {
        $(".deviceInfo").show();
        deviceInfoShow = 1;
      } else {
        $(".deviceInfo").hide();
        deviceInfoShow = 0;
      }
    });

    $('.userbirthdate').datepicker({
      todayBtn: 'linked',
      format: 'yyyy-mm-dd',
      autoclose: true,
      endDate: "today"
    });


    $('.custom-nav-buttons').click(function(event) {
      event.preventDefault(); //stop browser to take action for clicked anchor
      //get displaying tab content jQuery selector
      var active_tab_selector = $(this).attr("target-discard");
      //hide displaying tab content
      $(active_tab_selector).removeClass('active');
      $(active_tab_selector).addClass('hide');

      //show target tab content
      var target_tab_selector = $(this).data("target");
      $(target_tab_selector).removeClass('hide');
      $(target_tab_selector).addClass('active');
    });

    if (!$('#image_demo').data('croppie')) {
      $image_crop = $('#image_demo').croppie({
        enableExif: true,
        viewport: {
          width: 350,
          height: 350,
          // type:'square' //circle // rectangular
        },
        boundary: {
          width: 600,
          height: 400
        }
      });
    } else {
      $('#image_demo').data('croppie').destroy();
      $image_crop = $('#image_demo').croppie({
        enableExif: true,
        viewport: {
          width: 350,
          height: 350,
          // type:'square' //circle // rectangular
        },
        boundary: {
          width: 600,
          height: 400
        }
      });
    }

    $(document).on('change', '#inputGroupFile01', function() {
      var name = $(this).attr('name');
      // var id_name= $(this).attr('id');
      // console.log('name = ' +name);
      var noImage = "{{asset('admin-theme/assets/images/default-img.png')}}";
      var ext = $(this).val().split('.').pop().toLowerCase();
      if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
        alert("Please select only image");
        return false;
      } else {
        //$("#file-error").attr("disabled", false);
        /* image crop */
        var reader = new FileReader();
        reader.onload = function(event) {
          $image_crop.croppie('bind', {
            url: event.target.result
          }).then(function() {
            // console.log('jQuery bind complete');
          });
        }
        reader.readAsDataURL(this.files[0]);
        $(".crop_image").attr('id', name);
        $('#insertimageModal').modal('show');

      }
      // return false;
      /* EOC image cropping */
    });

    $('.crop_image').click(function(event) {

      var className = $(this).attr('id');
      $image_crop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
      }).then(function(response) {
        $("#profile-pics-preview").attr("src", response);
        $("#imagebase64").val(response);

        $('#insertimageModal').modal('hide');
        $("#feed_image_error").html("");
      });
    });

    $('.deletemodel').click(function(event) {
      $('#modalConfirmDelete').modal('hide');
    });

    $('.blockmodel').click(function(event) {
      $('#modalConfirmBlock').modal('hide');
    });
    $('.suspendmodel').click(function(event) {
      $('#modalConfirmSuspend').modal('hide');
    });

    


  });
</script>