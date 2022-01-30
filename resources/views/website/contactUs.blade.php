<div id="contactUs" class="py-5 position-relative">
    <img src="{!! asset('website/assets/img/send.png') !!}" data-src="{!! asset('website/assets/img/send.png') !!}"
         class="lazyload send1" alt=""/>
    <img src="{!! asset('website/assets/img/send.png') !!}" data-src="{!! asset('website/assets/img/send.png') !!}"
         class="lazyload send2" alt=""/>
    <img src="{!! asset('website/assets/img/send.png') !!}" data-src="{!! asset('website/assets/img/send.png') !!}"
         class="lazyload send3" alt=""/>
    <div class="container">
        <div class="text-center">
            <h5 class="mainTitle top50 fw-bold my-3">
                تواصــــل معنــا
            </h5>
        </div>
        <div class="row bg-white py-4 px-3 px-md-5 mt-3 mb-4 mx-0 br25 flex-column-reverse flex-md-row">
            <div class="col-md-6">
                <h6 class="fw-bold mb-3">أرسل رسالتك</h6>
                {!! Form::open([
                 'method'=>'post',
                 'files'=>true,
                 'id'=>'form-submit',
                 'reload'=>1,
                 'class'=>'w-100',
                 'route'=>['website.ContactUsStore']]) !!}
                <div class="mb-3">
                    {!! Form::text('name',null,['class'=>'form-control w-100 bg-formControl border-0','placeholder'=>'الاسم بالكامل']) !!}
                    <span class="error error_name text-danger float-left"></span>
                </div>
                <div class="mb-3">
                    {!! Form::email('email',null,['class'=>'form-control w-100 bg-formControl border-0','placeholder'=>' البريد الإلكترونى']) !!}
                    <span class="error error_email text-danger float-left"></span>
                </div>
                <div class="mb-3">
                    {!! Form::text('subject',null,['class'=>'form-control w-100 bg-formControl border-0','placeholder'=>'الموضوع']) !!}
                    <span class="error error_subject text-danger float-left"></span>
                </div>
                <div class="mb-3">
                    {!! Form::textarea('body',null,['class'=>'form-control w-100 bg-formControl border-0','rows'=>6,'placeholder'=>' رسالتك هنا...... ']) !!}
                    <span class="error error_body text-danger float-left"></span>
                </div>
                <div class="d-flex align-items-center justify-content-around justify-content-md-end">
                    <button type="submit" class="btn btn-orange text-white px-5 mt-3 mb-2">أرسل الرسالة</button>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="col-md-6 d-flex justify-content-end align-items-center">
                <img src="{!! asset('website/assets/img/contactUS.png') !!}"
                     data-src="{!! asset('website/assets/img/contactUS.png') !!}"
                     class="lazyload contactUSImg" alt=""/>
            </div>
        </div>

    </div>
</div>
