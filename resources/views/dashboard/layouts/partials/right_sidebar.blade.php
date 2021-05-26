
<!-- right_sidebar  -->
<aside id="leftsidebar" class="sidebar">
    <div class="navbar-brand">
        <button class="btn-menu ls-toggle-btn" type="button">
            <i class="zmdi zmdi-menu"></i>
        </button>
        <a href="{!! url('/') !!}">
            <img src="{!! asset('dashboard/assets/images/logo.svg') !!}" width="25" alt="Aero">
            <span class="m-l-10">لوحة التحكم</span>
        </a>
    </div>
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    <a class="image" href="profile.html">
                        <img src="{!! asset('dashboard/assets/images/profile_av.jpg') !!}" alt="User">
                    </a>
                    <div class="detail">
                        <h4>خالد الوكيل</h4>
                        <small>المدير العام</small>
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
                        <a disabled="true" href="{!! url('/') !!}">{!! __('dashboard.app_settings') !!}</a>
                    </li>
                    <li>
                        <a disabled="true" href="{!! url('/') !!}">{!! __('dashboard.settings') !!}</a>
                    </li>
                    <li>
                        <a disabled="true" href="{!! url('admin/pages') !!}">{!! __('dashboard.pages') !!}</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside>
