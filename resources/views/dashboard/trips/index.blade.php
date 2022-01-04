@extends('dashboard.layouts.app',[
    'breadcrumb_1'=>trans('dashboard.trips'),
    //'add_link'=>'admin/trips/create',
    //'add_link_text'=>'Add New Trip',
    ])
@section('content')
    <div class="row clearfix">
        <div class="col-md-12 col-sm-12 col-xs-12">
            @if (count($resources))
                <div class="card project_list">
                    <div class="table-responsive">
                        <table class="table table-hover c_table" aria-label="d">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{!! trans('dashboard.name') !!}</th>
                                <th scope="col">{!! trans('dashboard.mobile') !!}</th>
                                <th scope="col">{!! trans('dashboard.pickup_address') !!}</th>
                                <th scope="col">{!! trans('dashboard.dropoff_address') !!}</th>
                                <th scope="col">{!! trans('dashboard.trip_date') !!}</th>
                                <th scope="col">{!! trans('dashboard.trip_time') !!}</th>
                                <th scope="col">{!! trans('dashboard.members_count') !!}</th>
                                <th scope="col">{!! trans('dashboard.trip_cost_per_person') !!}</th>
                                <th scope="col">{!! trans('dashboard.total_trip_cost') !!}</th>
                                <th scope="col">{!! trans('dashboard.operations') !!}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($resources as $resource)
                                <tr id="row_{!! $resource->id !!}">
                                    <td><strong>{!! $loop->iteration !!}</strong></td>
                                    <td>{!! $resource->user->name ?? "" !!}</td>
                                    <td>{!! $resource->user->mobile ?? "" !!}</td>
                                    <td>{!! ($resource->fromCity->governorate->lName  ?? '').' - '.($resource->fromCity->lName ?? '') .' <br>  '.$resource->pickup_address !!}</td>
                                    <td>{!! ($resource->ToCity->governorate->lName  ?? '').' - '.($resource->ToCity->lName ?? '') .' <br>  '.$resource->drop_off_address !!}</td>
                                    <td>{!! $resource->trip_date !!}</td>
                                    <td>{!! $resource->trip_time !!}</td>
                                    <td>{!! $resource->members_count !!}</td>
                                    <td>{!! $resource->trip_cost_per_person !!}</td>
                                    <td>{!! $resource->total_trip_cost !!}</td>

                                    <td>
                                        <button onclick="location.href='{!! route('trips.show',$resource->id) !!}'"
                                                class="btn btn-default btn-sm"
                                                href="{!! route('trips.show',$resource->id) !!}">
                                            <em class="zmdi zmdi-eye"></em>
                                        </button>
                                        <button
                                            data-route="{!! route('trips.destroy',$resource->id) !!}"
                                            data-id="{!!$resource->id !!}"
                                            data-token="{!! csrf_token() !!}"
                                            class="delete btn btn-danger btn-sm">
                                            <em class="zmdi zmdi-delete"></em>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row text-center">
                    {{ $resources->appends(request()->input())->links('vendor.pagination.bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
@endsection
