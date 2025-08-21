@extends('admin.layouts.main')
@section('content')

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        td label {
            white-space: nowrap;
        }
    </style>
    <!-- Page -->
    <div class="page">
        <div class="page-header">
          <div class="col-auto">
          </div>
          <h1 class="page-title">
              {{-- <a href="#" class="back-icon d-flex align-items-center text-decoration-none text-black">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M15 8a.75.75 0 0 1-.75.75H3.56l4.22 4.22a.75.75 0 1 1-1.06 1.06l-5.5-5.5a.75.75 0 0 1 0-1.06l5.5-5.5a.75.75 0 0 1 1.06 1.06L3.56 7.25H14.25A.75.75 0 0 1 15 8z"></path>
                </svg>
              </a> --}}
              @if ($userInfo->user_type == 3)
                Diving Company Details
              @else
                Diver Details
              @endif
            </h1>
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
                </header>
                <div class="panel-body app-contacts">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <div class="mb-15">
                            </div>
                        </div>
                    </div>

                @if ($userInfo->user_type == 3)
                  <section class="panel">
                    <div class="card card-primary card-outline card-tabs card-font">
                        <div class="card-body">
                            <div class="tab-content">
                                <div id="view" class="tab-pane fade in active show"><br>
                                    <div class="text-left mb-4">

                                      @if($userInfo->business_logo)
                                        <img width="100" src="{{asset('storage/business/logo/' . $userInfo->business_logo)}}">
                                      @else
                                        <img width="100" src="{{asset('assets/images/businesslogo.png')}}">    
                                      @endif

                                    </div>

                                    
                                    <div class="form-row">
                                        <div class="form-group col-md-12 col-12">
                                            <table class="table table-hover">
                                              <tr>
                                                <td width="25%"><label class="text-bold">Email</label></td>
                                                <td>{{$userInfo->email ?? 'N/A'}}</td>
                                              </tr>
                                              <tr>
                                                <td width="25%"><label class="text-bold">Name</label></td>
                                                <td>{{$userInfo->business_name ?? 'N/A'}}</td>
                                              </tr>
                                
                                              <tr>
                                                <td width="25%"><label class="text-bold">Profile Link</label></td>
                                                <td>{{$userInfo->business_profile_link ?? 'N/A'}}</td>
                                              </tr>
                                              <tr>
                                                <td width="25%"><label class="text-bold">Setup Profile</label></td>
                                                <td>
                                                  @if ($userInfo->is_setup_profile == 1)
                                                    Done
                                                  @else
                                                    Pending
                                                  @endif
                                                </td>
                                              </tr>
                                              <tr>
                                                <td width="25%"><label class="text-bold">Registered On</label></td>
                                                <td>@empty($userInfo->created_at) N/A @else {{ fetchDateFormate($userInfo->created_at) }} @endEmpty</td>
                                              </tr> 
                                              <tr>
                                                <td width="25%"><label class="text-bold">Status</label></td>
                                                @if ($userInfo->status == 1)
                                                    <td><span class="badge badge-danger">Block</span></td> 
                                                @elseif ($userInfo->status == 2)
                                                  <td><span class="badge badge-danger">Suspend</span></td> 
                                                @else
                                                  <td><span class="badge badge-success">Active</span></td> 
                                                @endif
                                              </tr> 
                                              @if ($userInfo->status != 2)
                                                <tr>
                                                  <td width="25%"><label class="text-bold">Action</label></td>
                                                  <td>   
                                                    <form id="actionForm">
                                                        <input type="hidden" id="userId" value="{{ $userInfo->id }}">
                                                        <input type="hidden" name="actionType" id="actionType">
                                                        @if ($userInfo->status == 1)
                                                        <input type="hidden" id="reasonInput" class="reasonInput" placeholder="Please enter reason">
                                                          <a href="javascript:void(0)" class="btn btn-primary m-1" onclick="submitAction('unblock')">
                                                            <span>Unblock</span>
                                                          </a>
                                                        @else
                                                          
                                
                                                          
                                                        
                                                          <a href="javascript:void(0)" class="btn btn-danger" id="blockDetail" >
                                                            
                                                            <span>Block</span>
                                                          </a>
                                
                                                          <a href="javascript:void(0)" class="btn btn-danger" id="suspendDetail" >
                                                            <span>Suspend</span>
                                                          </a>
                                                        @endif
                                                    </form>
                                                  </td>
                                                </tr> 
                                              @else
                                                <tr>
                                                  <td width="25%"><label class="text-bold">Suspend end Date</label></td>
                                                  <td>@empty($userInfo->suspend_end_date) N/A @else {{ fetchDateFormate($userInfo->suspend_end_date) }} @endEmpty</td>
                                                </tr> 
                                                <tr>
                                                  <td width="25%"><label class="text-bold">Action</label></td>
                                                  <td>   
                                                    <form id="actionForm">
                                                        <input type="hidden" id="userId" value="{{ $userInfo->id }}">
                                                        <input type="hidden" name="actionType" id="actionType">
                                
                                                        @if ($userInfo->status == 2)
                                                          <input type="hidden" id="reasonInput" class="reasonInput" placeholder="Please enter reason">
                                                            <a href="javascript:void(0)" class="btn btn-primary   m-1" onclick="submitAction('unsuspend')">
                                                              <span>Revoke</span>
                                                            </a>
                                                        @endif
                                                    </form>
                                                  </td>
                                                </tr> 
                                              
                                              @endif
                                              <tr>
                                                <td width="25%"><label class="text-bold">Delete User</label></td>
                                                <td><a href="javascript:void(0)" class="btn btn-danger" id="deleteDetails" >
                                                          <span>Delete</span></a>
                                                </td> 

                                              </tr> 
                                              <tr class="deviceInfo">
                                                <td width="25%"><label class="text-bold">Device Type</label></td>
                                                @if($userInfo->device_type == 0)
                                                <td>Web</td>
                                                @elseif($userInfo->device_type == 1)
                                                <td>iOS</td>
                                                @elseif($userInfo->device_type == 2)
                                                <td>Android</td>
                                                @endif
                                
                                              </tr>
                                              {{-- <tr class="deviceInfo">
                                                <td width="25%"><label class="text-bold">App Version</label></td>
                                                <td>{{$user->app_version ?? 'N/A'}}</td>
                                              </tr>
                                              <tr class="deviceInfo">
                                                <td width="25%"><label class="text-bold">OS Version</label></td>
                                                <td>{{$user->os_version ?? 'N/A'}}</td>
                                              </tr>
                                              <tr class="deviceInfo">
                                                <td width="25%"><label class="text-bold">Device Name</label></td>
                                                <td>{{$user->device_name ?? 'N/A'}}</td>
                                              </tr> --}}
                                                <tr>
                                                  @if($show_device_info == "1")
                                                  <td colspan="2" class="text-right">
                                                    <a href="javascript:void(0)" role="button" id="deviceInfobtn">Device Info</a>
                                                  </td>
                                                </tr>
                                                @endif
                                            </table>
                                          
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </section>
                @else
                  <section class="panel">
                      <div class="card card-primary card-outline card-tabs card-font">
                          <div class="card-body">
                              <div class="tab-content">
                                  <div id="view" class="tab-pane fade in active show">
                                    <div class="row">
                                      <div class="col-md-8">
                                    
                                        <div class="text-left mb-4">
                                          @if($userInfo->profile_pic)
                                            <img width="100" src="{{asset('storage/profileImg/' . $userInfo->profile_pic)}}">
                                          @else
                                            <img width="100" src="{{asset('images/default_image.png')}}">    
                                          @endif
                                            {{-- <img src="{{asset('storage/profileImg/' . $userInfo->profile_pic)}}" width="100px" alt=""> --}}
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="text-right mb-4">
  
                                          <div class="chk-avail-box">
                                            <div class="chk-avail-wrap">
                                                <div class="chk-avail-link d-flex flex-wrap fw-medium text-white"
                                                      data-toggle="modal" data-target="#modal-long" aria-controls="CheckAvail">
                                                    Check Availability
                                                </div>
                                                {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-long">long content</button> --}}
                                            </div>
                                          </div>
                                        </div>
                                        
                                      </div>
                                    </div>

                                      <div class="form-row">
                                          <div class="form-group col-md-12 col-12">
                                              <table class="table table-hover">
                                                  <tr>
                                                      <td width="25%"><label class="text-bold">User Type</label></td>
                                                      <td> 
                                                        @if ($userInfo->user_type == 1) Commercial Diver
                                                        @elseif ($userInfo->user_type == 2) Diver Supervisor
                                                        @else N/A
                                                        @endif
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                      <td width="25%"><label class="text-bold">Email</label></td>
                                                      <td>{{$userInfo->email ?? 'N/A'}}</td>
                                                  </tr>
                                                  <tr>
                                                      <td width="25%"><label class="text-bold">First Name</label></td>
                                                      <td>{{$userInfo->first_name ?? 'N/A'}}</td>
                                                  </tr>
                                                  <tr>
                                                      <td width="25%"><label class="text-bold">Last Name</label></td>
                                                      <td>{{$userInfo->last_name ?? 'N/A'}}</td>
                                                  </tr>
                                                  <tr>
                                                      <td width="25%"><label class="text-bold">Mobile</label></td>
                                                      <td>+61 {{$userInfo->mobile_no ?? 'N/A'}}</td>
                                                  </tr>
                                                  <tr>
                                                      <td width="25%"><label class="text-bold">Gender</label></td>
                                                      <td> 
                                                        @if($userInfo->gender == 1)
                                                          Male
                                                        @elseif ($userInfo->gender == 2)
                                                          Female
                                                        @else
                                                          N/A
                                                        @endif
                                                    </td>
                                                  </tr>
                                                  <tr>
                                                      <td width="25%"><label class="text-bold">Suburb</label></td>
                                                      <td>{{$userInfo->suburb ?? 'N/A'}}</td>
                                                  </tr>
                                                  <tr>
                                                    <td width="25%"><label class="text-bold">Interested State</label></td>
                                                    <td>{{$userInfo->interested_state ?? 'N/A'}}</td>
                                                  </tr>
                                    
                                                  <tr>
                                                    <td width="25%"><label class="text-bold">Setup Profile</label></td>
                                                    <td>
                                                      @if ($userInfo->is_setup_profile == 1)
                                                        Done
                                                      @else
                                                        Pending
                                                      @endif
                                                  </td>
                                                  </tr>
                                    
                                                  <tr>
                                                    <td width="25%"><label class="text-bold">Registered On</label></td>
                                                    <td>@empty($userInfo->created_at) N/A @else {{ fetchDateFormate($userInfo->created_at) }} @endEmpty</td>
                                                  </tr> 
                                                  <tr>
                                                    <td width="25%"><label class="text-bold">Status</label></td>
                                                    @if ($userInfo->status == 1)
                                                        <td><span class="badge badge-danger">Block</span></td> 
                                                    @elseif ($userInfo->status == 2)
                                                      <td><span class="badge badge-danger">Suspend</span></td> 
                                                    @else
                                                      <td><span class="badge badge-success">Active</span></td> 
                                                    @endif
                                                  </tr> 
                                                  @if ($userInfo->status != 2)
                                                    <tr>
                                                      <td width="25%"><label class="text-bold">Action</label></td>
                                                      <td>   
                                                        <form id="actionForm">
                                                            <input type="hidden" id="userId" value="{{ $userInfo->id }}">
                                                            <input type="hidden" name="actionType" id="actionType">
                                                            @if ($userInfo->status == 1)
                                                            <input type="hidden" id="reasonInput" class="reasonInput" placeholder="Please enter reason">
                                                              <a href="javascript:void(0)" class="btn btn-primary m-1" onclick="submitAction('unblock')">
                                                                <span>Unblock</span>
                                                              </a>
                                                            @else
                                                              
                                    
                                                              <a href="javascript:void(0)" class="btn btn-danger" id="blockDetail" >
                                                                
                                                                <span>Block</span>
                                                              </a>
                                                              
                                    
                                                              
                                                              <a href="javascript:void(0)" class="btn btn-danger" id="suspendDetail" >
                                                                <span>Suspend</span>
                                                              </a>
                                                            @endif
                                                        </form>
                                                      </td>
                                                    </tr> 
                                                  @else
                                                    <tr>
                                                      <td width="25%"><label class="text-bold">Suspend end Date</label></td>
                                                      <td>@empty($userInfo->suspend_end_date) N/A @else {{ fetchDateFormate($userInfo->suspend_end_date) }} @endEmpty</td>
                                                    </tr> 
                                                    <tr>
                                                      <td width="25%"><label class="text-bold">Action</label></td>
                                                      <td>   
                                                        <form id="actionForm">
                                                            <input type="hidden" id="userId" value="{{ $userInfo->id }}">
                                                            <input type="hidden" name="actionType" id="actionType">
                                    
                                                            @if ($userInfo->status == 2)
                                                              <input type="hidden" id="reasonInput" class="reasonInput" placeholder="Please enter reason">
                                                                <a href="javascript:void(0)" class="btn btn-primary   m-1" onclick="submitAction('unsuspend')">
                                                                  <span>Revoke</span>
                                                                </a>
                                                            @endif
                                                        </form>
                                                      </td>
                                                    </tr> 
                                                  
                                                  @endif
                                    
                                                  <tr>
                                                    <td width="25%"><label class="text-bold">Delete User</label></td>
                                                    <td><a href="javascript:void(0)" class="btn btn-danger" id="deleteDetails" >
                                                              <span>Delete</span></a>
                                                    </td> 

                                                  </tr> 
                                                  <tr class="deviceInfo">
                                                    <td width="25%"><label class="text-bold">Device Type</label></td>
                                                    @if($userInfo->device_type == 0)
                                                    <td>Web</td>
                                                    @elseif($userInfo->device_type == 1)
                                                    <td>iOS</td>
                                                    @elseif($userInfo->device_type == 2)
                                                    <td>Android</td>
                                                    @endif
                                    
                                                  </tr>
                                                  <tr class="deviceInfo">
                                                    <td width="25%"><label class="text-bold">App Version</label></td>
                                                    <td>{{$userInfo->app_version ?? 'N/A'}}</td>
                                                  </tr>
                                                  <tr class="deviceInfo">
                                                    <td width="25%"><label class="text-bold">OS Version</label></td>
                                                    <td>{{$userInfo->os_version ?? 'N/A'}}</td>
                                                  </tr>
                                                  <tr class="deviceInfo">
                                                    <td width="25%"><label class="text-bold">Device Name</label></td>
                                                    <td>{{$userInfo->device_name ?? 'N/A'}}</td>
                                                  </tr>
                                                    <tr>
                                                      @if($show_device_info == "1")
                                                      <td colspan="2" class="text-right">
                                                        <a href="javascript:void(0)" role="button" id="deviceInfobtn">Device Info</a>
                                                      </td>
                                                    </tr>
                                                    @endif
                                              </table>
                                             
                                          </div>
                                      </div>

                                      @if ($industryCount > 0)
                                          
                                        <div class="bx bg-white px-0">
                                          <div class="bx-tl">
                                              <div class="bx-tlt fw-bold mb-0 text-black text-bold">Industry Experience</div>
                                          </div>
                                          <div class="row gx-3">
                                              @foreach ($industries as $industry)
                                                  <div class="col-sm-6 col-lg-3 d-flex flex-wrap">
                                                      <div class="bg-gray bc-box bc-box-pmd">
                                                          <div class="bc-box-pmd-tl mb-1 mb-sm-2">
                                                              <div class="bc-box-pmd-tlt mb-0 text-black fw-semibold">
                                                                  {{ ucfirst($industry->industry_name) }}
                                                              </div>
                                                          </div>
                                                          <div class="bc-box-pmd-stl fw-medium text-gray">
                                                              @if ($industry->current_worked == 1 )
                                                                  Present
                                                              @else
                                                                  @if ($industry->experienced_year > 1 && $industry->experienced_month > 1)
                                                                      {{ $industry->experienced_year }} years {{ $industry->experienced_month }} months
                                                                  @elseif ($industry->experienced_year > 1 && $industry->experienced_month < 1)
                                                                      {{ $industry->experienced_year }} years {{ $industry->experienced_month }} month
                                                                  @elseif ($industry->experienced_year < 1 && $industry->experienced_month > 1)
                                                                      @if($industry->experienced_year == 0)
                                                                          {{ $industry->experienced_month }} months
                                                                      @else
                                                                          {{ $industry->experienced_year }} year {{ $industry->experienced_month }} months
                                                                      @endif
                                                                  @else
                                                                      @if($industry->experienced_year == 0)
                                                                          {{ $industry->experienced_month }} month
                                                                      @else
                                                                          {{ $industry->experienced_year }} year {{ $industry->experienced_month }} month
                                                                      @endif
                                                                      
                                                                  @endif
                                                                  
                                                              @endif
                                                          </div>
                                                      </div>
                                                  </div>
                                              @endforeach
                            
                                          </div>
                                        </div>
                                      @endif

                                      @if ($certificateCount > 0)
                                        <div class="bx bg-white px-0">
                                          <div class="bx-tl">
                                              <div class="bx-tlt fw-bold mb-0 text-black text-bold">Certificates</div>
                                          </div>

                                          <div class="row gx-3">
                                            @foreach ($certificates as $certificate)
                
                                                @if ($certificate->certification_name)
                                                    @php
                                                        $extension = pathinfo($certificate->certification_doc, PATHINFO_EXTENSION)
                                                    @endphp
                                                    <div class="col-sm-6 col-lg-3 d-flex flex-wrap">
                                                        <div class="bg-gray certi-box">
                                                            <div class="certi-box-tl text-black fw-semibold">
                                                                {{-- ADAS Card.jpg --}}
                                                                <a href="{{ url(Storage::url('Certificares/' . $certificate->certification_doc))}}" target="_blank" class="text-black text-decoration-none">
                                                                    {{ $certificate->certification_name }}.{{ $extension }}
                                                                </a>
                                                            </div>
                                                            <div class="certi-box-stl text-gray fw-medium">
                                                                Expire : {{ \Carbon\Carbon::parse($certificate->expired_date)->format('m/y') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                           
                                          </div>
                                        </div>
                                      @endif
                                          
                                      
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </section>
                @endif
                </div>
            </div>

            <!-- End Panel Basic -->
        </div>
      </div>

<!-- /.delete Model-open -->
<div class="modal fade modal-fade-in-scale-up block-popup-main" id="modalConfirmDelete" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close deletemodel" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Boup</h4>
      </div>
      <div class="modal-body">
        <p class="delete-conform-p">Are you sure you want to delete this @if ($userInfo->user_type == 1) commercial diver @elseif ($userInfo->user_type == 2) diver supervisor @elseif ($userInfo->user_type == 3) diving company @else user @endif ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary deletemodel">Close</button>
        <form action="{{ route('users.destroy', $userInfo->id) }}" method="POST">
          @csrf
          @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- /.delete Model-close -->

<!-- Block user Model -->
<div class="modal fade modal-fade-in-scale-up block-popup-main" id="modalConfirmBlock" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close blockmodel" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Boup</h4>
      </div>
      <div class="modal-body">
        <p class="delete-conform-p">Are you sure you want to block this @if ($userInfo->user_type == 1) commercial diver @elseif ($userInfo->user_type == 2) diver supervisor @elseif ($userInfo->user_type == 3) diving company @else user @endif ?</p>

        <form id="actionForm">
          <div class="form-group mb-3">
            <label >Reason for block (optional):</label>
            <input type="hidden" id="userId" value="{{ $userInfo->id }}">
            <input type="hidden" name="actionType" id="actionType">
              <input type="text" class="form-control" id="reasonInput" class="reasonInput" placeholder="Please enter reason">
              {{-- <a href="javascript:void(0)" class="btn btn-danger m-1" onclick="submitAction('suspend')">
                <span>Suspend</span>
              </a> --}}
          </div>
        </form>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary blockmodel">Close</button>
        <a href="javascript:void(0)" class="btn btn-danger  m-1" onclick="submitAction('block')">
          <span>Block</span>
        </a>
      </div>
    </div>
  </div>
</div>


<!-- Suspend user Model -->
<div class="modal fade modal-fade-in-scale-up block-popup-main" id="modalConfirmSuspend" aria-hidden="true" aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close suspendmodel" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title">Boup</h4>
      </div>
      <div class="modal-body">
        <p class="delete-conform-p">Are you sure you want to suspend this @if ($userInfo->user_type == 1) commercial diver @elseif ($userInfo->user_type == 2) diver supervisor @elseif ($userInfo->user_type == 3) diving company @else user @endif ?</p>

        <form id="actionForm">
          <div class="form-group mb-3">
            <label >Reason for suspend (optional):</label>
            <input type="hidden" id="userId" value="{{ $userInfo->id }}">
            <input type="hidden" name="actionType" id="actionType">
              <input type="text" class="form-control" id="reasonInput" class="reasonInput" placeholder="Please enter reason">
              {{-- <a href="javascript:void(0)" class="btn btn-danger m-1" onclick="submitAction('suspend')">
                <span>Suspend</span>
              </a> --}}
          </div>
        </form>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary suspendmodel">Close</button>
        <a href="javascript:void(0)" class="btn btn-danger  m-1" onclick="submitAction('suspend')">
          <span>Suspend</span>
        </a>
      </div>
    </div>
  </div>
</div>


<div id="modal-long" class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="modal-long__label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-slideover" role="document">
    <div class="modal-content">
      <div class="modal-header">
        {{-- <h5 class="modal-title" id="modal-long__label">Modal title</h5>
         --}}
         <div class="offcanvas-header-title text-black fw-semibold" id="CheckAvailLabel">
              Diver Availability Calendar
              <ul class="status-list">
                  <li>
                      <div class="status-box available-box"></div>
                      <span class="status-label">Available</span>
                  </li>
                  <li>
                    <div class="status-box today-box"></div>
                    <span class="status-label">Today</span>
                  </li>
                </ul>
          </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      @php
          $userAvailableDates = $userInfo->availability_dates;

      @endphp
      <div class="modal-body">
        <div class="diver-avail-datepicker-main">
          <div class="diver-avail-datepicker-wrap">

              <div class="diver-avail-calendar-container diver-avail-datepicker" id="diver-avail-datepicker{{$userInfo->id}}" data-available-dates='@json($userAvailableDates)' data-user-id="{{ $userInfo->id }}">

              </div>
          </div>
      </div>
      </div>
      {{-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> --}}
    </div>
  </div>
  {{-- <div class="offcanvas offcanvas-end offcanvas-main offcanvas-chk-avail-main"
      tabindex="-1" id="CheckAvail" aria-labelledby="CheckAvailLabel">
      <div class="offcanvas-header">
          <div class="offcanvas-header-title text-black fw-semibold" id="CheckAvailLabel">
              Diver Availability Calendar
              <ul class="status-list">
                  <li>
                      <div class="status-box available-box"></div>
                      <span class="status-label">Available</span>
                  </li>
                  <li>
                    <div class="status-box today-box"></div>
                    <span class="status-label">Today</span>
                  </li>
                </ul>
          </div>
          <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
              aria-label="Close"></button>
      </div>
      @php
          $userAvailableDates = $userInfo->availability_dates;

      @endphp
      <div class="offcanvas-body">
          <div class="diver-avail-datepicker-main">
              <div class="diver-avail-datepicker-wrap">

                  <div class="diver-avail-calendar-container diver-avail-datepicker" id="diver-avail-datepicker{{$userInfo->id}}" data-available-dates='@json($userAvailableDates)' data-user-id="{{ $userInfo->id }}">

                  </div>
              </div>
          </div>
      </div>
  </div> --}}
</div>
@endsection
@section('footer_script')
<script src="{{ asset('themes/admin/assets/js/form-validation.js') }}"></script>


<script type="text/javascript">
  $(document).ready(function() {
    $(".deviceInfo").hide();
    var deviceInfoShow = 0;
    $("#deviceInfobtn").on('click', function() {
      if (deviceInfoShow == 0) {
        $(".deviceInfo").show();
        deviceInfoShow = 1;
      } else {
        $(".deviceInfo").hide();
        deviceInfoShow = 0;
      }
    });

    $('.userbirthdate').datepicker({
      todayBtn: 'linked',
      format: 'yyyy-mm-dd',
      autoclose: true,
      endDate: "today"
    });


    $('.custom-nav-buttons').click(function(event) {
      event.preventDefault(); //stop browser to take action for clicked anchor
      //get displaying tab content jQuery selector
      var active_tab_selector = $(this).attr("target-discard");
      //hide displaying tab content
      $(active_tab_selector).removeClass('active');
      $(active_tab_selector).addClass('hide');

      //show target tab content
      var target_tab_selector = $(this).data("target");
      $(target_tab_selector).removeClass('hide');
      $(target_tab_selector).addClass('active');
    });

    if (!$('#image_demo').data('croppie')) {
      $image_crop = $('#image_demo').croppie({
        enableExif: true,
        viewport: {
          width: 350,
          height: 350,
          // type:'square' //circle // rectangular
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
          // type:'square' //circle // rectangular
        },
        boundary: {
          width: 600,
          height: 400
        }
      });
    }

    $(document).on('change', '#inputGroupFile01', function() {
      var name = $(this).attr('name');
      // var id_name= $(this).attr('id');
      // console.log('name = ' +name);
      var noImage = "{{asset('admin-theme/assets/images/default-img.png')}}";
      var ext = $(this).val().split('.').pop().toLowerCase();
      if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
        alert("Please select only image");
        return false;
      } else {
        //$("#file-error").attr("disabled", false);
        /* image crop */
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
      // return false;
      /* EOC image cropping */
    });

    $('.crop_image').click(function(event) {

      var className = $(this).attr('id');
      $image_crop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
      }).then(function(response) {
        $("#profile-pics-preview").attr("src", response);
        $("#imagebase64").val(response);

        $('#insertimageModal').modal('hide');
        $("#feed_image_error").html("");
      });
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

    $('.deletemodel').click(function(event) {
      $('#modalConfirmDelete').modal('hide');
    });

    $('.blockmodel').click(function(event) {
      $('#modalConfirmBlock').modal('hide');
    });
    $('.suspendmodel').click(function(event) {
      $('#modalConfirmSuspend').modal('hide');
    });


  });
</script>
<script>
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
<script>
  $(function () {
      $('.diver-avail-datepicker').each(function () {
          const $CalendarAvail = $(this);
          const today = new Date();
  
          let lastMonth = today.getMonth();
          let lastYear = today.getFullYear();
          const initialMonths = 3;

          const userId = $CalendarAvail.data('user-id');
          const availableDates = $CalendarAvail.data('available-dates')
  
          function addMonth(year, month) {
              const $picker = $('<div class="datepicker-inline"></div>');
              $CalendarAvail.append($picker);
  
              $picker.datepicker({
                  format: 'mm/dd/yyyy',
                  todayHighlight: true,
                  templates: {
                      leftArrow: '',
                      rightArrow: ''
                  },
                  startView: 0,
                  keyboardNavigation: false,
                  forceParse: false,
                  defaultViewDate: {
                      year,
                      month
                  },
                beforeShowDay: function (date) {
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    const formatted = `${year}-${month}-${day}`; // Example: "2025-07-20"

                    const today = new Date();
                    today.setHours(0, 0, 0, 0); // Remove time part

                    const currentDate = new Date(date);
                    currentDate.setHours(0, 0, 0, 0);

                    if (availableDates.includes(formatted) && currentDate >= today) {

                        return { classes: 'active day custom-day' };
                    }

                    return { classes: 'custom-day' };
                }
              }).on('changeDate', function (e) {
                  // Clear selection immediately after click
                  $(this).datepicker('setDate', null);
              });
          }
  
          // Generate initial 3 months
          for (let i = 0; i < initialMonths; i++) {
              const month = (lastMonth + i) % 12;
              const year = lastYear + Math.floor((lastMonth + i) / 12);
              addMonth(year, month);
          }
  
          // Scroll to current month
          $CalendarAvail.find('.datepicker-inline').each(function () {
              const dp = $(this).data('datepicker');
              if (
                  dp.viewDate.getMonth() === today.getMonth() &&
                  dp.viewDate.getFullYear() === today.getFullYear()
              ) {
                  $(this)[0].scrollIntoView({
                      behavior: 'smooth',
                      block: 'start'
                  });
                  return false;
              }
          });
      });
  
      // Prevent view mode change
      $(document).on('click', '.datepicker-inline .datepicker-switch', function (e) {
          e.preventDefault();
          return false;
      });
  });
</script>
@endsection
