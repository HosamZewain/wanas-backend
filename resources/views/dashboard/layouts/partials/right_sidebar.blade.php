<!-- right_sidebar  -->
<aside id="leftsidebar" class="sidebar">
    <div class="navbar-brand">
        <button class="btn-menu ls-toggle-btn" type="button">
            <i class="zmdi zmdi-menu"></i>
        </button>
        <a href="{!! url('/') !!}">
            @if (isset($settings->logo))
                <img
                    src="{!! ($settings->logo) ? asset('storage/' .$settings->logo) : asset('dashboard/assets/images/logo.svg') !!}"
                    width="25" alt="Aero">

            @else
                <img
                    src="{!!  asset('dashboard/assets/images/logo.svg') !!}"
                    width="25" alt="Aero">
            @endif
            <span class="m-l-10">{!! ($settings->app_name) ?  : 'لوحة التحكم' !!}</span>
        </a>
    </div>
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    <a class="image" href="{!! url('admin/users/'.\Illuminate\Support\Facades\Auth::user()->id.'/edit') !!}">
                        <img src="{!! asset('dashboard/assets/images/profile.jpg') !!}" alt="User">
                    </a>
                    <div class="detail">
                        <h4>{!! \Illuminate\Support\Facades\Auth::user()->name ?? '' !!}</h4>
                        <small>ادمن</small>
                    </div>
                </div>
            </li>
            <li>
                <a href="{!! url('/admin') !!}">
                    <i class="zmdi zmdi-home"></i><span>{!! __('dashboard.homePage') !!}</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <em class="zmdi zmdi-pin-drop"></em>
                    <span>{!! __('dashboard.trips') !!}</span>
                </a>
                <ul class="ml-menu">
                    <li><a href="{!! url('admin/trips') !!}">{!! __('dashboard.trips') !!}</a></li>
                    <li><a href="{!! url('admin/customers') !!}">{!! __('dashboard.customers') !!}</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <em class="zmdi zmdi-accounts"></em>
                    <span>{!! __('dashboard.users') !!}</span>
                </a>
                <ul class="ml-menu">
                    <li><a href="{!! url('admin/users') !!}">{!! __('dashboard.users') !!}</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <em class="zmdi zmdi-settings"></em>
                    <span>{!! __('dashboard.settings') !!}</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="{!! url('admin/vehicles_types') !!}">
                            {!! __('dashboard.vehicles_types') !!}
                        </a>
                    </li>
                    <li>
                        <a href="{!! url('admin/settings/1/edit') !!}">{!! __('dashboard.settings') !!}</a>
                    </li>
                    <li>
                        <a disabled="true" href="{!! url('admin/pages') !!}">{!! __('dashboard.pages') !!}</a>
                    </li>
{{--                    <li>--}}
{{--                        <a disabled="true"--}}
{{--                           href="{!! url('admin/notifications') !!}">{!! __('dashboard.notifications') !!}</a>--}}
{{--                    </li>--}}
                    <li>
                        <a disabled="true" href="{!! url('admin/countries') !!}">{!! __('dashboard.countries') !!}</a>
                    </li>
                    <li>
                        <a disabled="true" href="{!! url('admin/colors') !!}">{!! __('dashboard.colors') !!}</a>
                    </li>
                    <li>
                        <a disabled="true" href="{!! url('admin/contact_us') !!}">{!! __('dashboard.contact_us') !!}</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside>
