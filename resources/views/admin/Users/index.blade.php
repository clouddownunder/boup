<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<style>
.user {
  display: inline-block;
  width: 150px;
  height: 150px;
  border-radius: 50%;

  object-fit: cover;
}
td label {
    white-space: nowrap;
}
</style>
@extends('admin.layouts.main')
@section('content')
<!-- Page -->
<div class="page">
  <div class="page-header">
    <h1 class="page-title">{{ __('admin.users-page-title') }}</h1>
    <ol class="breadcrumb">
      {{-- <li class="breadcrumb-item"><a href="../index.html">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Tables</a></li>
        <li class="breadcrumb-item active">DataTables</li> --}}
    </ol>
  </div>

  <div class="page-content">
    <!-- Panel Basic -->
    <div class="panel">
      <ul class="nav nav-tabs" id="userTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="divers-tab" data-toggle="tab" href="#divers" role="tab" aria-controls="divers" aria-selected="true">
              Buyers
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="companies-tab" data-toggle="tab" href="#companies" role="tab" aria-controls="companies" aria-selected="false">
              Vendors
            </a>
        </li>
    </ul>
      <header class="panel-heading">
        <div class="panel-actions"></div>
        <h3 class="panel-title"> </h3>
      </header>
      <div class="panel-body app-contacts">
        {{-- <div class="row">

          <div class="col-md-12 text-right d-flex justify-content-end">

            <div class="mb-15 d-flex justify-content-end">
              <div class="user-export-csv">
                <a href="{{ url('/admin/users/export/0') }}" class="btn btn-primary" id="exportattr">Download CSV</a>
              </div>

            </div>
          </div>
        </div> --}}
            <!-- Tab Content -->
            <div class="tab-content" id="userTabsContent">
              <!-- Divers Tab -->
              <div class="tab-pane fade show active" id="divers" role="tabpanel" aria-labelledby="divers-tab">
                  <div class="table-responsive">
                    <table class="table table-hover dataTable table-striped w-full" id="divers-table">
                      <thead>
                        <tr>
                          <th class="min-50">ID</th>
                          <th class="min-100">Profile Photo</th>
                          <th class="min-100">User Type</th>
                          <th class="min-50">Email</th>
                          <th class="min-100">First Name</th>
                          <th class="min-100">Last Name</th>
                          <th class="min-50">Mobile</th>
                  
                        </tr>
                      </thead>
                      <tbody>

                      </tbody>
                    </table>
                  </div>
              </div>

              <!-- Diving companies Tab -->

              <div class="tab-pane fade" id="companies" role="tabpanel" aria-labelledby="companies-tab">
                <div class="table-responsive mt-3">
                    <table class="table table-hover dataTable table-striped w-full" id="reps-table">
                        <thead>
                        <tr>
                            <th class="min-50">ID</th>
                            <th class="min-100">Logo</th>
                            <th class="min-50">Email</th>
                            <th class="min-100">Name</th>
                            <th class="min-100">Profile Link</th>

                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
              </div>

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
  </div>
</div>

@stop

@section('footer_script')
<script>
  // var dt;
  // $(document).ready(function() {
  //   dt = $('#data-table').DataTable({
  //     "aaSorting": [],
  //     "stateSave": false,
  //     "responsive": true,
  //     "paging": true,
  //     "lengthChange": true,
  //     "searching": true,
  //     "ordering": true,
  //     "info": true,
  //     "autoWidth": false,
  //     "iDisplayLength": 10,
  //     "language": {
  //             "emptyTable": "No data available in users management."
  //     },
  //     // "lengthMenu": [
  //     //   [10, 100, 150, 200, -1],
  //     //   [10, 100, 150, 200, "All"]
  //     // ],
  //     //  processing: true,
  //     // serverSide: true,
  //     ajax: {
  //       url: '{{ url("admin-api/users/getAllData") }}',
  //       type: 'GET',
  //       data: function(d) {
  //         d.gender = $('#userGender').val();
  //       }
  //     },
  //     columns: [
  //       {
  //         data: 'DT_RowIndex',
  //         name: 'DT_RowIndex',
  //         orderable: false,
  //         searchable: false
  //       },
  //       {
  //         data: 'photo',
  //         name: 'photo'
  //       },
  //       {
  //         data: 'userType',
  //         name: 'userType'
  //       },
  //       {
  //         data: 'firstName',
  //         name: 'firstName'
  //       },
  //       {
  //         data: 'lastName',
  //         name: 'lastName'
  //       },
  //       {
  //         data: 'email',
  //         name: 'email'
  //       },
  //       {
  //         data: 'mobilenumber',
  //         name: 'mobilenumber'
  //       },
  //       // {data: 'runningProgram', name: 'runningProgram'},
       
  //     ]
  //   });
  // });

      function initClientDataTable(selector) {
          return $(selector).DataTable({
              processing: true,
              serverSide: true,
              "language": {
                "emptyTable": "No data available in users management."
              },
              ajax: {
                  url: "{{ url('admin-api/users/getAllData') }}",
                  data: { type: 1 } // Buyers
              },
              columns: [
                  { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                  { data: 'photo', name: 'photo' },
                  { data: 'userType', name: 'userType' },
                  { data: 'email', name: 'email' },
                  { data: 'firstName', name: 'firstName' },
                  { data: 'lastName', name: 'lastName' },
                  { data: 'mobilenumber', name: 'mobilenumber' },

              ]
          });
      }

      function initRepDataTable(selector) {
          return $(selector).DataTable({
              processing: true,
              serverSide: true,
              "language": {
                "emptyTable": "No data available in users management."
              },
              ajax: {
                  url: "{{ url('admin-api/users/getAllData') }}",
                  data: { type: 2 } // Vendors
              },
              columns: [
                  { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                  { data: 'logo', name: 'logo' },
                  { data: 'email', name: 'email' },
                  { data: 'name', name: 'name' },
                  { data: 'profileLink', name: 'profileLink' },
              ]
          });
      }

      let clientsTable;
      let repsTable;

      $(document).ready(function () {
          clientsTable = initClientDataTable('#divers-table'); // Load clients initially

          $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
              const target = $(e.target).attr("href");

              if (target === '#divers' && !$.fn.DataTable.isDataTable('#divers-table')) {
                  clientsTable = initClientDataTable('#divers-table');
              } else if (target === '#companies' && !$.fn.DataTable.isDataTable('#reps-table')) {
                  repsTable = initRepDataTable('#reps-table');
              }
          });
      });

  

  function changefilter(val) {
    // Make an AJAX call here with the selected filter value
    dt.ajax.reload(null, false); // false to maintain current paging position
    $('#exportattr').attr('href', '{{ url("/admin/users/export/") }}/' + val);

  }
  
  function submitAction(action) {
      // alert(action);

        const reason = document.getElementById('reasonInput').value.trim();

        document.getElementById('actionType').value = action;
        const userId = document.getElementById('userId').value; 
        // document.getElementById('actionForm').submit();

        // Submit via AJAX or form action
        const formData = {
          reason: reason,
          action: action,
          user_id: userId 
        };

        // Example: AJAX POST
        fetch('storeAction', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
          console.log(data);
          showToasterMessage(data.message, 'success');
          setTimeout(() => {
                  window.location.href = data.redirect_url;
                }, 1000); 

          // if (data.redirect_url) {
          //     // window.location.href = data.redirect_url; // <-- JavaScript-based redirect
          //     setTimeout(() => {
          //         window.location.href = data.redirect_url;
          //       }, 1500); 
          //   } else {
          //     alert(data.message || 'Action performed successfully!');
          //   }
          // alert(data.message || 'Action performed successfully!');
          // return redirect()->route('users.index')->with('success', data.message);

        })
        .catch(error => {
          console.error('Error:', error);
        });
      }

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

{{-- <script>
  $(document).on('click', 'tr[data-url]', function(e) {
        const url = $(this).data('url');
        if (url) {
            window.location.href = url;
        }
    
  });
</script> --}}
@stop