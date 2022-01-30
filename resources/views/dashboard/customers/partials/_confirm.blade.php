<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">
        {!! __('dashboard.confirm_user_details') !!}
    </h5>
    <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
{!! Form::open([ 'method'=>'post','files'=>true, 'id'=>'form-submit','reload'=>'1','class'=>'form-horizontal','route'=>['customers.confirm']]) !!}
<div class="modal-body">
    <div class="row mb-2 ">
        {!! Form::hidden('customer_id',$resource->id) !!}
        <div class="col-md-4">
            {!! Form::label('name',trans('dashboard.name'), ['class' => 'form-label']) !!}
        </div>
        <div class="col-md-8">
            {!! Form::text('name',$resource->name ?? '',['class'=>'form-control disabledInputs']) !!}
        </div>
        <div class="col-md-4">
            {!! Form::label('email',trans('dashboard.email'), ['class' => 'form-label']) !!}
        </div>
        <div class="col-md-8">
            {!! Form::email('email',$resource->email ?? '',['class'=>'form-control disabledInputs']) !!}
        </div>
        <div class="col-md-4">
            {!! Form::label('mobile',trans('dashboard.mobile'), ['class' => 'form-label']) !!}
        </div>
        <div class="col-md-8">
            {!! Form::number('mobile',$resource->mobile ?? '',['class'=>'form-control disabledInputs']) !!}
        </div>
        @if(count($resource->attachments))
            <div class="col-md-12">
                <fieldset>
                    <legend>{!! trans('dashboard.attachments') !!}</legend>
                    <div class="row">
                        @foreach($resource->attachments as $attachment)
                            <div class="col-md-12">
                                <div
                                    class="card mb-3 bg-light  @if($attachment->status == \App\Models\Attachment::STATUS_APPROVED) border-success  @else border-danger @endif">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <a data-fancybox="gallery" href="{!! $attachment->full_url !!}">
                                                <img class="img-fluid img-thumbnail w-100" style="max-height: 150px;"
                                                     src="{!! $attachment->full_url !!}" alt=""/>
                                            </a>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title  text-white bg-secondary p-2">{!! __('enums.attachment_keys')[$attachment->key] !!}</h5>
                                                <p class="card-text">
                                                    <small class="text-muted">
                                                        أخر تعديل
                                                        : {!! $attachment->updated_at !!}</small>
                                                    <br>
                                                    <small class="text-muted statusText{!! $attachment->id !!}">
                                                        أخر حالة
                                                        : {!! __('enums.attachment_status')[$attachment->status] !!}
                                                    </small>
                                                    <br>
                                                </p>
                                                {!! Form::text('status_text',$attachment->status_text,
['class'=>'form-control','id'=>'statusText'.( $attachment->id ),'placeholder'=>'ملاحظات....']) !!}
                                                <a onclick="approve('approve','{!! $attachment->id !!}')"
                                                   class="btn btn-success approve  text-white">
                                                    تأكيد
                                                    <i class="far fa-thumbs-up"></i>
                                                </a>
                                                <a onclick="approve('disapprove','{!! $attachment->id !!}')"
                                                   class="btn btn-danger disapprove text-white">
                                                    رفض
                                                    <i class="far fa-thumbs-down"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </fieldset>
            </div>
        @endif
    </div>
</div>
{!! Form::close() !!}

<script>
    $('.disabledInputs').attr('disabled', true);
</script>
<script>
    function approve(status, id) {
        event.preventDefault();
        const route = '{!! route('customers.attachments.change_status') !!}';
        const csrf_token = '{!! csrf_token() !!}';
        const userId = '{!! (auth()->check())  ? auth()->user()->id : 0 !!}';
        const statusText = $('#statusText' + id).val();
        // Does some stuff and logs the event to the console
        $.ajax({
            url: route,
            type: "GET",
            _method: 'GET',
            data: {
                id: id,
                _token: csrf_token,
                csrf_token: csrf_token,
                status: status,
                statusText: statusText,
            },
            dataType: 'json',
            processData: true,
            contentType: false,
            success: function (data) {
                console.log(data);
                $('.statusText' + id).html(data.data.status_translated);
                $.dialog({
                    title: 'أحسنت',
                    content: data.msg,
                    theme: 'modern',
                    type: 'green',
                    typeAnimated: true,
                    closeIcon: true,
                    autoClose: 'close|3000',
                });


            }, error: function (data) {
                console.log(data.data);
                $.alert({
                    title: SomeThingWrong,
                    content: data.msg,
                    theme: 'modern',
                    type: 'red',
                    typeAnimated: true,
                    closeIcon: true,
                    autoClose: 'close|3000',
                    buttons: {
                        close: {
                            title: closeText,
                            // $.alert('action is canceled');
                        }
                    },
                });
            }
        })
    }
</script>
