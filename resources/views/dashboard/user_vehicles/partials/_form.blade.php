<div class="row mb-2">
    <div class="col-md-3">
        {!! Form::label('color',trans('dashboard.color'), ['class' => 'form-label']) !!}
    </div>
    <div class="col-md-3">
        {!! Form::text('color',$resource->color ?? null,['class'=>'form-control']) !!}
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
        {!! Form::text('number',$resource->number ?? null,['class'=>'form-control']) !!}
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
        {!! Form::text('model',$resource->model ?? null,['class'=>'form-control']) !!}
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
        {!! Form::select('type',$types,$resource->type ?? null,['class'=>'form-control  show-tick','data-live-search'=>'true','placeholder'=>'إختر نوع']) !!}
        @error('type')
        <label id="type-error" class="error text-danger float-left" for="type">{{ $message }}</label>
        @enderror
    </div>
    <hr>
    <div class="row mb-2">
        <div class="col-md-3">
            {!! Form::label('image',trans('dashboard.image'), ['class' => 'form-label']) !!}
        </div>
        @if(isset($resource) && count($resource->attachments))
            @foreach ($resource->attachments as $attachment)
                <div class="col-md-3">
                    <a data-fancybox="gallery" href="{!!asset('storage/' .$attachment['attachment_url'])  !!}">
                        <img class="img-fluid" src="{!! asset('storage/'.$attachment['attachment_url']) !!}" alt=""/>
                    </a>

                </div>
            @endforeach
        @else
            <div class="col-md-3">
                {!! Form::file('image',['class'=>'form-control']) !!}
                @error('image')
                <label id="image-error" class="error text-danger float-left" for="image">{{ $message }}</label>
                @enderror
            </div>
        @endif
    </div>

    <hr>
    <div class="row mb-2">
        <div class="col-md-3">
            {!! Form::label('car_license_front',trans('dashboard.car_license_front'), ['class' => 'form-label']) !!}
        </div>
        <div class="col-md-3">
            @if(isset($resource))
                <a data-fancybox="gallery" href="{!!asset('storage/' .$resource['car_license_front'])  !!}">
                    <img class="img-fluid" src="{!! asset('storage/'.$resource['car_license_front']) !!}" alt=""/>
                </a>
            @endif
        </div>
        <div class="col-md-3">
            {!! Form::label('car_license_back',trans('dashboard.car_license_back'), ['class' => 'form-label']) !!}
        </div>
        <div class="col-md-3">
            @if(isset($resource))
                <a data-fancybox="gallery" href="{!!asset('storage/' .$resource['car_license_back'])  !!}">
                    <img class="img-fluid" src="{!! asset('storage/'.$resource['car_license_back']) !!}" alt=""/>
                </a>
            @endif
        </div>
    </div>

    <hr>
    <div class="row mb-2">
        <div class="col-md-3">
            {!! Form::label('driver_license_front',trans('dashboard.driver_license_front'), ['class' => 'form-label']) !!}
        </div>
        <div class="col-md-3">
            @if(isset($resource))
                <a data-fancybox="gallery" href="{!!asset('storage/' .$resource['driver_license_front'])  !!}">
                    <img class="img-fluid" src="{!! asset('storage/'.$resource['driver_license_front']) !!}"
                         alt=""/>
                </a>
            @endif
        </div>
        <div class="col-md-3">
            {!! Form::label('driver_license_back',trans('dashboard.driver_license_back'), ['class' => 'form-label']) !!}
        </div>
        <div class="col-md-3">
            @if(isset($resource))
                <a data-fancybox="gallery" href="{!!asset('storage/' .$resource['driver_license_back'])  !!}">
                    <img class="img-fluid" src="{!! asset('storage/'.$resource['driver_license_back']) !!}" alt=""/>
                </a>
            @endif
        </div>
    </div>
