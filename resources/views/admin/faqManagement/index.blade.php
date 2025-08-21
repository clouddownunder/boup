@extends('admin.layouts.main')

@section('content')
<div class="page">
  <div class="page-header">
    <h1 class="page-title">{{ __('admin.faq-page-title') }}</h1>
    <ol class="breadcrumb">
      {{-- <li class="breadcrumb-item"><a href="../index.html">Home</a></li>
      <li class="breadcrumb-item"><a href="javascript:void(0)">Tables</a></li>
      <li class="breadcrumb-item active">DataTables</li> --}}
    </ol>
  </div>
<!-- Content Wrapper. Contains page content -->
  <!-- Content Header (Page header) -->
  <div class="page-content">
    <!-- Panel Basic -->
    <div class="panel">
      <header class="panel-heading">
        <div class="panel-actions"></div>
        <h3 class="panel-title">  </h3>
      </header>
      <div class="">
      <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="tab-pane fade show active" id="custom-tabs-two-all" role="tabpanel" aria-labelledby="custom-tabs-two-all-tab">
            <!-- <div class="card"> -->
               <div class="card-body">
                      <div class="text-right">
                        <a  class="text-white btn btn-primary" data-toggle="modal" data-target="#exampleModal" >+ Add New FAQ</a>
                      </div> 
                      <br>
                      <table id="all-table" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th width="5%">ID</th>
                            <th>Question</th>
                            <th>Answer</th>
                          </tr>
                        </thead>
                        <tbody id="tablecontents" >

                        </tbody>
                        {{-- <tfoot>
                          <tr>
                            <th>ID</th>
                            <th>Question</th>
                            <th>Answer</th>
                          </tr>
                        </tfoot> --}}
                      </table>
                    </div>
                  <!-- </div> -->
                </div>

                

            <!-- </div> -->
            <!-- /.card-body -->
          </div>
        </div>

      <!-- /.col -->
    </div>
    <!-- /.row -->
      </div>
    </div>
  </div>
  <!-- /.content -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Add New FAQ</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="faqAddForm" action="{{ route('faq-management.store') }}" method="post" >
      	@csrf
	      <div class="modal-body">
          <div class="card">
            <div class="form-group" >
              <label for="question" >Question</label> <span class="text-danger" >*</span>
              <textarea class="form-control" name="question" id="question" ></textarea>
            </div>
            <div class="form-group" >
              <label for="answer" >Answer</label> <span class="text-danger" >*</span>
              <textarea class="form-control" name="answer" id="answer" ></textarea>
            </div>
            
          </div>
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw" ></i>Save</button>
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	      </div>
      </form>
    </div>
  </div>
</div>

  </div>
<!-- /.content-wrapper -->

	
@stop
@section('footer_script')
<script type="text/javascript">
	$(document).ready(function(){

      $("#tablecontents").sortable({
          items: "tr",
          cursor: 'move',
          opacity: 0.6,
          update: function() {
              sendOrderToServer();
          }
        });

      var dt = $('#all-table').DataTable({
        "aaSorting": [],
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "destroy": true,
        "pageLength": 10,
            //"iDisplayLength": 5,
            //"lengthMenu": [[100, 150, 200, -1], [100, 150, 200, "All"]],
            // processing: true,
            // serverSide: true,
            ajax: '{{url("admin-api/faq-management/getAllFaq")}}',
            columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'question', name: 'question'},
            {data: 'answer', name: 'answer'},
            ]
          });

      
      function sendOrderToServer(){
        // alert('working')
        var order = [];
        var token = "{{ csrf_token() }}";
        $('tr.viewInformation').each(function(index,element) {
          order.push({
            id: $(this).attr('data-id'),
            position: index+1
          });
        });
        $.ajax({
          type: "POST", 
          dataType: "json", 
          url: "{{ url('admin-api/faq/sortable') }}",
              data: {
            order: order,
            _token: token
          },
          success: function(response) {
              if (response.status == "success") {
                console.log(response);
              } else {
                console.log(response);
              }
          }
        });
      }
    
  });

  $('#question').on('keyup',function(){
    let val = $('#question').val();
    $('#question').val(val.trimStart());
  });
  $('#answer').on('keyup',function(){
    let val = $('#answer').val();
    $('#answer').val(val.trimStart());
  })
</script>
@stop