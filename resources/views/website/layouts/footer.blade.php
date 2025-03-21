<footer class="text-center pt-4">
    <div class="container pb-5">
        <img src="{!! asset('website/assets/img/footerLogo.png') !!}"
             data-src="{!! asset('website/assets/img/footerLogo.png') !!}" class="lazyload footerLogo"
             alt="logo"/>
        <ul class="social mt-3">
            <!-- <li>
                <a href="#">
                    <i class="fab fa-instagram"></i>
                </a>
            </li>
            <li>
                <a href="#" class="mx-2">
                    <i class="fab fa-twitter"></i>
                </a>
            </li> -->
            <li>
                <a href="https://www.facebook.com/wanasappcom">
                    <i class="fab fa-facebook-f"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="copyRight bg-white fs15 p-3 text-center">
        {!! __('website.copy_rights') !!}
        <a href="https://www.roqay.com/" class="d-inline-flex footLink">
            {!! __('website.roqay') !!}
        </a>
        {!! \Carbon\Carbon::now()->format('Y') !!}
    </div>
</footer>
<!-- end footer -->

<!-- start scroll-top-->
<div id="scroll-top" class="text-center">
    <i class="fas fa-angle-up"></i>
</div>
<!-- end scroll-top-->
