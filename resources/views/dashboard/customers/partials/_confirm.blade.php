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
 'redirect'=>route('customers.index'),
 'class'=>'form-horizontal',
 'route'=>['customers.confirm']]) !!}
<div class="modal-body">
    <div class="row mb-2 ">
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
        <div class="col-md-4">
            {!! Form::label('profile_image',trans('dashboard.profile_image'), ['class' => 'form-label']) !!}
        </div>
        <div class="col-md-8">
            <img class="img-fluid w-50" src="{!! asset('storage/' . $resource->profile_image) !!}"/>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary">
        {!! __('dashboard.approve') !!}
    </button>
    <button type="button" class="btn btn-danger" data-dismiss="modal">
        {!! __('dashboard.disapprove') !!}
    </button>
</div>
{!! Form::close() !!}

<script>
    $('.disabledInputs').attr('disabled', true);
</script>
