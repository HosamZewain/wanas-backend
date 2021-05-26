@extends('dashboard.layouts.app',[
    'breadcrumb_1'=>trans('dashboard.users'),
    //'add_link'=>'admin/users/create',
 //   'add_link_text'=>'Add New User',
    ])
@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-3 col-md-6 col-sm-6 col-6 text-center">
            <div class="card">
                <div class="body">
                    <label>
                        <input type="text" class="knob" value="42" data-linecap="round" data-width="100" data-height="100" data-thickness="0.08" data-fgColor="#00adef" readonly>
                        عدد المستخدمين
                    </label>
                    <div class="d-flex bd-highlight text-center mt-4">
                        <div class="flex-fill bd-highlight">
                            <small class="text-muted">فعال</small>
                            <h5 class="mb-0">254</h5>
                        </div>
                        <div class="flex-fill bd-highlight">
                            <small class="text-muted">غير فعال</small>
                            <h5 class="mb-0">254</h5>
                        </div>
                    </div>
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
