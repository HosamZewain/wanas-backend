@extends('dashboard.layouts.app',[
    'breadcrumb_1'=>trans('dashboard.pages'),
    'add_link'=>'admin/pages/create',
    'add_link_text'=>'Add New Page',
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
                                <th scope="col">{!! trans('dashboard.title') !!}</th>
                                <th scope="col">{!! trans('dashboard.body') !!}</th>
                                <th scope="col">{!! trans('dashboard.operations') !!}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($resources as $resource)
                                <tr id="row_{!! $resource->id !!}">
                                    <td><strong>{!! $loop->iteration !!}</strong></td>
                                    <td>{!! $resource->title !!}</td>
                                    <td>{!! $resource->body !!}</td>
                                    <td>
                                        <button onclick="location.href='{!! route('pages.edit',$resource->id) !!}'"
                                                class="btn btn-default btn-sm"
                                                href="{!! route('pages.edit',$resource->id) !!}">
                                            <em class="zmdi zmdi-edit"></em>
                                        </button>
                                        <button
                                            data-route="{!! route('pages.destroy',$resource->id) !!}"
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
