@extends('website.layouts.app')

@section('content')
    <!-- add class inner-header -->
    <header id="header" class="inner-header">
        <!-- menu -->
        <div class="mainNav">
            <div class="container">
                <div class="menuBar d-flex d-md-none justify-content-between align-items-center">
                    <a href="{!! url('/') !!}">
                        <img src="{!! asset('website/assets/img/whiteLogo.png') !!}"
                             data-src="{!! asset('website/assets/img/whiteLogo.png') !!}"
                             class="logo lazyload"
                             alt="logo"
                        />
                    </a>
                    <div class="toggle">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </div>
                </div>

                <div class="overlay"></div>

                <div
                    class="menu d-flex flex-wrap align-items-center justify-content-end"
                >
                    <ul class="menuLinks" data-aos="fade-zoom-in">
                        <li>
                            <a href="{!! url('/') !!}">الرئيسية</a>
                        </li>
                        <li>
                            <a href="{!! url('/') !!}/#about">عن ونس</a>
                        </li>
                        <li class="active">
                            <a aria-current="page">مشاركة الطريق والرحلات</a>
                        </li>
                        <li>
                            <a href="{!! url('/') !!}/#contactUs">تواصل معنا</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <!--end header-->
    <!-- start page info -->
    <div class="page-info">
        <div class="container">
            <div
                class="title d-flex flex-column align-items-center justify-content-center">
                <h1>مشاركة <span class="text-secondary">الطريق والرحلات</span></h1>
                <p class="text-grayClr">
                    اكتشف احدث مشاركات الطريق والرحلات وقم بالاشتراك لتجد رفيق الطريق
                    للاستمتاع بالطريق
                </p>
            </div>
        </div>
    </div>
    <!-- end page info -->

    <!-- start details -->
    <div class="route-details py-4">
        <div class="container">
            @if($resource->trip_type == \App\Models\Trip::TYPE_RIDE)
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)" class="text-lightGray">مشاركة الطريق والرحلات</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)" class="text-lightGray">مشاركة الطريق</a>
                        </li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">
                            تفاصيل
                        </li>
                    </ol>
                </nav>
            @else
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-lightGray">مشاركة الطريق والرحلات</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#" class="text-lightGray">الرحلات الجماعية والأحداث</a>
                        </li>
                        <li class="breadcrumb-item active text-primary" aria-current="page">
                            تفاصيل
                        </li>
                    </ol>
                </nav>
            @endif

            <div class="row">
                <div class="col-md-5 col-lg-6">
                    @if (isset(optional(optional($resource->user)->vehicle)->image))
                        <img
                            src="{!! asset('storage/'.optional(optional($resource->user)->vehicle)->image ?? '') !!}"
                            class="route-image mb-3 mb-md-0 lazyload" alt=""/>
                    @else
                        <img style="width: 100%;"
                             src="{!! asset( 'dashboard/assets/images/trip.png') !!}"
                             class="route-image mb-3 mb-md-0 lazyload" alt=""/>
                    @endif
                </div>
                <div class="col-md-7 col-lg-6">
                    <!-- in case of trips -->
                    <div class="card border-0 rounded-3 mb-3">
                        <div class="card-body">
                            <h6 class="text-black fs16 fw-bold">{!! $resource->trip_name ?? '' !!}</h6>
                            <p class="fs14 text-grayClr">{!! $resource->trip_details ?? '' !!} </p>
                        </div>
                    </div>
                    <div class="card border-0 rounded-3 mb-3">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="user">
                                        @if (isset($resource->user->profile_image) && file_exists(public_path('storage/'.$resource->user->profile_image)))
                                            <img
                                                src="{!! asset('storage/'.$resource->user->profile_image)  !!}"
                                                class="user-image lazyload" alt=""/>
                                        @else
                                            <img style="width: 100%;"
                                                 src="{!! asset( 'dashboard/assets/images/profile.jpg') !!}"
                                                 class="user-image lazyload" alt=""/>
                                        @endif
                                        <img
                                            src="{!! asset('website/assets/img/check.svg') !!}"
                                            data-src="{!! asset('website/assets/img/check.svg') !!}"
                                            alt="check"
                                            class="check-image lazyload"/>
                                        <img
                                            src="{!! asset('website/assets/img/ellipse.svg') !!}"
                                            data-src="{!! asset('website/assets/img/ellipse.svg') !!}"
                                            alt="ellipse" class="ellipse-image lazyload"
                                        />
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <span class="fw-bold">{!! $resource->user->name ?? '' !!}</span>
                                    <span class="d-block fw-bold">
       @for ($i = 1; $i <= 5; $i++)
                                            <i class=" @if($resource->user->rate>=$i) fas  @else far  @endif fa-star text-warning"></i>
                                        @endfor
                                        {!! $resource->user->rate ?? '' !!}
</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-0 rounded-3 mb-3">
                        <div class="card-body py-4">
                            <ul class="timeline">
                                <li>   {!! ($resource->fromCity->governorate->lName  ?? '').' - '.($resource->fromCity->lName ?? '') .' <br>  '.$resource->pickup_address !!}</li>
                                <li>  {!! ($resource->ToCity->governorate->lName  ?? '').' - '.($resource->ToCity->lName ?? '') .' <br>  '.$resource->drop_off_address !!}</li>
                            </ul>
                        </div>
                    </div>

                    <div class="row mx-0">
                        <div class="col-md-6">
                            <div class="card border-0 rounded-3 mb-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="svg-icon d-flex align-items-center justify-content-center bg-lightPrimary"
                                            >
                                                <img
                                                    src="{!! asset('website/assets/img/receipt.svg') !!}"
                                                    data-src="{!! asset('website/assets/img/receipt.svg') !!}"
                                                    alt="user"
                                                    class="lazyload"
                                                />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="text-grayClr fs14">التكلفة</span>
                                            <span class="d-block fs16 fw-bold text-secondary">  {!! $resource->trip_cost_per_person !!} جنية</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 rounded-3 mb-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="svg-icon d-flex align-items-center justify-content-center bg-lightOrange"
                                            >
                                                <img
                                                    src="{!! asset('website/assets/img/clock.svg') !!}"
                                                    data-src="{!! asset('website/assets/img/clock.svg') !!}"
                                                    alt="user"
                                                    class="lazyload"
                                                />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="text-grayClr fs14">الوقت</span>
                                            <span
                                                class="d-block fs16 fw-bold text-black">   {!! $resource->trip_time !!}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 rounded-3 mb-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="svg-icon d-flex align-items-center justify-content-center bg-lightOrange"
                                            >
                                                <img
                                                    src="{!! asset('website/assets/img/people.svg') !!}"
                                                    data-src="{!! asset('website/assets/img/people.svg') !!}"
                                                    alt="user"
                                                    class="lazyload"
                                                />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="text-grayClr fs14">عدد الأفراد</span>
                                            <span class="d-block fs16 fw-bold text-black">    {!! $resource->members_count !!} فرد</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 rounded-3 mb-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="svg-icon d-flex align-items-center justify-content-center bg-lightPrimary"
                                            >
                                                <img
                                                    src="{!! asset('website/assets/img/calendar.svg') !!}"
                                                    data-src="{!! asset('website/assets/img/calendar.svg') !!}"
                                                    alt="user"
                                                    class="lazyload"
                                                />
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <span class="text-grayClr fs14">التاريخ</span>
                                            <span
                                                class="d-block fs16 fw-bold text-black">   {!! $resource->trip_date !!}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- in case of trips -->
                    <div class="card border-0 rounded-3 mb-3">
                        <div class="card-body">
                            <h6 class="text-black fs16 fw-bold">عدد المشتركين</h6>
                            <span class="fs14 text-grayClr"> {!! count($resource->members) !!} مشترك </span>
                        </div>
                    </div>

                    <!-- in case of road -->
                    <div class="card border-0 rounded-3 mb-3">
                        <div class="card-body">
                            <div class="border-bottom pb-3 mb-3">
                                <span class="text-grayClr fs14">نوع السيارة</span>
                                <span
                                    class="d-block fs16 fw-bold text-black">{!! $resource->user->vehicle->model ?? '' !!}</span>
                            </div>
                            <div class="border-bottom pb-3 mb-3">
                                <span class="text-grayClr fs14">لونها</span>
                                <span
                                    class="d-block fs16 fw-bold text-black">{!! $resource->user->vehicle->colorModel->name_ar ?? '' !!}</span>
                            </div>
                            <div>
                                <span class="text-grayClr fs14">لوحة السيارة</span>
                                <span
                                    class="d-block fs16 fw-bold text-black">{!! $resource->user->vehicle->number ?? '' !!}</span>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary text-white w-100 my-3">
                        اشتراك
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- end details -->

    <!-- start download App  -->
    <div class="downloadApp pt-5">
        <div class="container position-relative zIndex1 text-white">
            <div class="row">
                <div class="col-md-6 d-flex flex-column justify-content-center pb-5">
                    <h4 class="fw-bold">حمل التطبيق</h4>
                    <div class="d-flex flex-wrap">
                        <a href="#">
                            <img src="{!! asset('website/assets/img/google.png') !!}"
                                 data-src="{!! asset('website/assets/img/google.png') !!}"
                                 class="downloadLinks lazyload me-3"
                                 alt="google play"
                            />
                        </a>
                        <a href="#">
                            <img src="{!! asset('website/assets/img/apple.png') !!}"
                                 data-src="{!! asset('website/assets/img/apple.png') !!}"
                                 class="downloadLinks lazyload"
                                 alt="app store"
                            />
                        </a>
                    </div>
                </div>
                <div class="col-md-6 d-flex justify-content-end pe-5">
                    <img src="{!! asset('website/assets/img/handPhone.png') !!}"
                         data-src="{!! asset('website/assets/img/handPhone.png') !!}"
                         class="handPhone lazyload"
                         alt="phone"
                    />
                </div>
            </div>
        </div>
    </div>
    <!-- end download App  -->
@endsection
