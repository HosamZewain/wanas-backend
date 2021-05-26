@extends('dashboard.layouts.app',['breadcrumb_1'=>trans('dashboard.users')])
@section('content')
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
            <div class="card">
                <div class="header text-left">
                    <h2><strong>{!! trans('dashboard.create') !!}</strong></h2>
                </div>
                <div class="body">
                    {!! Form::model($resource,[
                        'method'=>'post',
                        'files'=>true,
                        'class'=>'form-horizontal',
                        'route'=>['users.update',$resource->id]]) !!}
                    {!! method_field('put') !!}
                    @include('dashboard.users.partials._form')
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::submit('Save Changes',['class'=>'btn btn-primary float-right']); !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
