@extends('website.layouts.app')

@section('content')
    <!--  Start Header  -->
    <header id="header">
        <!-- menu -->
        <div class="mainNav">
            <div class="container">
                <div class="menuBar d-flex d-md-none justify-content-between align-items-center">
                    <a href="{!! url('/') !!}">
                        <img src="{!! asset('website/assets/img/whiteLogo.png') !!}"
                             data-src="{!! asset('website/assets/img/whiteLogo.png') !!}"
                             class="logo lazyload"
                             alt="logo">
                    </a>
                    <div class="toggle">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="overlay"></div>
                <div class="menu d-flex flex-wrap align-items-center justify-content-end">
                    <ul class="menuLinks" data-aos="fade-zoom-in">
                        <li class="active">
                            <a aria-current="page" href="#header">الرئيسية</a>
                        </li>
                        <li><a href="#about">عن ونس</a></li>
                        <!-- <li>
                            <a href="#appScreens">شاشات التطبيق</a>
                        </li> -->
                        <li><a href="#contactUs">تواصل معنا</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container h-100 position-relative zIndex1 text-white">
            <div class="row flex-column-reverse flex-md-row h-100 align-items-center">
                <div class="col-md-6">
                    <img src="{!! asset('website/assets/img/whiteLogo.png') !!}"
                         data-src="{!! asset('website/assets/img/whiteLogo.png') !!}" alt="logo"
                         class="headerLogo lazyload">
                    <h1 class="fw-bold ps-md-3 ps-lg-5 fs37">شارك سفـــرك ورحلتــك.</h1>
                    <p class="ps-md-3 ps-lg-5 fs14">تطبيق ونس رفيق الطريق، لمشاركة السيارات في السفر والرحلات</p>

                    <!-- <form class="row g-3 ps-md-3 ps-lg-5 mt-4">
                        <div class="col-auto">
                            <input type="email" class="form-control" placeholder="بريدك الإلكتروني">
                        </div>
                        <div class="col-auto mb-5 mb-md-0">
                            <button type="submit" class="btn btn-orange text-white mb-3">إشترك</button>
                        </div>
                    </form> -->
                    <div
                        class="d-flex flex-wrap justify-content-center justify-content-md-start ps-md-3 ps-lg-5 mt-4 mb-5 pb-4">
                        <a href="https://play.google.com/store/apps/details?id=com.roqay.wanas">
                            <img src="{!! asset('website/assets/img/google.png') !!}"
                                 data-src="{!! asset('website/assets/img/google.png') !!}"
                                 class="downloadLinks lazyload me-3" alt="google play">
                        </a>
                        <a href="https://apps.apple.com/ee/app/%D9%88%D9%86-%D8%B3/id1599241085">
                            <img src="{!! asset('website/assets/img/apple.png') !!}"
                                 data-src="{!! asset('website/assets/img/apple.png') !!}"
                                 class="downloadLinks lazyload" alt="app store">
                        </a>

                    </div>

                </div>
                <div class="col-md-6">
                    <img src="{!! asset('website/assets/img/mobiles.png') !!}"
                         data-src="{!! asset('website/assets/img/mobiles.png') !!}" alt="mobiles"
                         class="headerPhones lazyload">
                </div>
            </div>

        </div>

    </header>

    <!--end header-->

    <!-- start waves -->
    <div class="waveShape">
        <img src="{!! asset('website/assets/img/waves.png') !!}"
             data-src="{!! asset('website/assets/img/waves.png') !!}" class="headerWaves lazyload" alt="wave">
    </div>
    <!-- end waves -->

    <!-- start about wanas  -->
    <div id="about">
        <div class="container">
            <div class="row align-items-center flex-wrap-reverse flex-md-wrap">
                <div class="col-md-4 position-relative">
                    <img src="{!! asset('website/assets/img/phone.pn') !!}g"
                         data-src="{!! asset('website/assets/img/phone.png') !!}" class="aboutPhone lazyload"
                         alt="phone">
                    <img src="{!! asset('website/assets/img/shapes.png') !!}"
                         data-src="{!! asset('website/assets/img/shapes.png') !!}" class="shapes lazyload"
                         alt="shape">
                </div>
                <div class="col-md-8 pe-3 ps-3 pe-md-5">
                    <h5 class="mainTitle fw-bold">
                        عن ونس
                    </h5>
                    <h5 class="text-primary my-3 fw-bold">
                        ازاي ممكن تستفيد من ونس؟
                    </h5>
                    <p>
                        لو معاك عربية وبتسافر في اي مكان تقدر تنزل الرحلة وتستفيد ان ناس تركب معاك وتشارك معاك تكاليف
                        الرحلة لو مش معاك عربية وبتسافر تقدر تشوف حد قريب منك بيسافر للمكان الي عاوزه وتركب معاه وتوفر
                        علي نفسك قرف ووجع دماغ المواصلات. تقدر تشوف حد تشارك معاه او يشاركك سفر دوري زي السفر اليومي
                        للعمل وخلافه. ازاي نضمن الشخص الي هيركب معانا او هنركب معاه؟
                        تطبيق ونس فيه اكتر منطريقة لعمل Verification. مثلا مينفعش حد يشترك في رحلة الا لو حسابة مؤكدبرقم
                        الموبايل وصورة شخصية وبطاقة شخصي. ومينفعش حد ينزل رحلة علي التطبيق الا لو حسابة مؤكد كصاحب سيارة
                        ودا بيحصل برفع بيانات معينة اضافية زي صور ومعلومات السيارة ورخصة القيادة
                        ورخصة العربية.وطبعا البيانات الحساسة كلها زي رخص القيادة والبطاقة الشخصية بتستخدم
                        لتأكيد الحسابات فقط ومش بتظهر في التطبيق وبيظهر بس علي بروفايل كل
                        شخص معلوماته العامة Ratings بتاعته والرحلات السابقة.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- start about wanas  -->

    <!-- start download App  -->
    <div class="downloadApp pt-5">
        <div class="container position-relative zIndex1 text-white">
            <div class="row">
                <div class="col-md-6 d-flex flex-column justify-content-center pb-5">
                    <h4 class="fw-bold">حمل التطبيق</h4>
                    <p>هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة،
                        لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد
                        مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.</p>
                    <div class="d-flex flex-wrap">

                        <a href="https://play.google.com/store/apps/details?id=com.roqay.wanas">
                            <img src="{!! asset('website/assets/img/google.png') !!}"
                                 data-src="{!! asset('website/assets/img/google.png') !!}"
                                 class="downloadLinks lazyload me-3" alt="google play">
                        </a>
                        <a href="https://apps.apple.com/ee/app/%D9%88%D9%86-%D8%B3/id1599241085">
                            <img src="{!! asset('website/assets/img/apple.png') !!}"
                                 data-src="{!! asset('website/assets/img/apple.png') !!}"
                                 class="downloadLinks lazyload" alt="app store">
                        </a>

                    </div>
                </div>
                <div class="col-md-6 d-flex justify-content-end pe-5">
                    <img src="{!! asset('website/assets/img/handPhone.png') !!}"
                         data-src="{!! asset('website/assets/img/handPhone.png') !!}" class="handPhone lazyload"
                         alt="phone">
                </div>
            </div>
        </div>
    </div>
    <!-- end download App  -->

    <!-- start appScreens -->
    <!-- <div id="appScreens" class="py-5">
    <div class="container">
        <div class="text-center">
            <h5 class="mainTitle top50 fw-bold">
                لقطات شاشة التطبيقات
            </h5>
        </div>

        <div class="images-wrapper" data-aos="zoom-in">
            <img src="assets/img/frame.png" data-src="{!! asset('website/assets/img/frame.png') !!}" class="lazyload frameImg" />
            <div id="waterwheel-carousel" class="images-slider">
                <div class="image-item item" id="item-1">
                    <a data-fancybox="gallery" class="fancybox" href="assets/img/1.png">
                        <img src="assets/img/1.png" data-src="{!! asset('website/assets/img/1.png') !!}" class="lazyload" />
                    </a>
                </div>
                <div class="image-item item" id="item-2">
                    <a data-fancybox="gallery" class="fancybox" href="assets/img/2.png">
                        <img src="assets/img/2.png" data-src="{!! asset('website/assets/img/2.png') !!}" class="lazyload" />
                    </a>
                </div>
                <div class="image-item item" id="item-3">
                    <a data-fancybox="gallery" class="fancybox" href="assets/img/3.png">
                        <img src="assets/img/3.png" data-src="{!! asset('website/assets/img/3.png') !!}" class="lazyload" />
                    </a>
                </div>
                <div class="image-item item" id="item-4">
                    <a data-fancybox="gallery" class="fancybox" href="assets/img/4.png">
                        <img src="assets/img/4.png" data-src="{!! asset('website/assets/img/4.png') !!}" class="lazyload" />
                    </a>
                </div>
                <div class="image-item item" id="item-5">
                    <a data-fancybox="gallery" class="fancybox" href="assets/img/5.png">
                        <img src="assets/img/5.png" data-src="{!! asset('website/assets/img/5.png') !!}" class="lazyload" />
                    </a>
                </div>
            </div>
            <div class="mt-4 text-center">
                <div class="btn-group">
                    <a href="#" class="mx-2" id="prev">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="#" class="mx-2" id="next">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div> -->
    <!-- end appScreens -->

    <!-- start contactUs -->
  @include('website.contactUs')
@endsection
