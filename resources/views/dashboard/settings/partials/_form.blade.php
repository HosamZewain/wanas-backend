<div class="row mb-2">
    <div class="col-md-3">
        {!! Form::label('app_name',trans('dashboard.app_name'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-3">
        {!! Form::text('app_name',null,['class'=>'form-control']) !!}
        @error('title')
        <label id="app_name-error" class="error text-danger float-left" for="app_name">{{ $message }}</label>
        @enderror
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-3">
        {!! Form::label('mobile',trans('dashboard.mobile'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-3">
        {!! Form::text('mobile',null,['class'=>'form-control']) !!}
        @error('title')
        <label id="mobile-error" class="error text-danger float-left" for="mobile">{{ $message }}</label>
        @enderror
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-3">
        {!! Form::label('email',trans('dashboard.email'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-3">
        {!! Form::text('email',null,['class'=>'form-control']) !!}
        @error('email')
        <label id="mobile-error" class="error text-danger float-left" for="email">{{ $message }}</label>
        @enderror
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-3">
        {!! Form::label('logo',trans('dashboard.logo'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-3">
        {!! Form::file('logo',['class'=>'form-control']) !!}
        @error('logo')
        <label id="logo-error" class="error text-danger float-left" for="logo">{{ $message }}</label>
        @enderror
    </div>
    @if (!empty($resource->logo))
        <div class="col-md-3">
            <img src="{!!  asset('storage/' . $resource->logo) !!}" alt=""/>
        </div>
    @endif
</div>
<div class="row mb-2">
    <div class="col-md-3">
        {!! Form::label('about',trans('dashboard.about'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-9">
        {!! Form::textarea('about',null,['class'=>'form-control','rows'=>2]) !!}
        @error('about')
        <label id="about-error" class="error text-danger float-left" for="about">{{ $message }}</label>
        @enderror
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-3">
        {!! Form::label('terms_conditions',trans('dashboard.terms_conditions'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-9">
        {!! Form::textarea('terms_conditions',null,['class'=>'form-control','rows'=>4]) !!}
        @error('terms_conditions')
        <label id="terms_conditions-error" class="error text-danger float-left" for="terms_conditions">{{ $message }}</label>
        @enderror
    </div>
</div>
