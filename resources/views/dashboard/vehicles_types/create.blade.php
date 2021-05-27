@extends('dashboard.layouts.app',['breadcrumb_1'=>trans('dashboard.vehicles_types')])
@section('content')
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
            <div class="card">
                <div class="header text-left">
                    <h2><strong>{!! trans('dashboard.create') !!}</strong></h2>
                </div>
                <div class="body">
                    {!! Form::open([
                     'method'=>'post',
                     'files'=>true,
                     'class'=>'form-horizontal',
                     'route'=>['vehicles_types.store']]) !!}
                    @include('dashboard.vehicles_types.partials._form')
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::submit(__('dashboard.save'),['class'=>'btn btn-primary float-right']); !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
