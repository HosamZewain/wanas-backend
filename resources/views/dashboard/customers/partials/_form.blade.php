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
</div>
<div class="row mb-2">
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
<div class="row mb-2">

    <div class="col-md-4">
        <fieldset>
            <legend>{!! trans('dashboard.profile_image') !!}</legend>
            <img class="img-fluid w-50" src="{!! asset('storage/' . $resource->profile_image) !!}" alt=""/>
        </fieldset>
    </div>
    <div class="col-md-4">
        <fieldset>
            <legend>{!! trans('dashboard.civil_image_front') !!}</legend>
            <img class="img-fluid w-50" src="{!! asset('storage/' . $resource->civil_image_front) !!}" alt=""/>
        </fieldset>
    </div>
    <div class="col-md-4">
        <fieldset>
            <legend>{!! trans('dashboard.civil_image_back') !!}</legend>
            <img class="img-fluid w-50" src="{!! asset('storage/' . $resource->civil_image_back) !!}" alt=""/>
        </fieldset>
    </div>
</div>
