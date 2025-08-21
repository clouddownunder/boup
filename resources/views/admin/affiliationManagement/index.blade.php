@extends('admin.layouts.main')
@section('content')
<!-- Page -->
<div class="page">
  <div class="page-header">
    <h1 class="page-title">{{ __('admin.Affiliate-page-title') }}</h1>
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
        <h3 class="panel-title"> </h3>
      </header>
      <div class="panel-body app-contacts">

        <div class="row">

          <div class="col-md-12 text-right d-flex justify-content-end">

            <div class="mb-15 d-flex justify-content-end">
              <div class="user-export-csv">
                <a href="javascript:void(0);" onclick="openClinetModal()" class="btn btn-primary" id="exportattr">+ Add New Affiliation</a>
              </div>

            </div>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-hover dataTable table-striped w-full" id="data-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Logo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Business Name</th>
                <th>Website</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- End Panel Basic -->

    <div class="site-action" data-plugin="actionBtn">
      <div class="site-action-buttons">
        <button type="button" data-action="trash" class="btn-raised btn btn-success btn-floating animation-slide-bottom">
          <i class="icon md-delete" aria-hidden="true"></i>
        </button>
        <button type="button" data-action="folder" class="btn-raised btn btn-success btn-floating animation-slide-bottom">
          <i class="icon md-folder" aria-hidden="true"></i>
        </button>
      </div>
    </div>

    <!-- Add Client Form -->
    <div class="modal fade" id="addAffiliationForm" aria-hidden="true" aria-labelledby="addAffiliationForm" role="dialog" tabindex="-1" data-backdrop="static">
      <div class="modal-dialog modal-simple">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" aria-hidden="true" data-dismiss="modal">×</button>
            <h4 class="modal-title">Add Affiliate</h4>
          </div>
          <div class="modal-body">
            <form id="addAff" action="{{ route('createAffiliate') }}" method="post" enctype="multipart/form-data">
              @csrf

              <div class="row form-control-label-mb">
                <div class="form-group col-md-6 col-12 ">
                  <label class="form-control-label" for="inputBasicFirstName">Name</label>
                  <input type="text" class="form-control valid" value="" name="name" id="name" autocomplete="off" required="" aria-invalid="false">
                </div>
                <div class="form-group col-md-6 col-12 ">
                  <label class="form-control-label" for="inputBasicFirstName">Email</label>
                  <input type="text" class="form-control valid" value="" name="email" id="email" autocomplete="off" required="" aria-invalid="false">
                </div>
                <div class="form-group col-md-6 col-12 ">
                  <label class="form-control-label" for="inputBasicFirstName">Phone</label>
                  <input type="text" class="form-control valid" value="" name="phone" id="phone" autocomplete="off" required="" aria-invalid="false">
                </div>
                <div class="form-group col-md-6 col-12 ">
                  <label class="form-control-label" for="inputBasicFirstName">Business Name</label>
                  <input type="text" class="form-control valid" value="" name="business" id="business" autocomplete="off" required="" aria-invalid="false">
                </div>
                <div class="form-group col-md-6 col-12 ">
                  <label class="form-control-label" for="inputBasicFirstName">Website</label>
                  <input type="text" class="form-control " value="" name="url" id="url" autocomplete="off"  aria-invalid="false">
                  <p id="url_error" style="color:red;"></p>
                </div>
                <div class="form-group  form-material col-md-6 col-12" data-plugin="">
                  <label class="form-control-label" for="inputGroupFile01">Logo</label>
                  <div style="position: relative;">
                    <input type="text" class="form-control custom-file-label" placeholder="Browse.." readonly="" />
                    <input type="file" accept="image/png, image/jpeg, image/jpg, image/gif" id="inputGroupFile01" name="affimage" />
                    <p style="display: none;" class="error" id="error-file-too-large">Sorry, this file is too large! Maximum file size is <strong>4 MB</strong>.</p>
                    <p style="display: none;" class="error" id="error-invalid-type">Sorry, this file type is not supported. Please choose a JPEG, GIF, or PNG image.</p>
                  </div>
                  <span id="brTagAdd"></span>
                  <div id='img_contain' class="col-lg-12 col-md-12 col-sm-12">
                    <img style="display: none;" id="profile-pics-preview1" align='middle' width="100px" />
                  </div>
                  <input type="hidden" name="logo" id="imagebase64add">
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" id="submitButton" class="btn btn-add" style="background: #FF5221 !important;color: white;">Save</button>
                <button type="button" class="btn btn-cancel" data-dismiss="modal" style="background-color: white; color: black;">Cancel</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- End Add Client Form -->
  </div>
</div>
<!-- End Page -->
@stop

@section('footer_script')

<script>
  var MAX_SIZE = 1024 * 1024 * 4; // 4 MB
  var VALID_TYPES = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];

  function validateFile() {
    if (this.files && this.files.length) {
      var file = this.files[0];
      var type = file.type;
      var size = file.size;
      var fileNameSplit = file.name.split('.');
      var extension = fileNameSplit[fileNameSplit.length - 1];
      if (size > MAX_SIZE) {
        $('#error-file-too-large').css('display', 'block');
        $('#submitButton').prop('disabled', true);
        return false;
        $('#error-file-too-large').addClass('state-visible');
      } else {
        $('#error-file-too-large').removeClass('state-visible');
        $('#error-file-too-large').css('display', 'none');
        $('#submitButton').prop('disabled', false);
        return true;
      }
      if (VALID_TYPES.indexOf(type) < 0) {
        $('#error-invalid-type').addClass('state-visible');
        $('#error-invalid-type').css('display', 'block');
        $('#submitButton').prop('disabled', true);
        return false;
      } else {
        $('#error-invalid-type').removeClass('state-visible');
        $('#error-invalid-type').css('display', 'none');
        $('#submitButton').prop('disabled', false);
        return true;
      }
    }
  }

  function openClinetModal(url = null, data = [], isEdit = false) {
    $('#addAffiliationForm').modal('show');
    $("#addAff").validate().resetForm();
    if (isEdit) {
      $('.modal-title').html('Update Affiliate');
      $('#addAff').attr('action', url);
      $("#name").val(data.name)
      $("#email").val(data.email)
      $("#phone").val(data.phone)
      $("#business").val(data.business)
      $("#url").val(data.url)
      $("#dataInfoModal").modal('hide');

      $("#profile-pics-preview1").attr("src", data.logo);
      $("#profile-pics-preview1").css("display", "block");
      $("#inputGroupFile01").attr('name','editimage');
    } else {
      $('.modal-title').html('Add Affiliate');
      $('#addAff')[0].reset();

      $("#profile-pics-preview1").css("display", "none");
      $('#addAff').attr('action', "{{ route('createAffiliate') }}")
    }
  }

  function removeAffiliate(deleteUrl) {
    $("#dataInfoModal").modal('hide');
    Swal.fire({
      icon: 'warning',
      title: 'Boup',
      html: "Are you sure you want to delete the Affiliate details ?",
      showCancelButton: true,
      confirmButtonText: 'Yes',
      confirmButtonColor: '#ff0000',
      cancelButtonText: 'Cancel',
      cancelButtonColor: '#808080',
    }).then((result) => {
      if (result.isConfirmed) {
        $.LoadingOverlay("show", {
          image: "/themes/loader.gif",
        });
        $.ajax({
          type: "DELETE",
          url: deleteUrl,
          dataType: 'json',
          headers: {
            'X-CSRF-TOKEN': '<?= csrf_token() ?>'
          },
          success: function(response) {
            $.LoadingOverlay("hide");
            location.reload();
          }
        });
      } else {
        if (openModal) {
          $("#dataInfoModal").modal('show');
        }
      }
    })
  }

  $(document).ready(function() {
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
      "pageLength": 10,

      //"iDisplayLength": 5,
      //"lengthMenu": [[100, 150, 200, -1], [100, 150, 200, "All"]],
      // processing: true,
      // serverSide: true,
      ajax: '{{url("admin-api/Affiliate/getAllData")}}',
      columns: [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'logo',
          name: 'logo'
        },

        {
          data: 'name',
          name: 'name'
        },
        {
          data: 'email',
          name: 'email'
        },
        {
          data: 'mobile',
          name: 'mobile'
        },
        {
          data: 'business',
          name: 'business'
        },
        {
          data: 'url',
          name: 'url'
        },
        

      ]
    });
  });
</script>

<script type="text/javascript">
  if (!$('#image_demo').data('croppie')) {
    $image_crop = $('#image_demo').croppie({
      enableExif: true,
      viewport: {
        width: 350,
        height: 350,
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
      },
      boundary: {
        width: 600,
        height: 400
      }
    });
  }

  $(document).on('change', '#inputGroupFile01', function() {
    var name = $(this).attr('name');
    var noImage = "{{asset('admin-theme/assets/images/default-img.png')}}";
    var ext = $(this).val().split('.').pop().toLowerCase();
    if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
      alert("Please select only image");
      return false;
    } else {
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

  });

  $('.crop_image').click(function(event) {

    var className = $(this).attr('id');
    $image_crop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response) {
      $("#brTagAdd").after("<br/>");
      $("#profile-pics-preview1").css("display", "block");
      $("#profile-pics-preview1").attr("src", response);
      $("#imagebase64add").val(response);

      $('#insertimageModal').modal('hide');
      $("#feed_image_error").html("");
    });
  });

  $('.deletemodel').click(function(event) {
    $('#modalConfirmDelete').modal('hide');
  });
</script>

{{-- Drag & drop to reorder table --}}

<script type="text/javascript">
  $(function () {

      $("#data-table tbody").sortable({
          items: "tr",
          cursor: 'move',
          opacity: 0.6,
          update: function() {
              sendOrderToServer();
          }
      });

      function sendOrderToServer() {

          var order = [];
          var token = $('meta[name="csrf-token"]').attr('content');

          $('tr.viewInformation ').each(function(index,element) {
              order.push({
                  id: $(this).attr('data-id'),
                  position: index+1
              });
          });
          console.log(order);
          $(function () {
              $.ajaxSetup({
                  headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
              });
          });
          
          $.ajax({
              type: "post",
              dataType: "json",
              url: "{{ Route('reorder') }}",
                  data: {
                  order: order,
                  _token: '{{csrf_token()}}'
              },
              success: function(response) {
                  if (response.status == "success") {
                    $('#data-table').DataTable().ajax.reload();
                      console.log(response);
                  } else {
                    $('#data-table').DataTable().ajax.reload();
                    console.log(response);
                    
                  }
              }
          });
      }
  });
</script>

@stop