<!doctype html>
<html class="no-js " lang="en">
@include('dashboard.layouts.head')
<body class="  rtl">
@include('dashboard.layouts.partials.loader')
<!-- Overlay For Sidebars -->
{{--  <div class="overlay"></div>  --}}
@include('dashboard.layouts.partials.search')
@include('dashboard.layouts.partials.navbar_right')
@include('dashboard.layouts.partials.options')
@include('dashboard.layouts.partials.right_sidebar')

<!-- Main Content -->
<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>{{ trans('dashboard.dashboard') }}</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{!! url('/admin') !!}">
                                <em class="zmdi zmdi-home"></em>
                                <label> {{ trans('dashboard.MainPage') }}</label>
                            </a>
                        </li>
                        <li class="breadcrumb-item
                            @if (!isset($breadcrumb_1)) d-none @endif
                            active">
                            <label>{!! $breadcrumb_1 ?? '' !!}</label>
                        </li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button">
                        <em class="zmdi zmdi-sort-amount-desc"></em>
                    </button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary float-right right_icon_toggle_btn" type="button">
                        <em class="zmdi zmdi-arrow-right"></em>
                    </button>
                    @if (isset($add_link))
                        <a href="{!! url($add_link) !!}"
                           class="btn btn-success text-white float-right" type="button">
                            <em class="zmdi zmdi-plus"></em>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="container-fluid">
            @include('flash::message')
            @yield('content')
        </div>
    </div>
</section>

@include('dashboard.layouts.scripts')
</body>
</html>
