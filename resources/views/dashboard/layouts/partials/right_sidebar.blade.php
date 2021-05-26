
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
                    <i class="zmdi zmdi-home"></i><span>الرئيسية</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <em class="zmdi zmdi-pin-drop"></em>
                    <span>الرحلات</span>
                </a>
                <ul class="ml-menu">
                    <li><a href="{!! url('admin/trips') !!}">الرحلات</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <em class="zmdi zmdi-accounts"></em>
                    <span>المستخدمين</span>
                </a>
                <ul class="ml-menu">
                    <li><a href="{!! url('admin/users') !!}">المستخدمين</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <em class="zmdi zmdi-settings"></em>
                    <span>الإعدادات</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a disabled="true" href="{!! url('/') !!}">اعدادات التطبيق<</a>
                    </li>
                </ul>
                <ul class="ml-menu">
                    <li>
                        <a disabled="true" href="{!! url('/') !!}">اعدادات النظام<</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside>
