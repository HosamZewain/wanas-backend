$(function () {

	"use strict";

	var scrollButton = $("#scroll-top");
	// sticky menu
	$(window).on("scroll", function () {
		if ($(window).scrollTop() > 60) {
			$(".main-navbar").addClass("fixed-top").animate({
				top: 0,
			}, 4000)
		} else {
			$(".main-navbar").removeClass("fixed-top").animate({
				top: 0,
			}, 4000)
		}
		// scroll top
		if ($(this).scrollTop() >= 700) {
			scrollButton.fadeIn(1000)
		} else {
			scrollButton.fadeOut(1000)
		}
	});
	scrollButton.on('click', function () {
		$('html,body').animate({
			scrollTop: 0
		}, 600)
	});

	// slide up any dropdown on document click
	$(document).on('click touchstart', function (e) {
		e.stopPropagation();
		var dropTarg = $(e.target).closest('.main-header .dropdown').length;
		if (!dropTarg) {
			$('.main-header .dropdown').removeClass('show');
		}
		if (window.matchMedia('(min-width: 992px)').matches) {
			var navTarg = $(e.target).closest('.main-navbar .nav-item').length;
			if (!navTarg) {
				$('.main-navbar .show').removeClass('show');
			}
			var menuTarg = $(e.target).closest('.main-header-menu .nav-item').length;
			if (!menuTarg) {
				$('.main-header-menu .show').removeClass('show');
			}
			if ($(e.target).hasClass('main-menu-sub-mega')) {
				$('.main-header-menu .show').removeClass('show');
			}
		}
		var sidebarTarg = $(e.target).closest('.sidebar').length;
		if ($(e.target).is(".main-header .header-settings a , .main-header .header-settings i, .sidebar") === false && !sidebarTarg) {
			if ($('.sidebar').hasClass('sidebar-open')) {
				console.log(e.target)
				$('.sidebar.sidebar-open').removeClass('sidebar-open');
			}
		}
		let sideSetting = $(".sideSetting");
		if (!sideSetting.is(e.target) && sideSetting.has(e.target).length === 0)
		{
			sideSetting.removeClass('sidebar-open');
		}
	});

	if (window.matchMedia('(min-width: 992px)').matches) {
		$('.main-navbar .active').removeClass('show');
		$('.main-header-menu .active').removeClass('show');
	}

	// toggle header dropdown

	$(document).on('click', '.main-header .dropdown > a', function (e) {
		e.preventDefault();
		$(this).parent().toggleClass('show');
		$(this).parent().siblings().removeClass('show');
	});

	// Full screen
	$(document).on("click", ".fullscreen-button", function toggleFullScreen() {
		$('html').addClass('fullscreenie');
		if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
			if (document.documentElement.requestFullScreen) {
				document.documentElement.requestFullScreen();
			} else if (document.documentElement.mozRequestFullScreen) {
				document.documentElement.mozRequestFullScreen();
			} else if (document.documentElement.webkitRequestFullScreen) {
				document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
			} else if (document.documentElement.msRequestFullscreen) {
				document.documentElement.msRequestFullscreen();
			}
		} else {
			$('html').removeClass('fullscreenie');
			if (document.cancelFullScreen) {
				document.cancelFullScreen();
			} else if (document.mozCancelFullScreen) {
				document.mozCancelFullScreen();
			} else if (document.webkitCancelFullScreen) {
				document.webkitCancelFullScreen();
			} else if (document.msExitFullscreen) {
				document.msExitFullscreen();
			}
		}
	})

	// submenu
	$(document).on('click', '.main-navbar .subMenu', function (e) {
		e.preventDefault();
		$(this).parent().toggleClass('show');
		$(this).parent().siblings().removeClass('show');
	});

	//toggle side menu navbar
	$(document).on('click', '#mainNavShow', function(e) {
		e.preventDefault();

        if($(this).closest('.with-side-menu').length == 1){
			if($(window).innerWidth() <= '991.98'){
				$('body').addClass('main-navbar-show');
			} else{
				$('body').toggleClass('main-sidebar-hide');
			}
		}
		else
			$('body').addClass('main-navbar-show');
	});

    $(document).on('click', '#azNavbarShow', function(e) {
		e.preventDefault();
		$('body').addClass('main-navbar-show');
	});

	$('body').append('<div class="main-navbar-backdrop"></div>');

	$('.main-navbar-backdrop').on('click touchstart', function() {
		$('body').removeClass('main-navbar-show');
	});
	//side-menu

	// sidebar
	$(document).on('click', '.main-header .header-settings a , .sidebar-icon', function (e) {
		e.preventDefault();
		$('.sidebar').toggleClass('sidebar-open');
	});

	// side settings
	$(document).on('click', '.sideSetting .cog-icon', function (e) {
		e.preventDefault();
		$('.sideSetting').toggleClass('sidebar-open');
	});

	// switch between menu style
	$(document).on('click', '.menu-mode a', function(){
		if($(this).hasClass('hor-menu')){
			$('.main-body').removeClass('main-sidebar-hide');
			$('.main-header').removeClass('with-side-menu');
			$('.main-navbar').removeClass('side-menu main-sidebar-sticky');
			$('.main-content').removeClass('side-content')
		}
		else if($(this).hasClass('vertical-menu')){
			$('.main-header').addClass('with-side-menu');
			$('.main-navbar').addClass('side-menu main-sidebar-sticky');
			$('.main-content').addClass('side-content');
			$('.side-menu').unbind('hover');
		}
	})
	// switch between theme color mode
	const toggleDark = document.querySelector('.toggle-dark');
	const togglelight = document.querySelector('.toggle-light');

	function switchTheme(e) {
		if (e.target.checked && e.target.className == 'form-check-input toggle-dark') {
			document.documentElement.setAttribute('data-theme', 'dark');
		} else {
			document.documentElement.setAttribute('data-theme', 'light');
		}
	}

	// toggleDark.addEventListener('change', switchTheme);
	// togglelight.addEventListener('change', switchTheme);

	// colored header
	$(document).on('click', '#coloredHeader', function (e) {
		if ($(this).is(':checked')) {
			$('body').addClass('color-header');
			$('body').removeClass('gradient-header');
			$('.main-header').removeClass('bg-gradient-primary');
			$('body').removeClass('color-horizontal');
			$('body').removeClass('dark-horizontal');
			$('body').removeClass('gradient-horizontal');
			$('.main-navbar').removeClass('bg-gradient-primary');
		}
	});

	// gradient header
	$(document).on('click', '#gradientHeader', function (e) {
		if ($(this).is(':checked')) {
			$('body').addClass('gradient-header');
			$('.main-header').addClass('bg-gradient-primary');
			$('body').removeClass('color-header');
			$('body').removeClass('color-horizontal');
			$('body').removeClass('dark-horizontal');
			$('body').removeClass('gradient-horizontal');
			$('.main-navbar').removeClass('bg-gradient-primary');
		}
	});

	// reset header
	$(document).on('click', '#resetHeader', function (e) {
		if ($(this).is(':checked')) {
			$('body').removeClass('color-header');
			$('body').removeClass('gradient-header');
			$('.main-header').removeClass('bg-gradient-primary');
			$('body').removeClass('color-horizontal');
			$('body').removeClass('dark-horizontal');
			$('body').removeClass('gradient-horizontal');
			$('.main-navbar').removeClass('bg-gradient-primary');
		}
	});

	// colored menu
	$(document).on('click', '#coloredMenu', function (e) {
		if ($(this).is(':checked')) {
			$('body').addClass('color-horizontal');
			$('body').removeClass('color-header');
			$('body').removeClass('gradient-header');
			$('.main-header').removeClass('bg-gradient-primary');
			$('body').removeClass('dark-horizontal');
			$('body').removeClass('gradient-horizontal');
			$('.main-navbar').removeClass('bg-gradient-primary');
		}
	});

	// dark menu
	$(document).on('click', '#darkMenu', function (e) {
		if ($(this).is(':checked')) {
			$('body').addClass('dark-horizontal');
			$('body').removeClass('color-header');
			$('body').removeClass('gradient-header');
			$('.main-header').removeClass('bg-gradient-primary');
			$('body').removeClass('color-horizontal');
			$('body').removeClass('gradient-horizontal');
			$('.main-navbar').removeClass('bg-gradient-primary');
		}
	});

	// gradient menu
	$(document).on('click', '#gradientMenu', function (e) {
		if ($(this).is(':checked')) {
			$('body').addClass('gradient-horizontal');
			$('.main-navbar').addClass('bg-gradient-primary');
			$('body').removeClass('color-header');
			$('body').removeClass('gradient-header');
			$('.main-header').removeClass('bg-gradient-primary');
			$('body').removeClass('color-horizontal');
			$('body').removeClass('dark-horizontal');
		}
	});


	//tooltip
	$('[data-toggle="tooltip"]').tooltip();



})
