@extends('admin.layouts.main')
@section('content')

  <!-- Page -->
  <div class="page">
    <div class="page-header">
      <h1 class="page-title">{{ __('admin.notification-page-title') }}</h1>
      <ol class="breadcrumb">
        {{-- <li class="breadcrumb-item"><a href="../index.html">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Tables</a></li>
        <li class="breadcrumb-item active">DataTables</li> --}}
      </ol>
    </div>

    <div class="page-content">
      <!-- Panel Basic -->
      <div class="panel">
        <header class="panel-heading">
          <div class="panel-actions"></div>
          <h3 class="panel-title"></h3>
        </header>
        <div class="panel-body">

            <form method="post" id="notificationForm">
                @csrf
                <div class="row">
                    <div class="col-md-5">
                      <div class="form-group">
                          <label for="notificationTo"><span style="font-weight:700">Types of Users </span></label>
                          <div class="no-padding{{ ($errors->has('notificationTo')) ? ' has-error' : '' }}">
                          <select class="form-control proximityOption" name="notificationTo" id="notificationTo">
                              <option value="All">All users</option>
                              <option value="Parents">Parents</option>
                              <option value="Athletes">Athletes</option>
                          </select>
                          @if($errors->has('notificationTo'))
                          <span class="help-block alert-danger">{{ $errors->first('notificationTo') }}</span>
                          @endif
                          </div>
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="notificationTo"><span style="font-weight:700">Description </span></label>
                            <textarea class="form-control" name="description" id="textOne" rows="6" maxlength="150" placeholder=" Max 150 characters allowed" spellcheck="false"></textarea>
                            @if($errors->any())
                            <span class="help-block alert-danger">                                    
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </span>
                            @endif
                        </div>
                    </div>
                    {{-- <div class="col-md-6">
                        <div class="form-group">
                            <select name="type" id="" class="form-control" required>
                                <option value="" selected disabled>Select User</option>
                                <option value="All"> All</option>
                                <option value="User"> Users </option>
                            </select>
                        </div>
                    </div> --}}
                    {{-- <div class="col-md-2">
                        <div class="form-group">
                            <input style="width: 60%;" type="submit" class="btn btn-primary form-control" value="Send Notification">
                        </div>
                    </div> --}}
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <input style="width: 60%;" type="submit" class="btn btn-primary form-control" value="Send Notification">
                        </div>
                    </div>
                </div>
            </form>
        </div>
      </div>

      <div class="panel">
        <header class="panel-heading">
          <div class="panel-actions"></div>
          <h3 class="panel-title"></h3>
        </header>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-hover dataTable table-striped w-full" id="data-table">
                    <thead>
                    <tr>
                        <th class="min-50">ID</th>
                        <th class="min-50">Type</th>
                        <th class="min-100">Description</th>
                        <th class="min-100">Sent On</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
      </div>
      <!-- End Panel Basic -->
    </div>
  </div>
  <!-- End Page -->
@stop

@section('footer_script')
<script src='{{ asset('themes/admin/assets/js/Emoji/inputEmoji.js') }}'></script>
<script>
    $(function () {
        $('textarea').emoji({place: 'after'});
    })
</script>
<script>
    $(document).ready(function(){
      // alert("hedrdsf");
        var dt = $('#data-table').DataTable({
            "aaSorting": [],
            "stateSave": false,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "iDisplayLength": 100,
            //"lengthMenu": [[100, 150, 200, -1], [100, 150, 200, "All"]],
            "language": {
              "emptyTable": "No data available in notifications management."
            },
            processing: true,
            serverSide: true,
            ajax: '{{$ajaxUrl}}',
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'type', name: 'type'},
                {data: 'description', name: 'description'},
                {data: 'sent_on', name: 'sent_on'},
            ]
        });

        $('#notificationForm').on('submit', function () {
                $.LoadingOverlay("show", {
                    image: "/themes/loader.gif", // adjust path if needed
                });
            });
    });


</script>

@stop
