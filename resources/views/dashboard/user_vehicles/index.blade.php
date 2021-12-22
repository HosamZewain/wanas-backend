@extends('dashboard.layouts.app',[
    'breadcrumb_1'=>trans('dashboard.user_vehicles'),
   (count($resources)) ?  '' :  'add_link'=>'admin/user_vehicles/create?user_id='.$user_id ,
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
                                <th scope="col">{!! trans('dashboard.color') !!}</th>
                                <th scope="col">{!! trans('dashboard.number') !!}</th>
                                <th scope="col">{!! trans('dashboard.model') !!}</th>
                                <th scope="col">{!! trans('dashboard.type') !!}</th>
                                <th scope="col">{!! trans('dashboard.operations') !!}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($resources as $resource)
                                <tr id="row_{!! $resource->id !!}">
                                    <td><strong>{!! $loop->iteration !!}</strong></td>
                                    <td>{!! $resource->color !!}</td>
                                    <td>{!! $resource->number !!}</td>
                                    <td>{!! $resource->model !!}</td>
                                    <td>{!! $resource->VehicleType->name ?? '' !!}</td>
                                    <td>
                                        @if($resource->status == \App\Models\UserVehicle::STATUS_APPROVED)
                                            <span
                                                data-toggle="tooltip" data-placement="top"
                                                title="{!! __('dashboard.data_confirmed') !!}"
                                                class="badge badge-secondary text-success mt-2">
                                            <i class="fas fa-2x fa-check-double"></i>
                                            </span>
                                        @elseif($resource->status ==\App\Models\UserVehicle::STATUS_DISAPPROVED)
                                            <span
                                                data-toggle="tooltip" data-placement="top"
                                                title="{!! __('dashboard.disapprove') !!}"
                                                class="badge badge-secondary text-danger mt-2"><i
                                                    class="far  fa-2x  fa-times-circle"></i>
                                            </span>
                                        @else
                                            <button
                                                data-toggle="tooltip" data-placement="top"
                                                title="{!! __('dashboard.confirm') !!}"
                                                data-id="{!! $resource->id !!}"
                                                data-route="{!! route('user_vehicles.confirmForm',$resource->id) !!}"
                                                class="open_modal btn btn-secondary btn-sm">
                                                <i class="far fa-check-circle"></i>
                                            </button>

                                        @endif
                                        <button
                                            onclick="location.href='{!! route('user_vehicles.edit',$resource->id) !!}'"
                                            class="btn btn-default btn-sm"
                                            href="{!! route('user_vehicles.edit',$resource->id) !!}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <button
                                            data-route="{!! route('user_vehicles.destroy',$resource->id) !!}"
                                            data-id="{!!$resource->id !!}"
                                            data-token="{!! csrf_token() !!}"
                                            class="delete btn btn-danger btn-sm">
                                            <i class="far fa-trash-alt"></i>
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
