
<div class="modal-dialog modal-lg" id="myinformationModal">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">{{$page}}</h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
    <div class="modal-body" id="informationModelBody"> 
      <section class="panel">
        <div class="card card-primary card-outline card-tabs">
              <div class="card-header p-0 pt-1 border-bottom-0">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#view">View Details</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" data-url="#" id="editDetails" href="#menu2">Edit Details</a></li>
            <li class="nav-item"><a href="javascript:;" class="nav-link" data-redirect="" id="deleteDetails"> Delete</a></li>
        </ul>
        </div>
          <div class="card-body">
            <div class="tab-content"> 
                <div id="view" class="tab-pane fade in active show"><br>

                  <div class="form-row">  
                    <div class="form-group col-md-12 col-12">
                        <table class="table table-hover">
                          <tr>
                            <td><label>Question</label></td>
                            <td style='word-break: break-word;' >{{$faq->question}}</td>
                          </tr>
                          <tr>
                            <td><label>Answer</label></td>
                            <td style='word-break: break-word;' >{{$faq->answer}}</td>
                          </tr>
                          
                          
                        </table>  
                    </div>

                   
                  </div>

                </div>

                <div id="menu2" class="tab-pane fade">
                  <form id="faqEditForm" action="{{ url('admin/faq-management/').'/'.$faq->id }}" method="post" >
                    <div class="box-body">
                      @csrf
                      @method('PUT')
                        <div class="form-group"  >
                          <label for="question" >Question</label> <span class="text-danger" >*</span>
                          <textarea class="form-control" name="question" id="question1" style="min-height: 100px; " required>{{ $faq->question }}</textarea>
                        </div>
                        <div class="form-group" >
                          <label for="answer" >Answer</label> <span class="text-danger" >*</span>
                          <textarea class="form-control" name="answer" id="answer1" row="5" style="min-height: 100px; " required>{{ $faq->answer }}</textarea>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw" ></i>Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </form> 
                  <!-- /.box-body -->
                </div>
                  
              </div>
            </div>
          </div>
      </section>
    </div>
  </div>
</div> 

<!-- /.delete Model-open -->
<div class="modal fade in" id="modalConfirmDelete" role="dialog" aria-hidden="false">
  <div class="modal-dialog modal-sm modal-sm-new">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Delete</h4>
        <button type="button" class="close" onclick="$('#modalConfirmDelete').modal('hide');">×</button>
      </div>
      <div class="modal-body text-center">
        <p class="delete-conform-p">Are you sure you want to delete?</p>
      </div>
      
      <div class="modal-footer">
        <form action="{{ url('admin/faq-management/').'/'.$faq->id}}" method="post" > 
          @method('delete')
          @csrf
          <button type="submit" class="btn btn-danger btn-flat">Confirm Delete</button>
        </form>
        <button type="button" class="btn btn-default btn-flat"  onclick="$('#modalConfirmDelete').modal('hide');">Close</button>
      </div>
     
    </div>
  </div>
</div>
<!-- /.delete Model-close -->

<script src="{{ asset('admin_theme/assets/dist/js/custom_validation.js') }}"></script>
<script type="text/javascript">
  $('#question1').on('keyup',function(){
    let val = $('#question1').val();
    $('#question1').val(val.trimStart());
  });
  $('#answer1').on('keyup',function(){
    let val = $('#answer1').val();
    $('#answer1').val(val.trimStart());
  })
</script>