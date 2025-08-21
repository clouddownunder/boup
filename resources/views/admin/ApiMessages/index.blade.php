@extends('admin.layouts.main')
@section('content')

  <!-- Page -->
  <div class="page">
    <div class="page-header">
      <h1 class="page-title">{{ __('admin.api-messages-page-title') }}</h1>
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
          <h3 class="panel-title">  </h3>
        </header>
        <div class="panel-body app-contacts">
          <div class="row">
            <div class="col-md-12 text-right">
              <div class="mb-15">
              </div>
            </div>
          </div>
          <div class="table-responsive">
          <table class="table table-hover dataTable table-striped w-full" id="data-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Message</th>
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
<script>
    $(document).ready(function(){
        var dt = $('#data-table').DataTable({
            "aaSorting": [],
            "stateSave": false,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "iDisplayLength": 10,
           // "lengthMenu": [[10,100, 150, 200, -1], [10,100, 150, 200, "All"]],
            processing: true,
            serverSide: true,
            ajax: '{{url("admin-api/api-message-list/getAllData")}}',
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'messages', name: 'messages'},
            ]
        });
    });


</script>

@stop
