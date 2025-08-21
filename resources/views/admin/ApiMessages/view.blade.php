
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
        </ul>
        </div>
          <div class="card-body">
            <div class="tab-content">
                <div id="view" class="tab-pane fade in active show"><br>

                  <div class="form-row">
                    <div class="form-group col-md-12 col-12">
                        <table class="table table-hover">
                          <tr>
                            <td><label>Name</label></td>
                            <td style='word-break: break-word;' >{{$apiMessage['name']}}</td>
                          </tr>
                          <tr>
                            <td><label>Message</label></td>
                            <td style='word-break: break-word;' >{{$apiMessage['message']}}</td>
                          </tr>
                        </table>
                    </div>
                  </div>

                </div>

                <div id="menu2" class="tab-pane fade">
                  <form id="apiMessageForm" action="{{ url('admin/api-messages/').'/'.$apiMessage['name'] }}" method="post" >
                    <div class="box-body">
                        @csrf
                        @method('PUT')
                        <div class="form-group" >
                          <label class="form-control-label" for="name" >Name</label> <span class="text-danger" >*</span>
                          <input class="form-control valid" name="name" id="name" value="{{ $apiMessage['name'] }}" readonly autocomplete="off" required="" aria-invalid="false">
                        </div>
                        <div class="form-group" >
                          <label class="form-control-label" for="message" >Message</label> <span class="text-danger" >*</span>
                          <input type="text" class="form-control valid"  value="{{ $apiMessage['message'] }}" name="message" id="message" autocomplete="off" required="" aria-invalid="false">
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw" ></i>Save</button>
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
