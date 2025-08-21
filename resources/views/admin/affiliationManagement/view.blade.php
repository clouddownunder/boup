<div class="modal-dialog modal-dialog-slideout" role="document">
    <div class="modal-content">
      <div class="modal-header slidePanel-header bg-light-green-600">
        <div class="overlay-top overlay-panel overlay-background bg-light-green-600 rotate-color-combo">
          <div class="slidePanel-actions btn-group btn-group-flat" aria-label="actions" role="group">
            <button type="button" class="btn btn-pure slidePanel-close icon md-close" data-dismiss="modal" aria-hidden="true" title="Close"></button>
          </div>
          <h5 class="stage-name taskboard-stage-title">{{ __('admin.Affiliate-view-title') }}</h5>
        </div>
      </div>
      <div class="modal-body custom-nav-tabs">
        <div id="viewForm" class="active">
          <table class="table" >
            <tr>
              <td width="25%"><label class="text-bold">Logo</label></td>
              <td>
                @empty($affiliate->logo)
                  <img width="100" class="img-fluid" src="{{$affiliate->logo}}">
                  
                @else
                
                  <img width="100" class="img-fluid" src="{{$affiliate->logo}}">
                @endEmpty
              </td>
            </tr>
            <tr>
              <td width="25%"><label class="text-bold">Name</label></td>
              <td>@if($affiliate->name) {{$affiliate->name}} @else N/A @endif</td>
            </tr>
            <tr>
              <td width="25%"><label class="text-bold">Email</label></td>
              <td>@if($affiliate->email) {{$affiliate->email}} @else N/A @endif</td>
            </tr>
            <tr>
              <td width="25%"><label class="text-bold">Phone</label></td>
              <td>@if($affiliate->phone) {{$affiliate->phone}} @else N/A @endif</td>
            </tr>
            <tr>
              <td width="25%"><label class="text-bold">Business Name</label></td>
              <td>@if($affiliate->business) {{$affiliate->business}} @else N/A @endif</td>
            </tr>
            <tr>
              <td width="25%"><label class="text-bold">Website</label></td>
              @if($affiliate->url)
                <td><a href="{{$affiliate->url}}" target="_blank">{{$affiliate->url}}</a></td>
              @else  
                <td>N/A</td>
              @endif
            </tr>
            {{-- <tr>
              <td width="25%"><label class="text-bold">Registered On</label></td>
              <td>{{isset($affiliate->created_at) ? Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $affiliate->created_at)->format('d M Y g:i A') : 'N/A'}}</td>
            </tr> --}}
            <tr>
              <td colspan="2">
                <a href="javascript:void(0)" onclick="openClinetModal('{{route('updateAffiliate',['affiliate' => $affiliate])}}',{{$affiliate}},true)" class="btn btn-primary" role="button">Edit</a>
                <a href="javascript:void(0)" onclick="removeAffiliate('{{route('deleteAffiliate',['affiliate' => $affiliate])}}')" class="btn btn-primary" role="button">Delete</a>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>


  <script src="{{ asset('themes/admin/assets/js/form-validation.js') }}"></script>
<script>

</script>
