@extends('dashboard.layouts.app',[
    'breadcrumb_1'=>trans('dashboard.trips'),
    //'add_link'=>'admin/trips/create',
    //'add_link_text'=>'Add New Trip',
    ])
@section('content')
    <div class="row clearfix">
        <div class="col-md-12 col-sm-12 col-xs-12">
            @if (count($resource))
                <div class="card project_list">

                </div>

            @endif
        </div>
    </div>
@endsection
