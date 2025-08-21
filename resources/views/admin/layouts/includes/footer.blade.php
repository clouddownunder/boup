<footer class="site-footer">
    <div class="site-footer-legal">© {{date("Y")}} {{config::get('constant.APP_NAME')}}</div>
  </footer>

<div class="modal fade in" id="logoutPopup" role="dialog" aria-hidden="false">
  <div class="modal-dialog modal-sm modal-sm-new">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Logout</h4>
        {{-- <button type="button" class="close" data-dismiss="modal">×</button> --}}
      </div>
      <form id="logout-form" action="{{ route('adminlogout') }}" method="POST">
          {{ csrf_field() }}
        <div class="modal-body text-center">
          <p class="delete-conform-p">Are you sure want to logout?</p>
        </div>


        <div class="modal-footer">
          <button type="submit" class="btn btn-primary waves-effect waves-classic" >Yes</button>
          <button type="button" class="btn btn-danger waves-effect waves-classic" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End changes -->
<div class="modal fade" id="dataInfoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true"></div>

<!-- BOC image crop pop-up -->
<div id="insertimageModal" class="modal" role="dialog">
 <div class="modal-dialog modal-lg">
  <div class="modal-content">
      <div class="modal-header slidePanel-header bg-light-green-600">
        <div class="overlay-top overlay-panel overlay-background bg-light-green-600 rotate-color-combo">
          <div class="slidePanel-actions btn-group btn-group-flat" aria-label="actions" role="group">
            <button type="button" class="btn btn-pure slidePanel-close icon md-close btnClosePopup2" data-dismiss="modal" aria-hidden="true" aria-label="Close"></button>
          </div>
          <h5 class="stage-name taskboard-stage-title">Crop Image</h5>
        </div>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 text-center">
            <div id="image_demo" class="imageCropPreview" ></div>
          </div>
        </div>
        <div class="row remove-wrap" >
          <div class="col-md-6 col-6 text-left">
            <button type="button" class="btn btn-secondary crop-btn btnClosePopup2" id="btnClosePopup2" data-dismiss="modal" >Close</button>
          </div>
          <div class="col-md-6 col-6 text-right">
            <button class="btn btn-primary crop_image crop-btn" id="">Crop Image</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- EOC  image crop pop-up -->

  <!-- Core  -->
  <script src="{{ asset('themes/admin/assets/global/vendor/babel-external-helpers/babel-external-helpersfd53.js') }}"></script>

  <script src="{{ asset('themes/admin/assets/global/vendor/jquery/jquery.minfd53.js') }}"></script>

  <script src="{{ asset('themes/admin/assets/global/vendor/popper-js/umd/popper.minfd53.js') }}"></script>

  <script src="{{ asset('themes/admin/assets/global/vendor/bootstrap/bootstrap.minfd53.js') }}"></script>

  <script src="{{ asset('themes/admin/assets/global/vendor/animsition/animsition.minfd53.js') }}"></script>

  <script src="{{ asset('themes/admin/assets/global/vendor/mousewheel/jquery.mousewheel.minfd53.js') }}"></script>

  <script src="{{ asset('themes/admin/assets/global/vendor/asscrollbar/jquery-asScrollbar.minfd53.js') }}"></script>

  <script src="{{ asset('themes/admin/assets/global/vendor/asscrollable/jquery-asScrollable.minfd53.js') }}"></script>

  <script src="{{ asset('themes/admin/assets/global/vendor/ashoverscroll/jquery-asHoverScroll.minfd53.js') }}"></script>

  <script src="{{ asset('themes/admin/assets/global/js/Component.minfd53.js') }}"></script>

  <script src="{{ asset('themes/admin/assets/global/js/Plugin.minfd53.js') }}"></script>

  <script src="{{ asset('themes/admin/assets/global/js/Base.minfd53.js') }}"></script>

  <script src="{{ asset('themes/admin/assets/global/js/Config.minfd53.js') }}"></script>

  <script src="{{ asset('themes/admin/assets/js/Section/Menubar.minfd53.js') }}"></script>

  <script src="{{ asset('themes/admin/assets/js/Section/Sidebar.minfd53.js') }}"></script>

  <script src="{{ asset('themes/admin/assets/js/Section/PageAside.minfd53.js') }}"></script>

  <script src="{{ asset('themes/admin/assets/js/Plugin/menu.minfd53.js') }}"></script>

  <script src="{{ asset('themes/admin/assets/js/Site.minfd53.js') }}"></script>

  <script src="{{ asset('themes/admin/assets/global/vendor/toastr/toastr.minfd53.js') }}"></script>

  <script src="{{ asset('themes/admin/assets/examples/js/dashboard/v1.minfd53.js') }}"></script>

  <script src="{{ asset('themes/admin/assets/js/loadingoverlay.min.js') }}"></script>

  <script src="{{ asset('themes/admin/assets/global/vendor/datatables.net/jquery.dataTablesfd53.js?v4.0.1') }}"></script>

  <script src="{{ asset('themes/admin/assets/global/vendor/datatables.net-bs4/dataTables.bootstrap4fd53.js?v4.0.1') }}"></script>

  <script src="{{asset('themes/admin/assets/js/croppie.2.6.4.js')}}"></script>
  <script src="{{ asset('themes/admin/assets/js/jquery.validate.js') }}"></script>

  <script src="{{ asset('themes/admin/assets/js/form-validation.js') }}"></script>

  <script src="{{ asset('themes/admin/assets/js/modal.js') }}"></script>

  <!-- <script src="{{ asset('themes/admin/assets/global/vendor/bootstrap-datepicker/bootstrap-datepicker.minfd53.js?v4.0.1') }}"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.9.2/ckeditor.js"></script>
  <!-- Select2 JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
  <script src="{{ asset('themes/admin/assets/js/jquery-clockpicker.js') }}"></script>
<script type="text/javascript">
$(function() {
    $(document).ready(function(){
      $.ajaxSetup({
          headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
          }
      });

    $('.site-menu-item > a').off('click').on('touchstart', function(e) { 
      location.href = $(this).closest('a').attr('href'); 
     });

    });
    toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": false,
      "progressBar": true,
      "positionClass": "toast-top-center",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
  <?php
    $messageArr = ['warning', 'danger', 'info', 'error', 'success'];
    foreach($messageArr as $message)
    {
      if(session()->has($message))
      {
    ?>
      $(function () {
          toastr["{{$message}}"]("{{session()->get($message)}}");
      });
    <?php
      }
    }
    ?>
});
function logout()
{
    Swal.fire({
        icon: 'warning',
        title:'Boup',
        html: "Are you sure you want to logout?",
        showCancelButton: true,
        confirmButtonText: 'Yes',
        confirmButtonColor: '#ff0000',
        cancelButtonText: 'No',
        cancelButtonColor: '#808080',
        }).then((result) => {
        if (result.isConfirmed) {
            $.LoadingOverlay("show", {
              image: "/themes/loader.gif",
            });
            $.ajax({
                type : "POST",
                url : "{{ route('adminlogout') }}",
                dataType: 'html',
                headers: {
                    'X-CSRF-TOKEN': '<?= csrf_token() ?>'
                },
                success : function(response) {
                    $.LoadingOverlay("hide");
                    location.reload();
                }
            });
        }
    })
}

</script>
