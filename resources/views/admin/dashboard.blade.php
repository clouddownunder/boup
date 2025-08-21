@extends('admin.layouts.main')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="page">
  <div class="page-header">
    <h1 class="page-title">{{ __('admin.dashboard-page-title') }}</h1>
  </div>
  <div class="page-content container-fluid">
    {{-- <form id="filterForm" action="{{ route('filter') }}" method="POST">
      @csrf --}}
      <div class="container-fuild mt-10 custom-section-class">
        <div class="sec-title-wp row p-3">
          <div class="col-xl-12 col-lg-12">
            <h3 class="section-title">Users</h3>
          </div>
        </div>
        <div class="container-fluid p-3"  >
          <div class="row" >
            <div class="col-sm-3">
              <div class="form-group">
                <select name="userRange" id="globalRange" class="form-control globalRange userGlobalRange" required>
                  <option value="all">All</option>
                  <option value="daily" {{ $userRange == "daily" ? "selected" : "" }} >Daily</option>
                  <option value="weekly" {{ $userRange == "weekly" ? "selected" : "" }}>Weekly</option>
                  <option value="monthly" {{ $userRange == "monthly" ? "selected" : "" }}>Monthly</option>
                  <option value="quarterly" {{ $userRange == "quarterly" ? "selected" : "" }}>Quarterly</option>
                  <option value="yearly" {{ $userRange == "yearly" ? "selected" : "" }}>Yearly</option>
                  <option value="custom" {{ $userRange == "custom" ? "selected" : "" }}>Custom Date A - B </option>
                  <option value="todate" {{ $userRange == "todate" ? "selected" : "" }}>To Date</option>
                </select>
              </div>
            </div>
            {{-- <div class="col-sm-3">
              <div class="form-group">
                <select name="userAge" id="userAge" class="form-control userAge">
                    <option value="" {{ $userAge == "" ? "selected" : "" }}>User Age</option>
                    <option value="all" {{ $userAge == "all" ? "selected" : "" }}>All</option>
                    <option value="19_24" {{ $userAge == "19_24" ? "selected" : "" }}>19 - 24</option>
                    <option value="25_34" {{ $userAge == "25_34" ? "selected" : "" }}>25 - 34</option>
                    <option value="35_45" {{ $userAge == "35_45" ? "selected" : "" }}>35 - 45</option>
                    <option value="45_plus" {{ $userAge == "45_plus" ? "selected" : "" }}>45+</option>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <select name="userGender" id="userGender" class="form-control userGender">
                    <option value="" {{ $userGender == "" ? "selected" : "" }}>Gender</option>
                    <option value="all" {{ $userGender == "all" ? "selected" : "" }}>All</option>
                    <option value="{{ User::GENDER_MALE }}" {{ $userGender == User::GENDER_MALE ? "selected" : "" }}>Male</option>
                    <option value="{{ User::GENDER_FEMALE }}" {{ $userGender == User::GENDER_FEMALE ? "selected" : "" }}>Female</option>
                    <option value="{{ User::GENDER_OTHER }}" {{ $userGender == User::GENDER_OTHER ? "selected" : "" }}>Other</option>
                </select>
              </div>
            </div> --}}
            <div class="col-sm-9">
            </div>
            <div class="col-sm-3 userGlobalRangecustom" style="display: {{ $userRange == "custom" ? "" : "none" }};">
              <div class="form-group">
                <label for="">Start Date</label>
                <input type="date" id="userstartDate" name="userstartDate" class="form-control" value="{{ $userstartDate ? $userstartDate : "" }}">
              </div>
            </div>
            <div class="col-sm-3 userGlobalRangecustom" style="display: {{ $userRange == "custom" ? "" : "none" }};">
              <div class="form-group">
                <label for="">End Date</label>
                <input type="date" id="userendDate" name="userendDate" class="form-control" value="{{ $userendDate ? $userendDate : "" }}">
                <span class="user-error-msg text-danger" style="display:none">End Date Must be equal or greater than Start Date</span>
              </div>
            </div>
            <div class="col-sm-3 usertodate" style="display: {{ $userRange == "todate" ? "" : "none" }};">
              <div class="form-group">
                <label for="">End Date</label>
                <input type="date" id="userTodate" name="userTodate" class="form-control" value="{{ $userTodate ?? "" }}">
              </div>
            </div>
          </div>
        </div>
        <div class="row p-3">
        <div class="col-xl-12 col-lg-12">
            <div class="row" id="users-container">
              @foreach($boxes['users'] as $key => $value)
                <div class="col-lg-3">
                  <div class="card card-block p-25 rotate-color-combo">
                    <div class="counter counter-lg">
                      <span class="counter-number user-counter">{{ $value['value']}}</span>
                      <div class="counter-label text-uppercase">{{ $value['text']}}</div>
                    </div>
                  </div>
                </div>
              @endforeach
            
            </div>
          </div>
        </div>
      </div>
      {{-- <div class="container-fuild mt-10 custom-section-class">
        <div class="sec-title-wp row p-3">
          <div class="col-xl-12 col-lg-12">
            <h3 class="section-title">Revenue</h3>
          </div>
        </div>
        <div class="container-fluid p-3"  >
          <div class="row" >
            <div class="col-sm-3">
              <div class="form-group">
                <select name="subscriptionType" id="subscriptionType" class="form-control subscriptionType">

                    <option value="Monthly" {{ $subscriptionType =="Monthly" ? "selected" : "" }} selected>Monthly</option>
                    <option value="Yearly" {{ $subscriptionType == "Yearly" ? "selected" : "" }}>Yearly</option>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <select name="subscriptionRange" id="globalRange" class="form-control globalRange subscriptionGlobalRange" required>
                  <option value="all">All</option>
                  <option value="daily" {{ $subscriptionRange == "daily" ? "selected" : "" }} >Daily</option>
                  <option value="weekly" {{ $subscriptionRange == "weekly" ? "selected" : "" }}>Weekly</option>
                  <option value="monthly" {{ $subscriptionRange == "monthly" ? "selected" : "" }}>Monthly</option>
                  <option value="quarterly" {{ $subscriptionRange == "quarterly" ? "selected" : "" }}>Quarterly</option>
                  <option value="yearly" {{ $subscriptionRange == "yearly" ? "selected" : "" }}>Yearly</option>
                  <option value="custom" {{ $subscriptionRange == "custom" ? "selected" : "" }}>Custom Date A - B </option>
                  <option value="todate" {{ $subscriptionRange == "todate" ? "selected" : "" }}>To Date</option>
                </select>
              </div>
            </div>
            <div class="col-sm-6">
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <select name="subscriptionGender" id="subscriptionGender" class="form-control subscriptionGender">
                    <option value="" {{ $subscriptionGender == "" ? "selected" : "" }}>Gender</option>
                    <option value="all" {{ $subscriptionGender == "all" ? "selected" : "" }}>All</option>
                    <option value="{{ User::GENDER_MALE }}" {{ $subscriptionGender == User::GENDER_MALE ? "selected" : "" }}>Male</option>
                    <option value="{{ User::GENDER_FEMALE }}" {{ $subscriptionGender == User::GENDER_FEMALE ? "selected" : "" }}>Female</option>
                    <option value="{{ User::GENDER_OTHER }}" {{ $subscriptionGender == User::GENDER_OTHER ? "selected" : "" }}>Other</option>
                </select>
              </div>
            </div>
            
            <div class="col-sm-3 subscriptionPlanDropdown" style="display: {{ $subscriptionType == "paid" ? "" : "none" }};">
              <div class="form-group">
                <select name="subscriptionPlan" id="subscriptionPlan" class="form-control subscriptionPlan">
                    <option value="" {{ $subscriptionPlan == "" ? "selected" : "" }}>Subscription Plan</option>
                    <option value="1" {{ $subscriptionPlan =="1" ? "selected" : "" }}>1 Month</option>
                    <option value="3" {{ $subscriptionPlan =="3" ? "selected" : "" }}>3 Month</option>
                    <option value="6" {{ $subscriptionPlan =="6" ? "selected" : "" }}>6 Month</option>
                    <option value="12" {{ $subscriptionPlan =="12" ? "selected" : "" }}>12 Month</option>
                </select>
                <span class="subscription-plan-error-msg text-danger" style="display:none">Please select subscription plan</span>
              </div>
            </div>
            <div class="col-sm-3 subscriptionGlobalRangecustome" style="display: {{ $subscriptionRange == "custom" ? "" : "none" }};">
              <div class="form-group">
                <label for="">Start Date</label>
                <input type="date" id="subscriptionstartDate" name="subscriptionstartDate" class="form-control" value="{{ $subscriptionstartDate ? $subscriptionstartDate : "" }}">
              </div>
            </div>
            <div class="col-sm-3 subscriptionGlobalRangecustome" style="display: {{ $subscriptionRange == "custom" ? "" : "none" }};">
              <div class="form-group">
                <label for="">End Date</label>
                <input type="date" id="subscriptionendDate" name="subscriptionendDate" class="form-control" value="{{ $subscriptionendDate ? $subscriptionendDate : "" }}">
                <span class="subscription-error-msg text-danger" style="display:none">End Date Must be equal or greater than Start Date</span>
              </div>
            </div>
            <div class="col-sm-3 subscriptiontodate" style="display: {{ $subscriptionRange == "todate" ? "" : "none" }};">
              <div class="form-group">
                <label for="">End Date</label>
                <input type="date" id="subscriptionTodate" name="subscriptionTodate" class="form-control" value="{{ $subscriptionTodate ?? "" }}">
              </div>
            </div>
          </div>
        </div>
        <div class="row p-3">
        <div class="col-xl-12 col-lg-12">
            <div class="row">
              @foreach($boxes['subscription'] as $key => $value)
                <div class="col-lg-3">
                  <div class="card card-block p-25 rotate-color-combo">
                    <div class="counter counter-lg">
                      <span class="counter-number user-counter">{{ $value['value']}}</span>
                      <div class="counter-label text-uppercase">{{ $value['text']}}</div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div> --}}
      {{-- <div class="container-fuild mt-10 custom-section-class">
        <div class="sec-title-wp row p-3">
          <div class="col-xl-12 col-lg-12">
            <h3 class="section-title">Connections</h3>
          </div>
        </div>
        <div class="container-fluid p-3"  >
          <div class="row" >
            <div class="col-sm-3">
              <div class="form-group">
                <select name="connectionRange" id="globalRange" class="form-control globalRange connectionGlobalRange" required>
                  <option value="all">All</option>
                  <option value="daily" {{ $connectionRange == "daily" ? "selected" : "" }} >Daily</option>
                  <option value="weekly" {{ $connectionRange == "weekly" ? "selected" : "" }}>Weekly</option>
                  <option value="monthly" {{ $connectionRange == "monthly" ? "selected" : "" }}>Monthly</option>
                  <option value="quarterly" {{ $connectionRange == "quarterly" ? "selected" : "" }}>Quarterly</option>
                  <option value="yearly" {{ $connectionRange == "yearly" ? "selected" : "" }}>Yearly</option>
                  <option value="custom" {{ $connectionRange == "custom" ? "selected" : "" }}>Custom Date A - B </option>
                  <option value="todate" {{ $connectionRange == "todate" ? "selected" : "" }}>To Date</option>
                </select>
              </div>
            </div>
            <div class="col-sm-9">
            </div>
            <div class="col-sm-3 connectionGlobalRangecustome" style="display: {{ $connectionRange == "custom" ? "" : "none" }};">
              <div class="form-group">
                <label for="">Start Date</label>
                <input type="date" id="connectionstartDate" name="connectionstartDate" class="form-control" value="{{ $connectionstartDate ? $connectionstartDate : "" }}">
              </div>
            </div>
            <div class="col-sm-3 connectionGlobalRangecustome" style="display: {{ $connectionRange == "custom" ? "" : "none" }};">
              <div class="form-group">
                <label for="">End Date</label>
                <input type="date" id="connectionendDate" name="connectionendDate" class="form-control" value="{{ $connectionendDate ? $connectionendDate : "" }}">
                <span class="connection-error-msg text-danger" style="display:none">End Date Must be equal or greater than Start Date</span>
              </div>
            </div>
            <div class="col-sm-3 connectiontodate" style="display: {{ $connectionRange == "todate" ? "" : "none" }};">
              <div class="form-group">
                <label for="">End Date</label>
                <input type="date" id="connectionToDate" name="connectionToDate" class="form-control" value="{{ $connectionToDate ?? "" }}">
              </div>
            </div>
          </div>
        </div>
        <div class="row p-3">
          <div class="col-xl-12 col-lg-12">
            <div class="row">
              @foreach($boxes['connections'] as $key => $value)
                <div class="col-lg-3">
                  <div class="card card-block p-25 rotate-color-combo">
                    <div class="counter counter-lg">
                      <span class="counter-number user-counter">{{ $value['value']}}</span>
                      <div class="counter-label text-uppercase">{{ $value['text']}}</div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
      <div class="container-fuild mt-10 custom-section-class">
        <div class="sec-title-wp row p-3">
          <div class="col-xl-12 col-lg-12">
            <h3 class="section-title">Other</h3>
          </div>
        </div>
        <div class="container-fluid p-3"  >
          <div class="row" >
            <div class="col-sm-3">
              <div class="form-group">
                <select name="otherRange" id="globalRange" class="form-control globalRange otherGlobalRange" required>
                  <option value="all">All</option>
                  <option value="daily" {{ $otherRange == "daily" ? "selected" : "" }} >Daily</option>
                  <option value="weekly" {{ $otherRange == "weekly" ? "selected" : "" }}>Weekly</option>
                  <option value="monthly" {{ $otherRange == "monthly" ? "selected" : "" }}>Monthly</option>
                  <option value="quarterly" {{ $otherRange == "quarterly" ? "selected" : "" }}>Quarterly</option>
                  <option value="yearly" {{ $otherRange == "yearly" ? "selected" : "" }}>Yearly</option>
                  <option value="custom" {{ $otherRange == "custom" ? "selected" : "" }}>Custom Date A - B </option>
                  <option value="todate" {{ $otherRange == "todate" ? "selected" : "" }}>To Date</option>
                </select>
              </div>
            </div>
            <div class="col-sm-9">
            </div>
            <div class="col-sm-3 otherGlobalRangecustome" style="display: {{ $otherRange == "custom" ? "" : "none" }};">
              <div class="form-group">
                <label for="">Start Date</label>
                <input type="date" id="otherstartDate" name="otherstartDate" class="form-control" value="{{ $otherstartDate ? $otherstartDate : "" }}">
              </div>
            </div>
            <div class="col-sm-3 otherGlobalRangecustome" style="display: {{ $otherRange == "custom" ? "" : "none" }};">
              <div class="form-group">
                <label for="">End Date</label>
                <input type="date" id="otherendDate" name="otherendDate" class="form-control" value="{{ $otherendDate ? $otherendDate : "" }}">
                <span class="other-error-msg text-danger" style="display:none">End Date Must be equal or greater than Start Date</span>
              </div>
            </div>
            <div class="col-sm-3 othertodate" style="display: {{ $otherRange == "todate" ? "" : "none" }};">
              <div class="form-group">
                <label for="">End Date</label>
                <input type="date" id="otherToDate" name="otherToDate" class="form-control" value="{{ $otherToDate ?? "" }}">
              </div>
            </div>
          </div>
        </div>
        <div class="row p-3">
          <div class="col-xl-12 col-lg-12">
            <div class="row">
              @foreach($boxes['other'] as $key => $value)
                <div class="col-lg-3">
                  <div class="card card-block p-25 rotate-color-combo">
                    <div class="counter counter-lg">
                      <span class="counter-number user-counter">{{ $value['value']}}</span>
                      <div class="counter-label text-uppercase">{{ $value['text']}}</div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div> --}}
    {{-- </form> --}}
  </div>
</div>
@stop

@section('footer_script')
<script>
    $(document).ready(function(){
      checkValidation()
      function checkValidation() {
        var userStartDate = $("#userstartDate").val();
        var userEndDate = $("#userendDate").val();
        if (userStartDate != "" && userEndDate != "") {
          if (new Date(userStartDate).getTime() >= new Date(userEndDate).getTime()) {
            $(".user-error-msg").show();
          } else {
            $(".user-error-msg").hide();
          }
        }
        var otherStartDate = $("#otherstartDate").val();
        var otherEndDate = $("#otherendDate").val();
        if (otherStartDate != "" && otherEndDate != "") {
          if (new Date(otherStartDate).getTime() >= new Date(otherEndDate).getTime()) {
            $(".other-error-msg").show();
          } else {
            $(".other-error-msg").hide();
          }
        }
        var connectionStartDate = $("#connectionstartDate").val();
        var connectionEndDate = $("#connectionendDate").val();
        if (connectionStartDate != "" && connectionEndDate != "") {
          if (new Date(connectionStartDate).getTime() >= new Date(connectionEndDate).getTime()) {
            $(".connection-error-msg").show();
          } else {
            $(".connection-error-msg").hide();
          }
        }
        var subscriptionStartDate = $("#subscriptionstartDate").val();
        var subscriptionEndDate = $("#subscriptionendDate").val();
        if (subscriptionStartDate != "" && subscriptionEndDate != "") {
          if (new Date(subscriptionStartDate).getTime() >= new Date(subscriptionEndDate).getTime()) {
            $(".subscription-error-msg").show();
          } else {
            $(".subscription-error-msg").hide();
          }
        }
      }
      $("#otherstartDate, #otherendDate").change(function(){
        var otherStartDate = $("#otherstartDate").val();
        var otherEndDate = $("#otherendDate").val();
        if (otherStartDate != "" && otherEndDate != "") {
          if (new Date(otherStartDate).getTime() >= new Date(otherEndDate).getTime()) {
              $(".other-error-msg").show();
          } else {
            $(".other-error-msg").hide();
            submitFilterForm()
          }
        }
      })
      $("#connectionstartDate, #connectionendDate").change(function(){
        var connectionStartDate = $("#connectionstartDate").val();
        var connectionEndDate = $("#connectionendDate").val();
        if (connectionStartDate != "" && connectionEndDate != "") {
          if (new Date(connectionStartDate).getTime() >= new Date(connectionEndDate).getTime()) {
              $(".connection-error-msg").show();
          } else {
            $(".connection-error-msg").hide();
            submitFilterForm()
          }
        }
      })
      $("#subscriptionstartDate, #subscriptionendDate").change(function(){
        var subscriptionStartDate = $("#subscriptionstartDate").val();
        var subscriptionEndDate = $("#subscriptionendDate").val();
        if (subscriptionStartDate != "" && subscriptionEndDate != "") {
          if (new Date(subscriptionStartDate).getTime() >= new Date(subscriptionEndDate).getTime()) {
              $(".subscription-error-msg").show();
          } else {
            $(".subscription-error-msg").hide();
            submitFilterForm()
          }
        }
      })
      $("#userstartDate, #userendDate").change(function(){
        var userStartDate = $("#userstartDate").val();
        var userEndDate = $("#userendDate").val();
        if (userStartDate != "" && userEndDate != "") {
          if (new Date(userStartDate).getTime() >= new Date(userEndDate).getTime()) {
            $(".user-error-msg").show();
          } else {
            $(".user-error-msg").hide();
            submitFilterForm()
          }
        }
      })
      $("#subscriptionGender, #subscriptionType").change(function(){
            submitFilterForm()
      })
      $("#userTodate, #otherToDate,#connectionToDate, #subscriptionToDate, #subscriptionPlan").change(function(){
        if (($('#userTodate').val() != "") || ($('#connectionToDate').val() != "") || ($('#otherToDate').val() != "") || ($('#subscriptionToDate').val() != "") || ($('#subscriptionPlan').val() != "")) {
          submitFilterForm()
        }
      });

      $(".globalRange").change(function(){
        if ($(this).val()!="custom" && $(this).val() != "todate") {
          submitFilterForm();
        } else {
          if ($(this).hasClass('userGlobalRange')){
            className = 'userGlobalRangecustome'
            todateClassName = 'usertodate'
          }
          if ($(this).hasClass('otherGlobalRange')){
            className = 'otherGlobalRangecustome'
            todateClassName = 'othertodate'
          }
          if ($(this).hasClass('connectionGlobalRange')){
            className = 'connectionGlobalRangecustome'
            todateClassName = 'connectiontodate'
          }
          if ($(this).hasClass('subscriptionGlobalRange')){
            className = 'subscriptionGlobalRangecustome'
            todateClassName = 'subscriptiontodate'
          }
          if($(this).val()=="custom") {
            $("."+className).show();
          } else {
            $("."+className).hide();
          }
          if($(this).val()=="todate") {
            $("."+todateClassName).show();
          } else {
            $("."+todateClassName).hide();
          }
        }
      });
      $(".subscriptionType").change(function(){
        if ($(this).val()!="paid") {
          $(".subscriptionPlanDropdown").hide();
        } else {
          $(".subscriptionPlanDropdown").show();
        }
      });

      // function submitFilterForm() {
      //   $( "#filterForm" ).submit();
      // }
       // Range change handlers - FIXED VERSION
       $(".globalRange").change(function() {
                var type = $(this).hasClass('userGlobalRange') ? 'user' : 'order';
                var value = $(this).val();
                // alert(value);
                // Always toggle date fields first
                toggleDateFields(type, value);

                // Then submit filter if it's not custom or todate
                if (value != "custom" && value != "todate") {
                    submitAjaxFilter(type);
                }
            });

            // FIXED toggleDateFields function
            function toggleDateFields(type, value) {
                var customClass = "." + type + "GlobalRangecustom";
                var todateClass = "." + type + "todate";

                // Hide all date fields first
                $(customClass).hide();
                $(todateClass).hide();

                // Show appropriate fields based on selection
                if (value == "custom") {
                    $(customClass).show();
                } else if (value == "todate") {
                    $(todateClass).show();
                }
                // For all other values (all, daily, weekly, monthly, quarterly, yearly),
                // both fields remain hidden
            }

      function submitFilterForm() {
          var data = {};


          data.userRange = $("#globalRange").val();
          data.userstartDate = $("#userstartDate").val();
          data.userendDate = $("#userendDate").val();
          data.userTodate = $("#userTodate").val();
          console.log(data);

          $.ajax({
              url: "{{ route('filter') }}",
              type: 'POST',
              data: data,
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              success: function(response) {
                  if (response) {                      
                      updateBoxes(response.boxes);
                  }
              },
              error: function(xhr, status, error) {
                  alert('something went wrong');
              }
          });
      }

      function updateBoxes(boxes) {

          if (boxes.users) {
              updateContainer('#users-container', boxes.users, 'user-counter');
          }
      }

      function updateContainer(containerId, data, counterClass) {
          // Select all counter elements within the container
          var counters = $(containerId).find('.' + counterClass);

          // Update each counter's value based on the response data
          $.each(data, function(index, value) {
              if (counters[index]) {
                  $(counters[index]).text(value.value);
              }
          });
      }
    });
</script>
@stop
