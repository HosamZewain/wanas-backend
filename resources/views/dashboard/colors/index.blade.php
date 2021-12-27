@extends('dashboard.layouts.app',[
    'breadcrumb_1'=>trans('dashboard.colors'),
    'add_link'=> 'admin/colors/create',
    'add_link_text'=> __('dashboard.add_new'),
    ])
@section('content')
    <div class="row clearfix">
        @if (count($resources))
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card project_list">
                    <div class="table-responsive">
                        <table class="table table-hover c_table theme-color" aria-label="d">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{!! trans('dashboard.name_ar') !!}</th>
                                <th scope="col">{!! trans('dashboard.name_en') !!}</th>
                                <th scope="col">{!! trans('dashboard.code') !!}</th>
                                <th scope="col">{!! trans('dashboard.operations') !!}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($resources as $resource)
                                <tr id="row_{!! $resource->id !!}">
                                    <td><strong>{!! $loop->iteration !!}</strong></td>
                                    <td>{!! $resource->name_ar !!}</td>
                                    <td>{!! $resource->name_en  !!}</td>
                                    <td>
                                        <span class="badge " style="background-color:{!! $resource->color !!}"> {!! $resource->color  !!}</span>
                                       </td>
                                    <td>
                                            <button onclick="location.href='{!! route('colors.edit',$resource->id) !!}'"
                                                    class="btn btn-default btn-sm"
                                                    href="{!! route('colors.edit',$resource->id) !!}">
                                                <em class="zmdi zmdi-edit"></em>
                                            </button>

                                                <button
                                                    data-route="{!! route('colors.destroy',$resource->id) !!}"
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
            </div>
        @else

        @endif
    </div>
@endsection
