@extends('dashboard.layouts.app',[
    'breadcrumb_1'=>trans('dashboard.trips'),
    ])
@section('content')
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-12">
                            <div class="preview preview-pic tab-content">
                                <div class="tab-pane active" id="product_1">

                                    @if (isset(optional(optional($resource->user)->vehicle)->image))
                                        <img
                                            src="{!! asset('storage/'.optional(optional($resource->user)->vehicle)->image ?? '') !!}"
                                            class="img-fluid" alt=""/>
                                    @else
                                        <img style="width: 100%;"
                                             src="{!! asset( 'dashboard/assets/images/trip.png') !!}"
                                             class="img-fluid" alt=""/>
                                    @endif

                                </div>
                            </div>
                            {{--                            <ul class="preview thumbnail nav nav-tabs">--}}
                            {{--                                <li class="nav-item">--}}
                            {{--                                    <a class="nav-link active" data-toggle="tab" href="#product_1">--}}
                            {{--                                        <img src="{!! asset('storage/'.$resource->user->vehicle->image ?? '') !!}"--}}
                            {{--                                             alt=""/>--}}
                            {{--                                    </a>--}}
                            {{--                                </li>--}}
                            {{--                            </ul>--}}
                        </div>
                        <div class="col-xl-3 col-lg-8 col-md-12">
                            <div class="product details">
                                <h5 class="price mt-0">نقطة الإنطلاق <span
                                        class="col-amber">{!! $resource->pickup_address !!}</span></h5>
                                <h5 class="price mt-0">نقطة الوصول <span
                                        class="col-amber">{!! $resource->drop_off_address !!}</span></h5>
                                <h5 class="price mt-0">تاريخ الرحلة <span
                                        class="col-amber">{!! $resource->trip_date !!}</span></h5>
                                <h5 class="price mt-0">وقت الرحلة <span
                                        class="col-amber">{!! $resource->trip_time !!}</span></h5>
                                <h5 class="price mt-0">عدد المشتركين <span
                                        class="col-amber">{!! $resource->members_count !!}</span></h5>
                                <h5 class="price mt-0">تكلفة الرحلة للفرد <span
                                        class="col-amber">{!! $resource->trip_cost_per_person !!}</span></h5>
                                <h5 class="price mt-0">تكلفة الرحلة <span
                                        class="col-amber">{!! $resource->total_trip_cost !!}</span></h5>
                                <h5 class="price mt-0">التقييم</h5>
                                <div class="rating">
                                    <div class="stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span
                                                class="zmdi zmdi-star  @if($resource->rate>=$i) col-amber @endif"></span>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-8 col-md-12">
                            <div class="card">
                                <div class="body">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                                                href="#description">بيانات
                                                السائق</a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#review">بيانات
                                                المشتركين</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card">
                                <div class="body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="description">
                                            <div class="row">
                                                <div class="col-lg-3 col-md-12">
                                                    @if (isset($resource->user->profile_image))
                                                        <img
                                                            src="{!! asset('storage/'.$resource->user->profile_image)  !!}"
                                                            class="img-fluid" alt=""/>
                                                    @else
                                                        <img style="width: 100%;"
                                                             src="{!! asset( 'dashboard/assets/images/profile.jpg') !!}"
                                                             class="img-fluid" alt=""/>
                                                    @endif
                                                </div>
                                                <div class="col-lg-9 col-md-12">
                                                    <div class="card">
                                                        <div class="body">
                                                            <small class="text-muted">الإسم</small>
                                                            <p>{!! $resource->user->name ?? '' !!}</p>
                                                            <hr>
                                                            <small class="text-muted">رقم الهاتف المحمول </small>
                                                            <p>{!! $resource->user->mobile ?? '' !!}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="review">
                                            <ul class="row list-unstyled c_review mt-4">
                                                @if (count($resource->members))
                                                    @foreach($resource->members as $member)
                                                        <li class="col-12">
                                                            <div class="avatar">
                                                                @if (isset($member->user->profile_image))
                                                                    <a href="javascript:void(0);">
                                                                        <img class="rounded"
                                                                             src="{!! asset('storage/'.$member->user->profile_image)  !!}"
                                                                             alt="user" width="60"></a>
                                                                @else
                                                                    <a href="javascript:void(0);">
                                                                        <img class="rounded"
                                                                             src="{!! asset( 'dashboard/assets/images/profile.jpg') !!}"
                                                                             alt="user" width="60"></a>
                                                                @endif
                                                            </div>
                                                            <div class="comment-action">
                                                                <h5 class="c_name">{!! $member->user->name ?? '' !!}</h5>
                                                                @php
                                                                    $rate = $resource->TripRate()->where('user_id',$member->user->user_id)->first();
                                                                @endphp
                                                                @if ($rate)
                                                                    <p class="c_msg mb-0">{!! $rate->comment ?? '' !!}</p>
                                                                    <div
                                                                        class="badge badge-primary">{!! $member->user->mobile ?? '' !!}</div>
                                                                    <span class="m-l-10">
                                                                         @for ($i = 1; $i <= 5; $i++)
                                                                            <i class="zmdi zmdi-star @if($rate->rate>=$i)  col-amber @endif"></i>
                                                                        @endfor
                                                                    </span>
                                                                    <small
                                                                        class="comment-date float-sm-right">{!! $rate->created_at->format('Y-m-d') !!}</small>
                                                                @endif
                                                            </div>
                                                        </li>
                                                    @endforeach

                                                @else
                                                    <p>لا يوجد بيانات</p>
                                                @endif

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
