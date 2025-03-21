<div class="row mb-2">
    <div class="col-md-3">
        {!! Form::label('name_ar',trans('dashboard.name_ar'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-3">
        {!! Form::text('name_ar',$resource->name_ar ?? '',['class'=>'form-control']) !!}
        <span class="error error_name_ar text-danger float-left"></span>
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-3">
        {!! Form::label('name_en',trans('dashboard.name_en'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-3">
        {!! Form::text('name_en',$resource->name_en ?? '',['class'=>'form-control']) !!}
        <span class="error error_name_en text-danger float-left"></span>
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-3">
        {!! Form::label('governorates_id',trans('dashboard.governorate'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-3">
        {!! Form::select('governorates_id',$governorates ?? [],$resource->governorates_id ?? '',['class'=>'form-control']) !!}
        <span class="error error_governorates_id text-danger float-left"></span>
    </div>
</div>
