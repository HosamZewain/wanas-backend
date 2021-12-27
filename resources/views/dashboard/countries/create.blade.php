@extends('dashboard.layouts.app',['breadcrumb_1'=>trans('dashboard.countries')])
@section('content')
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="header text-left">
                    <h2><strong>{!! trans('dashboard.create') !!}</strong></h2>
                </div>
                <div class="body">
                    {!! Form::open([
                     'method'=>'post',
                     'files'=>true,
                     'id'=>'form-submit',
                     'redirect'=>route('countries.index'),
                     'class'=>'form-horizontal',
                     'route'=>['countries.store']]) !!}
                    @include('dashboard.countries.partials._form')
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
