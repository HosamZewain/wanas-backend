$(document).ready(function () {


    $(window).on("scroll", function () {
        if ($(window).scrollTop() > 50) {
            $(".mainNav").addClass("changeBg");
        } else {
            //remove the background property so it comes transparent again
            $(".mainNav").removeClass("changeBg");
        }
    });

    $('.menuLinks a').on('click', function (e) {
        $(this).parent().siblings().removeClass('active');
        $(this).parent().addClass('active');
        var href = $(this).attr('href');
        $('html, body').animate({
            scrollTop: $(href).offset().top - 50
        }, 500);
        e.preventDefault();
    });

    // toggle menu
    $("header .toggle").click(function () {
        $(".overlay").css({
            "transform": "scaleX(1)"
        });

        $(".menu").addClass('ulDir');

    });

    $("header .overlay").click(function () {
        $(this).removeAttr("style");
        $(".menu").removeClass("ulDir");
    });



    var carousel = $(".images-slider").waterwheelCarousel({

        separation: 220,
        edgeFadeEnabled: true,
        opacityMultiplier: 1, // determines how drastically the opacity of each item changes
        horizon: 0, // how "far in" the horizontal/vertical horizon should be set from the container wall. 0 for auto
        flankingItems: 2, // the number of items visible on either side of the center                 

        // animation
        speed: 500, // speed in milliseconds it will take to rotate from one to the next
        animationEasing: 'linear', // the easing effect to use when animating
        quickerForFurther: true, // set to true to make animations faster when clicking an item that is far away from the center
        edgeFadeEnabled: false, // when true, items fade off into nothingness when reaching the edge. false to have them move behind the center image

        // misc
        autoPlay: 1500, // indicate the speed in milliseconds to wait before autorotating. 0 to turn off. Can be negative
        orientation: 'horizontal', // indicate if the carousel should be 'horizontal' or 'vertical'
        activeClassName: 'carousel-center', // the name of the class given to the current item in the center
        keyboardNav: true, // set to true to move the carousel with the arrow keys
        keyboardNavOverride: true, // set to true to override the normal functionality of the arrow keys (prevents scrolling)
        // preloader
        preloadImages: true, // disable/enable the image preloader.
        forcedImageWidth: 280, // specify width of all images; otherwise the carousel tries to calculate it
        forcedImageHeight: 500, // specify height of all images; otherwise the carousel tries to calculate it

    });


    $('#prev').on('click', function () {
        carousel.prev();
        return false
    });

    $('#next').on('click', function () {
        carousel.next();
        return false;
    });



    function initiateAnimation() {
        AOS.init({
            delay: 500, // values from 0 to 3000, with step 50ms
            duration: 900, // values from 0 to 3000, with step 50ms
            easing: "ease-out-back" // default easing for AOS animations
        });

        if ($(window).width() < 560) {
            AOS.init({
                once: true
            });
        }
    }
    initiateAnimation();

    //scroll top
    var scrollButton = $("#scroll-top");
    $(window).scroll(function () {
        if ($(this).scrollTop() >= 700) {
            scrollButton.fadeIn(1000);
        } else {
            scrollButton.fadeOut(1000);
        }
    });

    //click to scroll top
    scrollButton.click(function () {
        $('html,body').animate({
            scrollTop: 0
        }, 600);
    });

});