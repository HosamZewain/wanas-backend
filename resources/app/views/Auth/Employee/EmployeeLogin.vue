<template>
    <div class="main-wrapper">
        <main id="main-content">
            <div class="container-fluid">
                <div class="row no-gutters">
                    <div class="col-md-7 col-sm-12">
                        <div class="logo text-center my-5">
                            <img :src="`${publicPath}/web/assets/images/logo.png`" data-src="assets/images/logo.png" alt=""
                                class="logo-img ls-is-cached lazyloaded">
                        </div>
                        <h1 class="main-heder font-segoeui-bold text-center text-primary mb-5">Welcome To ROMS</h1>
                        <p class="text-center main-p font-segoeui-bold text-primary mb-5">roqay operations mangement
                            system</p>
                        <div class="btns d-flex justify-content-center">
                            <a href="" class="btn btn-white buzz-out-on-hover font-segoeui-bold round mx-2"
                                style="font-size: 22px;font-weight: 900;">Client Support Portal</a>
                        </div>


                        <div class="ormain text-center my-4">
                            <span class="or">OR</span>
                        </div>
                        <div class="social-media d-flex justify-content-center">
                            <a href="https://play.google.com/store/apps/details?id=com.roqayapp" class="btn-social  mx-2">
                                <img :src="`${publicPath}/web/assets/images/Group_33.png`"
                                    data-src="assets/images/Group_33.png" alt="" class="ls-is-cached lazyloaded"></a>
                            <a href="https://apps.apple.com/us/app/roqay/id1489567976" class="btn-social mx-2"> <img
                                    :src="`${publicPath}/web/assets/images/Group_34.png`"
                                    data-src="assets/images/Group_34.png" alt="" class=" ls-is-cached lazyloaded"></a>
                        </div>
                        <a href="" class=" buzz-out-on-hover round mx-2"
                            style="text-align: center;COLOR: #fff;display: block;margin: 22px 4px 6px 0px;text-decoration: revert;">
                            How To Use</a>
                    </div>

                    <!-- image -->
                    <div class="col-md-5  d-none d-sm-none d-md-block">
                        <img :src="`${publicPath}/web/assets/images/img.png`" data-src="assets/images/img.png" alt=""
                            class="side-img ls-is-cached lazyloaded w-100 h-100">
                    </div>

                </div>
                <div class="Emp-Portal">
                    <a href="/auth/redirect" class="buzz-out-on-hover round mx-2" style=" display: flex;
                                justify-content: center;align-items: center; position: fixed; bottom: 40px;left: 13px;
                                text-align: center;font-size: 14px;z-index: 200;
                                                    padding: 4px;color: fff;text-decoration: revert;
                                                    ">Employee Portal </a>
                </div>
            </div>
        </main>
    </div>
</template>
<script>

</script>
