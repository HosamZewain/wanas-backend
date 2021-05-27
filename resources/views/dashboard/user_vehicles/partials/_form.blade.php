<div class="row mb-2">
    <div class="col-md-3">
        {!! Form::label('color',trans('dashboard.color'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-3">
        {!! Form::text('color',null,['class'=>'form-control']) !!}
        {!! Form::hidden('user_id',$user_id) !!}
        @error('color')
        <label id="color-error" class="error text-danger float-left" for="color">{{ $message }}</label>
        @enderror
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-3">
        {!! Form::label('number',trans('dashboard.number'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-3">
        {!! Form::text('number',null,['class'=>'form-control']) !!}
        @error('number')
        <label id="number-error" class="error text-danger float-left" for="number">{{ $message }}</label>
        @enderror
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-3">
        {!! Form::label('model',trans('dashboard.model'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-3">
        {!! Form::text('model',null,['class'=>'form-control']) !!}
        @error('model')
        <label id="model-error" class="error text-danger float-left" for="model">{{ $message }}</label>
        @enderror
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-3">
        {!! Form::label('type',trans('dashboard.type'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-3">
        {!! Form::select('type',$types,null,['class'=>'form-control  show-tick','data-live-search'=>'true','placeholder'=>'إختر نوع']) !!}
        @error('type')
        <label id="type-error" class="error text-danger float-left" for="type">{{ $message }}</label>
        @enderror
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-3">
        {!! Form::label('image',trans('dashboard.image'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-3">
        {!! Form::file('image',['class'=>'form-control']) !!}
        @error('image')
        <label id="image-error" class="error text-danger float-left" for="image">{{ $message }}</label>
        @enderror
    </div>
</div>
