@extends('layouts.master')

@section('javascripts')
<script>
var routeConfigureField = "{{ route('field.configure', [ 'type' => '%TYPE%' ]) }}";
function loadFieldConfiguration(type) {
    console.log('Loading field configuration ' + type)
    $.get(routeConfigureField.replace('%TYPE%', type), function(response) {
        if(response.configurable) {
            // Load scripts and append configuration form
            $('.box-configuration .box-body').html(response.html);
        } else {
            $('.box-configuration .box-body').text('Nothing to configure.');
        }
    });
}

$(function() {
    $('#type').on('change', function() {
        loadFieldConfiguration($(this).val());
    });
});

$("#type-item").change(function () {
    if(this.value==1){
      $("#html-box-title").html("Header");
    }
    if(this.value==2){
      $("#html-box-title").html("Footer");
    }
});


</script>
@endsection

@section('content')
    {!! Form::model($field, [ 'method' => 'PATCH', 'route' => [ 'field.update', $field->id ], 'class' => 'form', 'role' => 'form' ]) !!}
    <section class="content-header">
        <h1><i class="fa fa-pencil"></i>Edit field <div class="action-buttons"><button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-file"></i>Save</button></div></h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ route('field.index') }}">Items</a></li>
            <li class="active">Edit <strong>{{ $field->name }}</strong></strong></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-solid box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Details</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" style="margin-right: 0"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @include('field._form', [ 'action' => 'edit' ])
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="header-div">
            <div class="col-md-12">
                <div class="box box-solid box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title" id="html-box-title">Header</h3>
                    </div>
                    <div class="box-body">
                      <div class="form-group">
                          <label for="name">HTML</label>
                          <textarea rows="5" class="form-control" name="html_input" id="html_input">{{ $field->html_input  }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    {!! Form::close() !!}
@endsection
