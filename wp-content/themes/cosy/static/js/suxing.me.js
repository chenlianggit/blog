/*
* @Author: suxingme
* @Date:   2017-08-24 00:26:28
* @Last Modified by:   suxingme
* @Last Modified time: 2017-11-17 23:36:32
*/
jQuery(document).ready(function($) {
    if ('addEventListener' in document) {  
        document.addEventListener('DOMContentLoaded', function() {  
            FastClick.attach(document.body);  
        }, false);  
    } 
    $(window).on('load', function()  {
        $(".main-preloader").length && (
            $(".main-preloader").addClass("window-is-loaded"), 
            setTimeout(function() {
                $(".main-preloader").remove()
            },
        650))
    });

});

var $window, 
    $html, 
    $pageHeader, 
    $pageHeader_height,  
    $window_height, 
    $pageWrapper,  
    $localStorage, 
    $window_width,
    $searchHeader,
    $searchHeader_height;

function variables() {
    $window              = $(window);
    $pageWrapper         = $(".site");
    $pageHeader          = $(".nt-header");
    $searchHeader        = $(".mobile-search");
    $window_height       = $window.height();
    $window_width        = $window.width();
    $pageHeader_height   = $pageHeader.outerHeight();
    $searchHeader_height = $searchHeader.outerHeight();
};


/* 
	Sticky Menu 
	----------------------------------------------------
*/

function stickyHeader(){
    if ($pageHeader.is(".nt-header")) {
        var sticky       = $('.nt-header'),
            scroll       = $window.scrollTop();

        if ( scroll > $pageHeader_height ) {

            sticky.addClass('fixed');
            $pageWrapper.css("margin-top", $pageHeader_height);


        } else {
            sticky.removeClass('fixed');
            $pageWrapper.removeAttr("style");
        }
    }
};

function scrollTop() {
    var scroll     = $window.scrollTop(),
        startPoint = $window_height / 2,
        scrTopBtn  = $(".scroll-to-top");
    if ( scroll >= startPoint && $window_width >= 1024  ) {
        scrTopBtn.addClass('active');

    } else {
        scrTopBtn.removeClass('active');
    }
    scrTopBtn.on("click", function () {
        $("html, body").stop().animate({
            scrollTop: 0
        }, 
        600);
    });
};

/*
    post style03-04 cover height 
    ----------------------------------------------------
*/  
function postcoverHeight() {
    var $postcover_height = $window_height - $pageHeader_height;
    if ($("body").hasClass("post-style03") && $window_width < 768 ){
        $('.post-cover').height($postcover_height);
    }
};

jQuery(document).scroll(function ($) {
    stickyHeader();
    scrollTop();
});

jQuery(document).ready(function($) {

	variables();
    postcoverHeight();

	if( globals.home != 0 ){
	    $('.nt-slider').owlCarousel({
	        items:1,
	        loop:true,
	        nav:true,
	        smartSpeed:1200,
	        autoplay:true,
	        autoplayTimeout:5000,
            autoplayHoverPause:true,
	        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
	        responsive:{
                0:{
                    nav:false,
                },
                992:{
                    nav:true,
                }
            }
	    });
	    $('.nt-featured-posts').owlCarousel({
	        margin:10,
            loop:true,
            nav:false,
            dots:false,
            responsiveClass:true,
            responsive:{
                0:{
                    items:2,
                    center: false,
                    loop:false,
                    margin:5,
                    nav:true,
                    navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                },
                480:{
                    items:2,
                    center: false,
                    loop:false,
                    margin:5,
                    nav:true,
                    navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                },
                768:{
                    items:2,
                    center: false,
                    loop:false,
                    margin:5,
                    nav:true,
                    navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                },
                992:{
                    items:3,
                    center: false,
                    margin:10,
                    loop:false
                    
                },
                1170:{
                    items:4,
                    margin:14,
                    loop:false
                }

            }
	    });

        $('.topic-grid').owlCarousel({
            loop:true,
            smartSpeed:800,
            responsiveClass:true,
            responsive:{
                0:{
                    margin:5,
                    items:2,
                    dots:true,
                    nav:false
                },
                768:{
                    items:1,
                    dots:true,
                    nav:false
                },
                1000:{
                    items:1,
                    dots:true,
                    nav:true,
                    navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
                }
            }

        });


	}
    if( globals.single != 0 && globals.post_style == 'five' ){ 
        var owl = $('.post-slide');
        owl.owlCarousel({      
            items:1,
            smartSpeed:1050,
            loop:false,
            dots:true,
            nav:true,
            videoHeight:true,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']

        });
    }

    if( globals.single != 0 && globals.post_style == 'one' || globals.post_style == 'two' || globals.post_style == 'three' || globals.post_style == 'six'){

        /* 
            Sticky Sidebar
            -------------------------------------------------------
        */
        $('.l-sidebar').theiaStickySidebar({
            additionalMarginTop: 90
        });
    }

	/*
		navbar-nav	
		----------------------------------------------------
	*/				
	$(".navbar-nav li:has(>ul)").addClass("has-children");

	if ($(".navbar-nav li").hasClass("has-children")){
	    $(".navbar-nav li.has-children").prepend('<span class="fa fa-angle-down"></span>')
	}

	$('#mobile-menu-icon').on('click touchstart', function (e){
        e.preventDefault();
        var $navigation_height = $window_height - $searchHeader_height;
        $('.mobile-navigation').css({'height':$navigation_height});
        $('#mobile-overlay').addClass('open');
        $('body').addClass('mobile-open');
       
    });
    $('#mobile-close-icon').on('click touchstart', function (e) {
        e.preventDefault();
        $('#mobile-overlay').removeClass('open');
        $('body').removeClass('mobile-open');
        $('.mobile-navigation').css({'height':'auto'});

    });

    /*
        mobile-bigger-cover  
        ----------------------------------------------------
    */  

    if( $window_width < 768 ){

        $(".btn-open-share").on('click touchstart', function (e) {
            e.preventDefault();
            $('.bigger-share').addClass('open');
            $('.btn-open-share').hide();
            $('.btn-close').hide();
            $('.btn-close-share').show();
        });
    	$(".btn-close-share").on('click touchstart', function (e) {
            e.preventDefault();
            $('.btn-close-share').hide();
            $('.bigger-share').removeClass('open');
            $('.bigger-share').addClass('close');
            $('.btn-open-share').show();
            $('.btn-close').show();
            setTimeout(function(){
                $('.bigger-share').removeClass('close');
            },200);
           
        });
    }
    /*
        mobile-navbar-Scrollbar  
        ----------------------------------------------------
    */    

    $(".mobile-navigation").mCustomScrollbar({
        theme:"minimal-dark",
        mouseWheel:{scrollAmount:188,normalizeDelta:true}
    });

	
	


	/* 
		Search Form Animation 
		----------------------------------------------------
	*/


    $('#navbar-search-submit').click(function() {
        if (!$('body').hasClass('search-opened-removing')) {
            $('body').addClass('search-opened');
            $(this).parent().children('input').focus();
        }
    });
    $('.searchform.header-search').focusout(function(){
        $('body').removeClass('search-opened').addClass('search-opened-removing');
            setTimeout(function () {
                $('body').removeClass('search-opened-removing');
                $('#navbar-search-submit').removeClass('icon-close');
                
        }, 300);
    });


    /*
        comment
        ----------------------------------------------------
    */  
    $('#comment').focus(function(){
        $('.form-captcha').fadeIn(300);
    })
            
    var changeMsg = "<i>[ 资料修改 ]</i>";
    var closeMsg = "<i>[ 收起来 ]</i>";
    function toggleCommentAuthorInfo() {
        $('.form-comment-info').fadeToggle(300,function(){
            if ( $('.form-comment-info').css('display') == 'none' ) {
                $('#toggle-comment-author-info').html(changeMsg);
            } else {
                $('#toggle-comment-author-info').html(closeMsg);
            }
        });
    }
    $(document).ready(function(){
        if( $('#author').val() == '' ){
            $('.form-comment-info').show();
        }else{
            $('.form-comment-info').hide();
        }
    });         

});

