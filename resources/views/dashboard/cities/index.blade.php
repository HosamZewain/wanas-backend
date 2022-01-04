@extends('dashboard.layouts.app',[
    'breadcrumb_1'=>trans('dashboard.cities'),
    'add_link'=> 'admin/cities/create',
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
                                <th scope="col">{!! trans('dashboard.governorate') !!}</th>
                                <th scope="col">{!! trans('dashboard.operations') !!}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($resources as $resource)
                                <tr id="row_{!! $resource->id !!}">
                                    <td><strong>{!! $loop->iteration !!}</strong></td>
                                    <td>{!! $resource->name_ar !!}</td>
                                    <td>{!! $resource->name_en  !!}</td>
                                    <td>{!! $resource->governorate->lName ?? ''  !!}</td>
                                    <td>
                                        <button
                                            onclick="location.href='{!! route('cities.edit',$resource->id) !!}'"
                                            class="btn btn-default btn-sm">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>

                                        <button
                                            data-route="{!! route('cities.destroy',$resource->id) !!}"
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
            </div>
        @else

        @endif
    </div>
@endsection
