<div class="modal-dialog modal-dialog-slideout" role="document">
    <div class="modal-content">
      <div class="modal-header slidePanel-header bg-light-green-600">
        <div class="overlay-top overlay-panel overlay-background bg-light-green-600 rotate-color-combo">
          <div class="slidePanel-actions btn-group btn-group-flat" aria-label="actions" role="group">
            <!-- <button type="button" class="btn btn-pure icon md-edit subtask-toggle custom-nav-buttons" id="openEditForm" aria-hidden="true" data-target="#editForm" target-discard="#viewForm" title="Edit"></button> -->
            {{-- <button type="button" class="btn btn-pure icon md-delete subtask-toggle" style="color:white" aria-hidden="true" id="deleteDetails" title="Delete"></button> --}}
            <button type="button" class="btn btn-pure slidePanel-close icon md-close" style="color:white" data-dismiss="modal" aria-hidden="true" title="Close"></button>
          </div>
          <h5 class="stage-name taskboard-stage-title">{{ __('admin.jobs-view-title') }}
          </h5>
        </div>
      </div>
      <div class="modal-body custom-nav-tabs">
        <div id="viewForm" class="active">
          <table class="table">
            <tr>
              <td width="25%"><label class="text-bold">Logo</label></td>
              <td>
                @if($jobs->user->business_logo)
                  <img width="100" class="img-fluid" src="{{asset('storage/business/logo/' . $jobs->user->business_logo)}}">
                @else
                  <img width="100" class="img-fluid" src="{{asset('assets/images/businesslogo.png')}}">    
                @endif
              </td>
            </tr>

            <tr>
              <td width="25%"><label class="text-bold">Company Name</label></td>
              <td> {{ $jobs->user->business_name ?? 'N/A'}}
              </td>
            </tr>

            <tr>
              <td width="25%"><label class="text-bold">Job Title</label></td>
              <td>{{ $jobs->title ?? 'N/A'}}</td>
            </tr>
            <tr>
              <td width="25%"><label class="text-bold">Email</label></td>
              <td>{{$jobs->contact_email ?? 'N/A'}}</td>
            </tr>
            <tr>
              <td width="25%"><label class="text-bold">Duration</label></td>
              <td>{{$jobs->duration ?? 'N/A'}}</td>
            </tr>
            <tr>
                <td width="25%"><label class="text-bold">Suburb</label></td>
                <td>{{$jobs->suburb ?? 'N/A'}}</td>
            </tr>
            <tr>
                <td width="25%"><label class="text-bold">Description</label></td>
                <td>{{$jobs->description ?? 'N/A'}}</td>
            </tr>
            <tr>
              <td width="25%"><label class="text-bold">Created Date</label></td>
              <td>@empty($jobs->date) N/A @else {{ fetchDateFormate($jobs->date) }} @endEmpty</td>
            </tr>
            </table>
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