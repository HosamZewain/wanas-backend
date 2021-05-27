@extends('dashboard.layouts.app',[
    'breadcrumb_1'=>trans('dashboard.vehicles_types'),
    'add_link'=>'admin/vehicles_types/create',
    'add_link_text'=>'Add New Vehicle Type',
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
                                <th scope="col">{!! trans('dashboard.logo') !!}</th>
                                <th scope="col">{!! trans('dashboard.operations') !!}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($resources as $resource)
                                <tr id="row_{!! $resource->id !!}">
                                    <td><strong>{!! $loop->iteration !!}</strong></td>
                                    <td>{!! $resource->name !!}</td>
                                    <td>
                                        <a data-fancybox="gallery"
                                           href="{!!asset('storage/' . $resource->logo)  !!}">
                                            <img style="width:50px;" alt="commercial_certificate"
                                                 src="{!!asset('storage/' . $resource->logo)  !!}">
                                        </a>
                                    </td>
                                    <td>
                                        <button
                                            onclick="location.href='{!! route('vehicles_types.edit',$resource->id) !!}'"
                                            class="btn btn-default btn-sm"
                                            href="{!! route('vehicles_types.edit',$resource->id) !!}">
                                            <em class="zmdi zmdi-edit"></em>
                                        </button>
                                        <button
                                            data-route="{!! route('vehicles_types.destroy',$resource->id) !!}"
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
