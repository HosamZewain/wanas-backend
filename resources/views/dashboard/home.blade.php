@extends('dashboard.layouts.app',[
    'breadcrumb_1'=>trans('dashboard.users'),
    //'add_link'=>'admin/users/create',
 //   'add_link_text'=>'Add New User',
    ])
@section('content')
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-md-12 col-lg-9 col-xl-9">
                <div class="card">
                    <div class="body" dir="rtl">
                        <div id="trips_calendar"></div>
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-6 text-center">
                <div class="card w_data_1">
                    <div class="body">
                        <div class="w_icon indigo"><i class="zmdi zmdi-accounts"></i></div>
                        <h4 class="mt-3">{!! $customers_count ?? 0 !!}</h4>
                        <span class="text-muted">عدد العملاء</span>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mt-3">{!! $active_customers_count ?? 0 !!}</h6>
                                <small class="text-muted">مفعلين</small>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mt-3">{!! $not_active_customers_count ?? 0 !!}</h6>
                                <small class="text-muted">غير مفعلين</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card w_data_1">
                    <div class="body">
                        <div class="w_icon pink"><i class="zmdi zmdi-pin-drop"></i></div>
                        <h4 class="mt-3">{!! $trips_count ?? 0 !!}</h4>
                        <span class="text-muted">عدد الرحلات</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Edit Modal popup -->
    <div class="modal fade" id="eventEditModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">بيانات الرحلة</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            المسار
                        </div>
                        <div class="col-md-9" id="pick_address"></div>
                        <div class="col-md-3">
                            اسم السائق
                        </div>
                        <div class="col-md-9" id="userName"></div>
                        <div class="col-md-3">
                            التاريخ
                        </div>
                        <div class="col-md-9" id="start"></div>
                        <div class="col-md-3">
                            وقت الرحلة
                        </div>
                        <div class="col-md-9" id="Time"></div>
                        <div class="col-md-3">
                            تكلفة الحجز
                        </div>
                        <div class="col-md-9" id="CostPerPerson"></div>
                        <div class="col-md-3">
                            تكلفة الرحلة
                        </div>
                        <div class="col-md-9" id="TotalCost"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.7.0/main.min.js"
            integrity="sha256-vB0AxkwD8fMGdgwuIfLl+VhH2pFA0ZtJdAJe4OHRKcs=" crossorigin="anonymous"></script>
    <script
        src="https://cdn.jsdelivr.net/combine/npm/fullcalendar@5.7.0/main.js,npm/fullcalendar@5.7.0/locales-all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.7.0/main.js"
            integrity="sha256-UYwUI07v3ZaBPEu6HOJIokV15Zeh2Xj/bGT+MxtA0l0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.7.0/locales-all.min.js"
            integrity="sha256-6TW9hevn9VV+Dk6OtclSzIjH05B6f2WWhJ/PQgy7m7s=" crossorigin="anonymous"></script>

    <script>
        const calendarEl = document.getElementById('trips_calendar');
        //  const calendar = $('#trips_calendar');
        const appData = @json($trips);
        const objs = appData.map(function (x) {
            const userName = (x['user']) ? x['user']['name'] : 'user';
            return {
                title: x['pickup_address'] + '-' + x['drop_off_address'],
                start: x['trip_date'] + 'T' + x['trip_time'],
                allDay: false,
                className: 'bg-default',
                extendedProps: {
                    userName: userName,
                    Date: x['trip_date'],
                    Time: x['trip_time'],
                    CostPerPerson: x['trip_cost_per_person'],
                    TotalCost: x['total_trip_cost'],
                }
            };
        });
        console.log(objs);
        document.addEventListener('DOMContentLoaded', function () {
            const tripsCalendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                themeSystem: 'Flatly',
                editable: false,
                locale: 'ar',
                rtl: true,
                droppable: false,
                eventLimit: true, // allow "more" link when too many events
                selectable: false,
                timeZone: 'local', // the default (unnecessary to specify)
                events: objs,
                eventClick: function (calEvent, jsEvent, view) {
                    console.log(calEvent);
                    //  const title = prompt('Event Title:', calEvent.title, {buttons: {Ok: true, Cancel: false}});
                    const eventModal = $('#eventEditModal');
                    eventModal.modal('show');
                    eventModal.find('#pick_address').html(calEvent.event.title);
                    eventModal.find('#start').html(calEvent.event.extendedProps.Date);
                    eventModal.find('#userName').html(calEvent.event.extendedProps.userName);
                    eventModal.find('#Time').html(calEvent.event.extendedProps.Time);
                    eventModal.find('#CostPerPerson').html(calEvent.event.extendedProps.CostPerPerson);
                    eventModal.find('#TotalCost').html(calEvent.event.extendedProps.TotalCost);
                }
            });
            tripsCalendar.setOption('locale', 'ar');
            tripsCalendar.render();
        });

    </script>
@endpush
