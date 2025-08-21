$(document).on("click",".viewInformation" ,function(e) {
  e.preventDefault();
  $.LoadingOverlay("show", {
    image: "/themes/loader.gif",
  });
  var dataId = $(this).data('id');
  var dataURL = $(this).data('url');
   $.ajax({
        type: "GET",
        url:  dataURL,
        success: function (data) {
          $('#dataInfoModal').html(data);
          $("#dataInfoModal").modal('show');
        $.LoadingOverlay("hide");
        },
    });

  $(document).on("click", "#deleteDetails", function (event) {
    event.preventDefault();
    $("#modalConfirmDelete").modal('show');
  });
  $(document).on("click", "#blockDetail", function (event) {
    event.preventDefault();
    $("#modalConfirmBlock").modal('show');
  });
  $(document).on("click", "#suspendDetail", function (event) {
    event.preventDefault();
    $("#modalConfirmSuspend").modal('show');
  });

});

function showToasterMessage(message, status) {
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
  $(function () {
      toastr[status](message);
  });
}