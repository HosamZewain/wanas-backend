@extends('dashboard.layouts.app',['breadcrumb_1'=>trans('dashboard.notifications')])
@section('content')
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
            <div class="card">
                <div class="header text-left">
                    <h2><strong>{!! trans('dashboard.create') !!}</strong></h2>

                  {{--  <a id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()"
                       class="btn btn-danger btn-xs btn-flat">Allow for Notification</a>
--}}
                </div>
                <div class="body">
                    {!! Form::open([
                     'method'=>'post',
                     'files'=>true,
                     'class'=>'form-horizontal',
                     'route'=>['notifications.store']]) !!}
                    @include('dashboard.notifications.partials._form')
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::submit('Save',['class'=>'btn btn-primary float-right']); !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

