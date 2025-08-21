<div class="modal-dialog modal-dialog-slideout" role="document">
    <div class="modal-content">
      <div class="modal-header slidePanel-header bg-light-green-600">
        <div class="overlay-top overlay-panel overlay-background bg-light-green-600 rotate-color-combo">
          <div class="slidePanel-actions btn-group btn-group-flat" aria-label="actions" role="group">
            <!-- <button type="button" class="btn btn-pure icon md-edit subtask-toggle custom-nav-buttons" id="openEditForm" aria-hidden="true" data-target="#editForm" target-discard="#viewForm" title="Edit"></button> -->
            {{-- <button type="button" class="btn btn-pure icon md-delete subtask-toggle" aria-hidden="true" id="deleteDetails" title="Delete"></button> --}}
            <button type="button" class="btn btn-pure slidePanel-close icon md-close" data-dismiss="modal" aria-hidden="true" title="Close"></button>
          </div>
          <h5 class="stage-name taskboard-stage-title">{{ $page }}</h5>
        </div>
      </div>
      <div class="modal-body custom-nav-tabs">
        <div id="viewForm" class="active">
          <table class="table" >

            <tr>
              <td width="25%"><label class="text-bold">User Type</label></td>
              <td>@if ($feedback->user->user_type === 1) Commercial Diver @elseif ($feedback->user->user_type === 2) Diver Supervisor  @elseif ($feedback->user->user_type === 3) Diving Companies	 @else N/A @endif</td>
            </tr>
            <tr>
              <td width="25%"><label class="text-bold">Full Name </label></td>
              <td>{{ucfirst($feedback->user->first_name) ?? 'N/A'}} {{ucfirst($feedback->user->last_name)}}</td>
            </tr>
            <tr>
              <td width="25%"><label class="text-bold">Email </label></td>
              <td>{{$feedback->user->email ?? 'N/A'}}</td>
            </tr>
            {{-- @foreach ($feedbacks as $feedbackData) --}}
              
              <tr>
                <td width="25%"><label class="text-bold">Experience </label></td>
                <td class="long-text">{{ucfirst($feedback->experience) ?? 'N/A'}}</td>
              </tr>
              <tr>
                <td width="25%"><label class="text-bold">Suggestion </label></td>
                <td class="long-text">{{ucfirst($feedback->suggestion) ?? 'N/A'}}</td>
              </tr>
              <tr>
                <td width="25%"><label class="text-bold">Submitted On </label></td>
                <td> {{ fetchDateFormate($feedback->feedback_date) }}</td>
              </tr>
              <tr>
                <td width="25%"><label class="text-bold">Device Type </label></td>
                <td>{{ isset($feedback->device_type) ? ($feedback->device_type == 1) ? 'iOS' : 'Android': 'N/A'}}</td>
              </tr>
              <tr>
                <td width="25%"><label class="text-bold">Device Name </label></td>
                <td>{{$feedback->device_name ?? 'N/A'}}</td>
              </tr>
              <tr>
                <td width="25%"><label class="text-bold">App Version </label></td>
                <td>{{$feedback->app_version ?? 'N/A'}}</td>
              </tr>
              <tr>
                <td width="25%"><label class="text-bold">OS Version </label></td>
                <td>{{$feedback->os_version ?? 'N/A'}}</td>
              </tr>
            {{-- @endforeach --}}
          </table>
        </div>
      </div>
      {{-- <div class="feedback-detail-wp">
        <div class="feedback-detail-mmain">
          <div class="head-title-wrap">
            <div class="head-title">
              <h3>{{ucfirst($feedback->user->first_name) ?? 'N/A'}} {{ucfirst($feedback->user->last_name) ?? 'N/A'}} (@if ($feedback->user->user_type === 0) Commercial Diver @elseif ($feedback->user->user_type === 1) Diver Supervisor  @elseif ($feedback->user->user_type === 2) Diving Companies	 @else N/A @endif)</h3>
            </div>
            <div class="head-title">
              <h4>{{$feedback->user->email ?? 'N/A'}}</h4>
            </div>
          </div>
          @foreach ($feedbacks as $feedbackData)
            <div class="feedback-exp-main">
              <div class="feedback-exp-box">
                <div class="feedback-exp-date">
                  {{ fetchDateFormate($feedbackData->feedback_date) }}
                </div>
                  <div class="head-title">
                    <h5>Experience</h5>
                  </div>
                  <div class="feedback-exp-txt">
                    <p>{{ucfirst($feedbackData->experience) ?? 'N/A'}}</p>
                  </div>
                  <div class="head-title">
                    <h5>Suggestions</h5>
                  </div>
                  <div class="feedback-exp-txt">
                    <p>{{ucfirst($feedbackData->suggestion) ?? 'N/A'}}</p>
                  </div>
                  <div class="head-title">
                    <h5>Device Info</h5>
                  </div>
                  <div class="feedback-exp-txt">
                    <p>Device Name : {{ucfirst($feedbackData->device_name) ?? 'N/A'}}<br> OS Version : {{ucfirst($feedbackData->os_version) ?? 'N/A'}}<br> App Version : {{ucfirst($feedbackData->app_version) ?? 'N/A'}}</p>
                  </div>
              </div>
            </div>
          @endforeach
        </div>
      </div> --}}
    </div>
  </div>

  <!-- /.delete Model-open -->
  <div class="modal fade modal-fade-in-scale-up" id="modalConfirmDelete" aria-hidden="true"
                      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
      <div class="modal-dialog modal-sm modal-sm-new">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close deletemodel" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Delete</h4>
          </div>
            <div class="modal-body">
              <p class="delete-conform-p">Are you sure you want to delete?</p>
            </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger deletemodel" >Close</button>
                  <button type="submit" class="btn btn-primary">Delete</button>
                </div>
        </div>
      </div>
    </div>
  <!-- /.delete Model-close -->


  <script src="{{ asset('themes/admin/assets/js/form-validation.js') }}"></script>
    <script type="text/javascript">
      $(document).ready(function() {

        $('.userbirthdate').datepicker({
            todayBtn:'linked',
            format: 'yyyy-mm-dd',
            autoclose:true,
            endDate: "today"
         });


          $('.custom-nav-buttons').click(function(event){
            event.preventDefault();//stop browser to take action for clicked anchor
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

          if(!$('#image_demo').data('croppie')){
            $image_crop = $('#image_demo').croppie({
              enableExif: true,
              viewport: {
                width:350,
                height:350,
                // type:'square' //circle // rectangular
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
                // type:'square' //circle // rectangular
              },
              boundary:{
                width:600,
                height:400
              }
            });
          }

          $(document).on('change','#inputGroupFile01',function() {
            var name = $(this).attr('name');
            // var id_name= $(this).attr('id');
            // console.log('name = ' +name);
            var noImage = "{{asset('admin-theme/assets/images/default-img.png')}}";
            var ext = $(this).val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
                alert("Please select only image");
                return false;
            }
            else{
              //$("#file-error").attr("disabled", false);
                /* image crop */
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
            // return false;
            /* EOC image cropping */
          });

          $('.crop_image').click(function(event){

              var className = $(this).attr('id');
            $image_crop.croppie('result', {
              type: 'canvas',
              size: 'viewport'
            }).then(function(response){
              $("#profile-pics-preview").attr("src",response);
              $("#imagebase64").val(response);

              $('#insertimageModal').modal('hide');
              $("#feed_image_error").html("");
            });
          });

          $('.deletemodel').click(function(event){
            $('#modalConfirmDelete').modal('hide');
            });
      });
    </script>
