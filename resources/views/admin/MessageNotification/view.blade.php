<div class="modal-dialog modal-dialog-slideout" role="document">
  <div class="modal-content">
    <div class="modal-header slidePanel-header bg-light-green-600">
      <div class="overlay-top overlay-panel overlay-background bg-light-green-600 rotate-color-combo">
        <div class="slidePanel-actions btn-group btn-group-flat" aria-label="actions" role="group">
          <button type="button" class="btn btn-pure icon md-edit subtask-toggle custom-nav-buttons" id="openEditForm" aria-hidden="true" data-target="#editForm" target-discard="#viewForm"></button>
          {{-- <button type="button" class="btn btn-pure icon md-delete subtask-toggle" aria-hidden="true"></button> --}}
          <button type="button" class="btn btn-pure slidePanel-close icon md-close" data-dismiss="modal" aria-hidden="true"></button>
        </div>
        <h5 class="stage-name taskboard-stage-title">View Details</h5>
      </div>
    </div>
    <div class="modal-body custom-nav-tabs">
      <div id="viewForm" class="active">
        <table class="table" >
          <tr>
            <td width="25%"><label class="text-bold">Access Key</label></td>
            <td>{{$messageDB->access_key}}</td>
          </tr>
          <tr>
            <td width="25%"><label class="text-bold">Message</label></td>
            <td>{{$messageDB->message}}</td>
          </tr>
        </table>  
      </div>
      <div id="editForm" class="hide" {{-- style="display: none" --}}>
        <div class="box-body">
          {{ Form::model($messageDB, ['route' => ['notification-messages.update', $messageDB->id], 'method' => 'put', 'role' => 'form','enctype'=>'multipart/form-data','id'=>'messageEditForm'] ) }}
            <div class="form-group">
              {{ Form::label('Message','Message') }} <span class="red">*</span>
              
              <div class="no-padding">
                {{ Form::text('message',null,['class'=>'form-control','placeholder'=>'Enter message ','autocomplete'=>'off'],old('message'))}}
              </div>
            </div>
            <div class="form-group text-right">
              <button type="submit" class="btn btn-primary">Submit</button>
              <button type="button" class="btn btn-secondary custom-nav-buttons" target-discard="#editForm" data-target="#viewForm">Close</button>
            </div>
          {!! Form::close() !!}
        </div>
      
      </div>
    </div>
  </div>
</div>

<script src="{{ asset('themes/admin/assets/js/form-validation.js') }}"></script>
  <script type="text/javascript">
    $(document).ready(function() {
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
    });
  </script>
