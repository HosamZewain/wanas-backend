@extends('dashboard.layouts.app',[
    'breadcrumb_1'=>trans('dashboard.notifications'),
    'add_link'=>'admin/notifications/create',
    'add_link_text'=>'Add New Notification',
    ])
@section('content')
    <div class="row clearfix">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="card project_list">
                @if (count($resources))
                    <div class="table-responsive">
                        <table class="table table-hover c_table" aria-label="d">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{!! trans('dashboard.title') !!}</th>
                                <th scope="col">{!! trans('dashboard.operations') !!}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($resources as $resource)
                                <tr id="row_{!! $resource->id !!}">
                                    <td><strong>{!! $loop->iteration !!}</strong></td>
                                    <td>{!! $resource->title !!}</td>
                                    <td>
                                        <button onclick="location.href='{!! route('notifications.edit',$resource->id) !!}'"
                                                class="btn btn-default btn-sm"
                                                href="{!! route('notifications.edit',$resource->id) !!}">
                                            <em class="far fa-edit"></em>
                                        </button>
                                        <button
                                            data-route="{!! route('notifications.destroy',$resource->id) !!}"
                                            data-id="{!!$resource->id !!}"
                                            data-token="{!! csrf_token() !!}"
                                            class="delete btn btn-danger btn-sm">
                                            <em class="far fa-trash-alt"></em>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        {{ $resources->appends(request()->input())->links('vendor.pagination.bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
