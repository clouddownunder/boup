@extends('admin.layouts.main')

@section('header_css')

<link rel="stylesheet" href="{{ asset('themes/admin/assets/examples/css/pages/profile.minfd53.css') }}">

@endsection

@section('content')
<div class="page-profile">
  <!-- Page -->
  <div class="page">
    <div class="page-content container-fluid">
      <div class="row">


        <div class="col-lg-9">
          <!-- Panel -->
          <div class="panel">
            <div class="panel-body nav-tabs-animate nav-tabs-horizontal" data-plugin="tabs">
              <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                <li class="nav-item" role="presentation"><a class="active nav-link" data-toggle="tab" href="#profile" aria-controls="profile" role="tab">Application Settings</a></li>
              </ul>

              <div class="tab-content">

                <div class="tab-pane active animation-slide-left" id="profile" role="tabpanel">
                  <ul class="list-group">
                    <li class="list-group-item">
                      <div class="row row-lg">
                        <div class="col-md-8">
                          <!-- Example Basic Form (Form grid) -->
                          <div class="example-wrap">
                            <div class="example">
                              <form method="POST" action="{{ route('update.setting') }}" enctype="multipart/form-data" id="userProfileForm">
                                @csrf 
                              <div class="row">
                                @foreach($settings as $setting)
                                @if($setting->setting_key == 'show_device_info')
                                <div class="form-group form-material col-md-12 @error($setting->setting_key) has-danger @enderror">
                                  <label class="form-control-label" for="inputBasicFirstName">{{$setting->setting_label}}<span class="text-danger">*</span></label>
                                  <select class="form-control" name="{{$setting->setting_key}}"required>
                                    <option value="1" @if($setting->setting_value == '1') selected="true" @endif >Yes</option>
                                    <option value="0" @if($setting->setting_value == '0') selected="true" @endif>No</option>
                                  </select>
                                  @error($setting->setting_key)
                                  <label class="form-control-label" for="name">{{ $message }}</label>
                                  @enderror
                                </div>
                                @else
                                <div class="form-group form-material col-md-12 @error($setting->setting_key) has-danger @enderror">
                                  <label class="form-control-label" for="inputBasicFirstName">{{$setting->setting_label}}<span class="text-danger">*</span></label>
                                  <input type="text" class="form-control" placeholder="{{$setting->setting_label}}" value="{{$setting->setting_value}}" name="{{$setting->setting_key}}" autocomplete="off" required />
                                  @error($setting->setting_key)
                                  <label class="form-control-label" for="name">{{ $message }}</label>
                                  @enderror
                                </div>
                                @endif
                                @endforeach
                              </div>
                              <div class="form-group form-material">
                                <button type="submit" class="btn btn-primary">Update</button>
                              </div>
                              </form>
                            </div>
                          </div>
                          <!-- End Example Basic Form -->
                        </div>

                      </div>
                    </li>
                  </ul>
                </div>

              </div>
            </div>
          </div>
          <!-- End Panel -->
        </div>
      </div>
    </div>
  </div>
  <!-- End Page -->
</div>
@stop

@section('footer_script')
@stop