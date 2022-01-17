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
        {!! Form::label('country_id',trans('dashboard.country'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-3">
        {!! Form::select('country_id',$countries ?? [],$resource->country_id ?? '',['class'=>'form-control','placeholder'=>__('dashboard.country')]) !!}
        <span class="error error_country_id text-danger float-left"></span>
    </div>
</div>
