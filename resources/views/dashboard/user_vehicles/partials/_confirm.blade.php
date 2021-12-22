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
 'redirect'=>route('user_vehicles.index',['user_id'=>$resource->user_id]),
 'class'=>'form-horizontal',
 'route'=>['user_vehicles.confirm']]) !!}
<div class="modal-body">
    {!! Form::hidden('vehicle_id',$resource->id) !!}
    @include('dashboard.user_vehicles.partials._form')
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-primary">
        {!! __('dashboard.approve') !!}
    </button>
    <button type="button" class="btn btn-danger" data-dismiss="modal">
        {!! __('dashboard.closeText') !!}
    </button>
</div>
{!! Form::close() !!}

<script>
    $('.disabledInputs').attr('disabled', true);
</script>
