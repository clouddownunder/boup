@extends('admin.layouts.main')
@section('content')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<div class="page">
   <div class="page-header">
      <h1 class="page-title">{{ __('admin.terms-title') }}</h1>
    </div>
    <div class="page-content container-fluid">
        <div class="container-fluid p-3"  >

              <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                  <div class="container-fuild mt-10 custom-section-class pb-30">
                      <div class="sec-title-wp row p-3">
                        <div class="col-xl-12 col-lg-12">
                          <h3 class="section-title"></h3>
                        </div>
                      </div>

                    {{-- <div class="row">
                      <div class="col-xl-12 col-lg-12">
                        <div class="row">
                          <div class="col-lg-12">
                            <div class="card card-block p-25">
                              <div class="counter counter-lg">
                                <span class="counter-number">Custom Add</span>
                                <div class="counter-label text-uppercase">users</div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> --}}
                    <form method="post" action="{{ route('admin.saveContent') }}" id="myform1">
                        @csrf
                        <div class="row">
                          <div class="col-md-12 mb-4">
                            <div class="form-outline">
                                <textarea type="text" id="editor" class="form-control form-control-lg" placeholder="Enter the terms of use"  name="agreement" rows="5" >{{ $agreement->content ?? '' }}</textarea>
                            </div>
                          </div>
                        </div>
                        <div class="mt-2">
                          <input class="btn btn-primary btn-md" type="submit" value="Update"/>
                        </div>

                      </form>

                  </div>
                </div>

              </div>


            <!-- Small boxes (Stat box) -->
        </div>


</div>
</div>
@stop

@section('footer_script')
<script>
    $(document).ready(function(){
        // alert("load");
        $("#globalRange").change(function(){
            if($(this).val()=="custom")
            {
                $(".custome").show();
            }
            else
            {
                $(".custome").hide();
            }
            if($(this).val()=="todate")
            {
                $(".todate").show();
            }
            else
            {
                $(".todate").hide();
            }

        });

        $("#globalRange2").change(function(){
            if($(this).val()=="custom")
            {
                $(".custome2").show();
            }
            else
            {
                $(".custome2").hide();
            }
            if($(this).val()=="todate")
            {
                $(".todate2").show();
            }
            else
            {
                $(".todate2").hide();
            }

        });


        $("#globalRange3").change(function(){
            if($(this).val()=="custom")
            {
                $(".custome3").show();
            }
            else
            {
                $(".custome3").hide();
            }
            if($(this).val()=="todate")
            {
                $(".todate3").show();
            }
            else
            {
                $(".todate3").hide();
            }

        });

    });
</script>
<script>

ClassicEditor
.create(document.querySelector('#editor'), {
            toolbar: [
                'heading',
                '|',
                'bold',
                'italic',
                'underline',
                'link',
                'bulletedList',
                'numberedList',
                '|',
                'undo',
                'redo'
            ]
        })
    .catch(error => {
        console.error(error);
    });

</script>
@stop
