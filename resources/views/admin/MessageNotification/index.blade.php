@extends('admin.layouts.main')
@section('content')
  
  <!-- Page -->
  <div class="page">
    <div class="page-header">
      <h1 class="page-title">Notification Messages</h1>
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
        <div class="panel-body">
          <table class="table table-hover dataTable table-striped w-full" id="data-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Access Key</th>
                <th>Message</th>
              </tr>
            </thead>
            {{-- <tfoot>
              <tr>
                <th>ID</th>
                <th>Access Key</th>
                <th>Message</th>
              </tr>
            </tfoot> --}}
            <tbody>

            </tbody>
          </table>
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
            //"iDisplayLength": 5,
            //"lengthMenu": [[100, 150, 200, -1], [100, 150, 200, "All"]],
            processing: true,
            serverSide: true,
            ajax: '{{url("admin/notification-messages/getAllData")}}',
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'access_key', name: 'access_key'},
                {data: 'message', name: 'message'},
            ]
        });
    });


</script>

@stop