@extends('dashboard.layouts.app')

@section('content')
<div class="block-header">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
            <h2>لوحة التحكم</h2>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{!! url('/') !!}"><i class="zmdi zmdi-home"></i> الرئيسية</a>
                </li>
                <li class="breadcrumb-item active">التطبيق</li>
            </ul>
            <button class="btn btn-primary btn-icon mobile_menu" type="button">
                <i class="zmdi zmdi-sort-amount-desc"></i>
            </button>
        </div>
        <div class="col-lg-5 col-md-6 col-sm-12">
            <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-3 col-md-6 col-sm-6 col-6 text-center">
            <div class="card">
                <div class="body">
                    <input type="text" class="knob" value="42" data-linecap="round" data-width="100" data-height="100" data-thickness="0.08" data-fgColor="#00adef" readonly>
                    <p>عدد المستخدمين</p>
                    {{--  <div class="d-flex bd-highlight text-center mt-4">
                        <div class="flex-fill bd-highlight">
                            <small class="text-muted">فعال</small>
                            <h5 class="mb-0">254</h5>
                        </div>
                        <div class="flex-fill bd-highlight">
                            <small class="text-muted">غير فعال</small>
                            <h5 class="mb-0">254</h5>
                        </div>
                    </div>  --}}
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>أخر   <strong>الرحلات</strong> </h2>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover c_table">
                        <thead>
                            <tr>
                                <th style="width:60px;">#</th>
                                <th>إسم المستخدم</th>
                                <th>نقطة الإنطلاق</th>
                                <th>نقطة الوصول</th>
                                <th>التاريخ</th>
                                <th>الوقت</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>12</td>
                                <td>Hossein</td>
                                <td>IPONE-7</td>
                                <td>Porterfield 508 Virginia Street Chicago, IL 60653</td>
                                <td>3</td>
                                <td><span class="badge badge-success">DONE</span></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
