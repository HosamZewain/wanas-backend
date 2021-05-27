<div class="row mb-2">
    <div class="col-md-3">
        {!! Form::label('name',trans('dashboard.name'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-3">
        {!! Form::text('name',null,['class'=>'form-control']) !!}
        @error('title')
        <label id="name-error" class="error text-danger float-left" for="name">{{ $message }}</label>
        @enderror
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-3">
        {!! Form::label('logo',trans('dashboard.logo'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-9">
        {!! Form::file('logo',['class'=>'form-control']) !!}
        @error('logo')
        <label id="logo-error" class="error text-danger float-left" for="logo">{{ $message }}</label>
        @enderror
    </div>
</div>
