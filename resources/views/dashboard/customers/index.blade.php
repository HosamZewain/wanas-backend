@extends('dashboard.layouts.app',[
    'breadcrumb_1'=>trans('dashboard.customers'),
    'add_link'=>'admin/customers/create',
    'add_link_text'=>'Add New User',
    'links'=>[
        1=>[
            'url'=>route('customers.index',['unconfirmed'=>true]),
            'class'=>' btn-default',
           'icon'=>'zmdi zmdi-accounts-list zmdi-hc-fw animated infinite wobble',
            'text'=>'تأكيد بيانات المستخدمين',
],
        2=>[
            'url'=>route('customers.index',['unconfirmed'=>false]),
            'class'=>' btn-success',
           'icon'=>'zmdi zmdi-account-box-mail zmdi-hc-fw animated infinite wobble',
            'text'=>'  مستخدمين تم تأكيدهم',
]
]
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
                                <th scope="col">{!! trans('dashboard.email') !!}</th>
                                <th scope="col">{!! trans('dashboard.country') !!}</th>
                                <th scope="col">{!! trans('dashboard.gender') !!}</th>
                                <th scope="col">{!! trans('dashboard.created_at') !!}</th>
                                <th scope="col">{!! trans('dashboard.operations') !!}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($resources as $resource)
                                <tr id="row_{!! $resource->id !!}">
                                    <td><strong>{!! $loop->iteration !!}</strong></td>
                                    <td>{!! $resource->name !!}</td>
                                    <td>{!! $resource->mobile !!}</td>
                                    <td>{!! $resource->email !!}</td>
                                    <td>{!! $resource->country->LName ?? "" !!}</td>
                                    <td>{!! __("dashboard.gender_list")[$resource->gender] !!}</td>
                                    <td>{!! $resource->created_at !!}</td>
                                    <td>
                                        @if(!$resource->UnConfirmed)
                                            <span
                                                data-toggle="tooltip" data-placement="top"
                                                title="{!! __('dashboard.data_confirmed') !!}"
                                                class="badge badge-secondary text-success mt-2">
                                             {{--   {!! __('dashboard.data_confirmed') !!} --}}
                                                <i class="fas fa-2x fa-user-check"></i>
                                            </span>
                                        @else
                                            <button
                                                data-toggle="tooltip" data-placement="top"
                                                title="{!! __('dashboard.confirm') !!}"
                                                data-id="{!! $resource->id !!}"
                                                data-route="{!! route('customers.confirmForm',$resource->id) !!}"
                                                class="open_modal btn btn-secondary btn-sm">
                                                <i class="far fa-check-circle"></i>
                                            </button>

                                        @endif
                                        <button
                                            data-toggle="tooltip" data-placement="top"
                                            title="{!! __('dashboard.user_vehicles') !!}"
                                            onclick="location.href='{!! route('user_vehicles.index',['user_id'=>$resource->id])!!}'"
                                            class="btn btn-primary btn-sm">
                                            <i class="fas fa-car-side"></i>
                                        </button>
                                        <button
                                            data-toggle="tooltip" data-placement="top"
                                            title="{!! __('dashboard.edit') !!}"
                                            onclick="location.href='{!! route('customers.edit',$resource->id) !!}'"
                                            class="btn btn-default btn-sm">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <button
                                            data-toggle="tooltip" data-placement="top"
                                            title="{!! __('dashboard.delete') !!}"
                                            data-route="{!! route('customers.destroy',$resource->id) !!}"
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
