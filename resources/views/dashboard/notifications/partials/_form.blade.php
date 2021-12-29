<div class="row mb-2 ">
    <div class="col-md-3">
        {!! Form::label('user_id',trans('dashboard.customers'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-9">
        {!! Form::select('user_id[]',$customers??[],'',['class'=>'form-control selectPicker ms','placeholder'=>'Select','multiple'=>'true']) !!}
        @error('user_id')
        <label id="title-error" class="error text-danger float-left" for="user_id">{{ $message }}</label>
        @enderror
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-3">
        {!! Form::label('title',trans('dashboard.title'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-9">
        {!! Form::text('title',null,['class'=>'form-control']) !!}
        @error('title')
        <label id="title-error" class="error text-danger float-left" for="title">{{ $message }}</label>
        @enderror
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-3">
        {!! Form::label('body',trans('dashboard.body'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-9">
        {!! Form::textarea('body',null,['class'=>'form-control']) !!}
        @error('body')
        <label id="body-error" class="error text-danger float-left" for="body">{{ $message }}</label>
        @enderror
    </div>
</div>
