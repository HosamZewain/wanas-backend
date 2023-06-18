<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">
        {!! __('dashboard.confirm_user_details') !!}
    </h5>
    <button type="button" class="close float-left" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
{!! Form::open([
    'method'=>'post',
    'files'=>true,
     'id'=>'form-submit',
     'reload'=>1,
     'class'=>'form-horizontal',
     'route'=>['customers.verify'
     ]]) !!}
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
    </div>
</div>

<div class="modal-footer">
    <div class="row">
        <div class="col-md-12">
            {!! Form::submit(__('dashboard.confirm'),['class'=>'btn btn-primary float-right']); !!}
        </div>
    </div>
</div>

{!! Form::close() !!}

<script>
    $('.disabledInputs').attr('disabled', true);
</script>
