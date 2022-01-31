<div class="row mb-2">
    <div class="col-md-3">
        {!! Form::label('name',trans('dashboard.name'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-3">
        {!! Form::text('name',null,['class'=>'form-control']) !!}
        @error('name')
        <label id="name-error" class="error text-danger float-left" for="name">{{ $message }}</label>
        @enderror
    </div>
    <div class="col-md-3">
        {!! Form::label('email',trans('dashboard.email'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-3">
        {!! Form::email('email',null,['class'=>'form-control']) !!}
        @error('email')
        <label id="email-error" class="error text-danger float-left" for="email">{{ $message }}</label>
        @enderror
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-3">
        {!! Form::label('mobile',trans('dashboard.mobile'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-3">
        {!! Form::number('mobile',null,['class'=>'form-control']) !!}
        @error('mobile')
        <label id="mobile-error" class="error text-danger float-left" for="mobile">{{ $message }}</label>
        @enderror
    </div>
    <div class="col-md-3">
        {!! Form::label('birth_date',trans('dashboard.birth_date'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-3">
        {!! Form::date('birth_date',null,['class'=>'form-control']) !!}
        @error('birth_date')
        <label id="birth_date-error" class="error text-danger float-left" for="birth_date">{{ $message }}</label>
        @enderror
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-3">
        {!! Form::label('country_id',trans('dashboard.country_id'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-3">
        {!! Form::select('country_id',$countries->pluck('LName','id')->toArray(),$resource->country_id ?? null,['class'=>'form-control']) !!}
        @error('birth_date')
        <label id="birth_date-error" class="error text-danger float-left" for="birth_date">{{ $message }}</label>
        @enderror
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-3">
        {!! Form::label('password',trans('dashboard.password'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-3">
        {!! Form::password('password',['class'=>'form-control']) !!}
        @error('password')
        <label id="password-error" class="error text-danger float-left" for="password">{{ $message }}</label>
        @enderror
    </div>
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
                                                <span> أخر تعديل</span>
                                                : {!! $attachment->updated_at !!}</small>
                                            <br>
                                            <small class="text-muted statusText{!! $attachment->id !!}">
                                                <span>أخر حالة</span>
                                                : {!! __('enums.attachment_status')[$attachment->status] !!}
                                            </small>
                                            <br>
                                        </p>
                                        {!! Form::text('status_text',$attachment->status_text,
                                                ['class'=>'form-control','id'=>'statusText'.( $attachment->id ),'placeholder'=>'ملاحظات....']) !!}
                                        <div class="row actionButtons_{!! $attachment->id !!}"
                                             @if($attachment->status == \App\Models\Attachment::STATUS_APPROVED) style="display: none" @endif>
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
                    </div>
                @endforeach
            </div>
        </fieldset>
    </div>
@endif
