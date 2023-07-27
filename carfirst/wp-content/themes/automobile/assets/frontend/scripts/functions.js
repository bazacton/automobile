/* ------------------------------- Chimp Solutions All Funtions Start ------------------------------- */
(function($) {



    /* ------------------------------- Document Rready Funtions Start ------------------------------- */

    $(document).ready(function() {
        //		
        //		$( "#target-list" ).click(function() {
        //			if ($('.cs-main-nav').hasClass("'col-lg-4', 'col-md-4', 'col-sm-6', 'col-xs-12'")) {
        //					$('.cs-main-nav').removeClass("'col-lg-4', 'col-md-4', 'col-sm-6', 'col-xs-12'");
        //			} else {
        //				$('.cs-main-nav').addClass("'col-lg-4', 'col-md-4', 'col-sm-6', 'col-xs-12'");
        //				}
        //			});
        //		$( "#target-grid" ).click(function() {
        //			if ($('.cs-main-nav').hasClass("'col-lg-12', 'col-md-12', 'col-sm-12', 'col-xs-12'")) {
        //					$('.cs-main-nav').removeClass("'col-lg-12', 'col-md-12', 'col-sm-12', 'col-xs-12'");
        //			}else {
        //				$('.cs-main-nav').addClass("'col-lg-12', 'col-md-12', 'col-sm-12', 'col-xs-12'");
        //				}
        //			});	
        //		

$('#user-forgot-pass').on('shown.bs.modal', function (e) {
 
  $(document.body).addClass('modal-open-2 model-open');


});

$('#user-forgot-pass').on('hidden.bs.modal', function (e) {
  
  $(document.body).removeClass('modal-open-2 model-open');

});

$('#join-us').on('shown.bs.modal', function (e) {
  
  $(document.body).addClass('modal-open-2 model-open');

});

$('#join-us').on('hidden.bs.modal', function (e) {
  
  $(document.body).removeClass('modal-open-2 model-open');

});


$('#sign-in').on('shown.bs.modal', function (e) {
  
  $(document.body).addClass('modal-open-2 model-open');

});

$('#sign-in').on('hidden.bs.modal', function (e) {
  
  $(document.body).removeClass('modal-open-2 model-open');

});


$('#request-more-info').on('shown.bs.modal', function (e) {
  
  $(document.body).addClass('modal-open-2 model-open');

});

$('#request-more-info').on('hidden.bs.modal', function (e) {
  
  $(document.body).removeClass('modal-open-2 model-open');

});

$('#schedule-test-drive').on('shown.bs.modal', function (e) {
  
  $(document.body).addClass('modal-open-2 model-open');

});

$('#schedule-test-drive').on('hidden.bs.modal', function (e) {
  
  $(document.body).removeClass('modal-open-2 model-open');

});

$('#make-an-Offer').on('shown.bs.modal', function (e) {
  
  $(document.body).addClass('modal-open-2 model-open');

});

$('#make-an-Offer').on('hidden.bs.modal', function (e) {
  
  $(document.body).removeClass('modal-open-2 model-open');

});

$('#email-to-friend').on('shown.bs.modal', function (e) {
  
  $(document.body).addClass('modal-open-2 model-open');

});

$('#email-to-friend').on('hidden.bs.modal', function (e) {
  
  $(document.body).removeClass('modal-open-2 model-open');

});

        if (jQuery(".blog-detail-slider").length != '') {
            $('.blog-detail-slider').addClass("slider-loader");
            setTimeout(function() {
                $('.slider-loader').fadeOut("slow", function() {
                    $(this).removeClass("slider-loader");
                });
                $('.blog-detail-slider').fadeIn();
            }, 5000);
        }

        if (jQuery(".cs-banner-slider").length != '') {
            $('.cs-banner-slider').addClass("slider-loader")
            setTimeout(function() {
                $('.slider-loader').fadeOut("slow", function() {
                    $(this).removeClass("slider-loader");
                });
                $('.cs-banner-slider').fadeIn();
            }, 5000);
        }

        if (jQuery(".cs-detail-slider").length != '') {
            $('.cs-detail-slider').addClass("slider-loader")
            setTimeout(function() {
                $('.slider-loader').fadeOut("slow", function() {
                    $(this).removeClass("slider-loader");
                });
                $('.cs-detail-slider').fadeIn();
            }, 5000);
        }

        if (jQuery(".blog-medium-slider").length != '') {
            $('.blog-medium-slider').addClass("slider-loader")
            setTimeout(function() {
                $('.slider-loader').fadeOut("slow", function() {
                    $(this).removeClass("slider-loader");
                });
                $('.blog-medium-slider').fadeIn();
            }, 5000);
        }
        if (jQuery(".cs-auto-box-slider").length != '') {
            $('.cs-auto-box-slider').wrap("<div class='destination-slider-loader'></div>");

        }
        if (jQuery(".cs-auto-box-slider").length != '') {
            $('.cs-auto-box-slider').addClass("slider-loader")
            setTimeout(function() {
                $('.slider-loader').fadeOut("slow", function() {
                    $(this).removeClass("slider-loader");
                });
                $('.cs-auto-box-slider').fadeOut("slow", function() {
                    $(this).fadeIn("slow").unwrap();
                });
            }, 5000);
        }

        if (jQuery(".blog-listing-grid-slider").length != '') {
            $('.blog-listing-grid-slider').addClass("slider-loader")
            setTimeout(function() {
                $('.slider-loader').fadeOut("slow", function() {
                    $(this).removeClass("slider-loader");
                });
                $('.blog-listing-grid-slider').fadeIn();
            }, 5000);
        }



//        // detail post slider
//       if (jQuery(".post-slider").length != '') {
//     
//     function fixArrows() {
//		var sliderWidth =  ($('.post-slider').width());
//			
//        var f = ($('.slick-active:first').find("img").width());
//        $('.slick-prev').css('width', f + 'px');
//        var s = ($('.slick-active:eq(1)').find("img").width());
//        l = f + (s);
//        w = $("body").prop("scrollWidth") - 0;
//        l =  w- l;
//        $('.slick-next').css('width', l + 'px');
//    
//    }
//    $('.post-slider').slick({
//        dots: false,
//        infinite: true,
//        speed: 300,
//        slidesToShow: 1,
//        variableWidth: true,
//        swipe: false,
//        centerMode: true,
//    })
//    $('.post-slider').on('setPosition', function (slick) {
//        fixArrows();
//    }).trigger('setPosition')
//    $('.post-slider').on('setPosition', function (slick) {
//        fixArrows();
//    }).trigger('afterChange')
//	$('.post-slider').on('setPosition', function (slick) {
//        fixArrows();
//    }).trigger('reInit')
//
//    $(".post-slider").click(function () {
//        fixArrows();
//    })
// }

        // Chosen touch support.
        if ($('.chosen-container').length > 0) {
            $('.chosen-container').on('touchstart', function(e) {
                e.stopPropagation();
                e.preventDefault();
                // Trigger the mousedown event.
                $(this).trigger('mousedown');
            });
        }
		
    disableClassSelect = ".cs-login-form .input-holder,"+
                         ".main-search .select-dropdown,"+
                         ".main-search .select-location,"+
                         ".logged-in .cs-field-holder,"+
						 ".cs-dealer-field,"+
                         ".main-search .search-input";
                    
    disableToggleClasses =  ".cs-login-form .input-holder,"+
                            ".main-search .select-dropdown,"+
                            ".main-search .select-location,"+
                            ".main-search .search-btn,"+
                            ".logged-in .cs-field-holder,"+
							".cs-dealer-field-btn,"+
							".cs-dealer-field label,"+
                            ".main-search .search-input";

    jQuery(document).on('click', disableClassSelect, function (event) {
    event.preventDefault();
    event.stopPropagation();
    jQuery(disableToggleClasses).toggleClass("disable-search");
    });

    jQuery(document).click(function (e) {
    if (jQuery(".disable-search").length > 0) {
        jQuery(".disable-search").removeClass("disable-search");
    }
        if (jQuery(".disable-select").length > 0) {
        jQuery(".disable-select").removeClass("disable-select");
    }
    });

    jQuery(document).click(function (e) {
    if (jQuery(".disable-search").length <= 0) {
        jQuery(".disable-search").removeClass("disable-search");
    }
    });

        /*
         * Responsive Menu
         */
        if (jQuery(".main-navigation>ul").length != '') {
            jQuery('.main-navigation>ul').slicknav();
        }



        /*  bootstrap-slider */
        if (jQuery("#price").length != '') {
            $("#price").slider({});
        }
        if (jQuery("#engine").length != '') {
            $("#engine").slider({});
        }

        $('[data-toggle="tooltip"]').tooltip();


        /*If Condition counter Start*/
        if (jQuery(".counter").length != '') {
            jQuery('.counter').counterUp({
                delay: 10,
                time: 1000
            });
        }

        /*If Condition Counter End*/


        /* 
         * Start Sticky Side Bar
         */


        /*If Condition Start*/
        if (jQuery(".cs-banner-slider").length != '') {
            jQuery('.cs-banner-slider').slick({
                dots: false,
                arrows: true,
                swipeToSlide: true,
                infinite: true,
                speed: 1000,
                autoplay: true,
                autoplaySpeed: 2000,
                slidesToShow: 3,
                slidesToScroll: 1,
                responsive: [{
                        breakpoint: 1170,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                            infinite: true
                        }
                    }, {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    }, {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ]
            });
        }
        /*If Condition End*/


        /*If Condition Start*/
        if (jQuery(".cs-auto-box-slider").length != '') {
            jQuery(".cs-auto-box-slider").slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                swipeToSlide: true,
                autoplay: true,
                autoplaySpeed: 2000,
                dots: false,
                infinite: true,
                responsive: [{
                        breakpoint: 1024,
                        settings: {}
                    }, {
                        breakpoint: 800,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    }, {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }

                ]
            });
        }
        /*If Condition End*/

        /*If Condition Client Slider Start*/
        if (jQuery(".cs-logo-slider").length != '') {

            $('.cs-logo-slider').slick({
                dots: false,
                infinite: false,
                speed: 300,
                slidesToShow: 6,
                slidesToScroll: 1,
                arrows: false,
                autoplay: true,
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 6,
                        }
                    }, {
                        breakpoint: 700,
                        settings: {
                            slidesToShow: 3,
                        }
                    }, {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                        }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ]
            });

        }
        /*If Condition Client Slider End*/

        /* ------------------------------- Blog Listing grid view slider start ------------------------------- */
        if (jQuery(".blog-listing-grid-slider").length != '') {
            $('.blog-listing-grid-slider').slick({
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
            });
        }
        /* ------------------------------- Blog Listing grid view slider End --------------------------------- */


        /* ------------------------------- Blog Listing large view slider start ------------------------------- */
        if (jQuery(".blog-listing-large-slider").length != '') {
            $('.blog-listing-large-slider').slick({
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
            });
        }

        /* ------------------------------- Blog Listing large view slider End --------------------------------- */


        /* ------------------------------- Blog Listing medium view slider start ------------------------------- */
        if (jQuery(".blog-medium-slider").length != '') {
            $('.blog-medium-slider').slick({
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
            });
        }
        /* ------------------------------- Blog Listing medium view slider End --------------------------------- */


        /* ------------------------------- Blog Detail slider start ------------------------------- */
        if (jQuery(".blog-detail-slider").length != '') {
            $('.blog-detail-slider').slick({
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
            });
        }
        /* ------------------------------- Blog Detail slider End --------------------------------- */

        /* 
         * Btn Top
         */

        jQuery('.btn-to-top').on('click', function(e) {
            e.preventDefault();
            jQuery('html, body').animate({
                scrollTop: 0
            }, 800);
        });

        /* -------------------------------
         * Chosen Select 
         ---------------------------------- */

        var config = {
            '.chosen-select': {
                width: "100%"
            },
            '.chosen-select-deselect': {
                allow_single_deselect: true,
                width: "100%"
            },
            '.chosen-select-no-single': {
                disable_search_threshold: 10,
                width: "100%"
            },
            '.chosen-select-no-results': {
                no_results_text: 'Oops, nothing found!',
                width: "100%"
            },
            '.chosen-select-width': {
                width: "100%"
            }
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
        /*Slider Bootstrap Start*/
        if (jQuery('#ex6').length != '') {
            $("#ex6").slider();
            $("#ex6").on("slide", function(slideEvt) {
                $("#ex6SliderVal").text(slideEvt.value);
            });
        }
        /*Slider Bootstrap End*/



        if (jQuery('.auto-media-slider').length != '') {
            jQuery('.auto-media-slider').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
            });
        }
        /*If Condition Start*/
        if (jQuery('.cs-detail-slider').length != '') {
            $('.cs-detail-slider').slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                swipeToSlide: true,
            });
        }
        /*If Condition End*/

        //Map Scroll None Function
        $('.maps').click(function() {
            $('.maps iframe').css("pointer-events", "auto");
        });

        $(".maps").mouseleave(function() {
            $('.maps iframe').css("pointer-events", "none");
        });


        /* -------------------------------
         * Focus new code Start
         ---------------------------------- */
        jQuery('input,textarea').on('focus', function() {
            var $this = jQuery(this);
            $this.data('placeholder', $this.prop('placeholder'));
            $this.removeAttr('placeholder')
        }).on('blur', function() {
            var $this = jQuery(this);
            $this.prop('placeholder', $this.data('placeholder'));
        });


        /*
         * Under Construction Count Down
         */
        if (jQuery('#getting-started').length != '') {
            launch_date = jQuery("#getting-started").html();
            jQuery('#getting-started').countdown(launch_date, function(event) {
                jQuery(this).html(event.strftime('<div class="time-box"><h4 class="dd">%D</h4> <span class="label">days</span><span class="cs-slash">&#x2F</span></div><div class="time-box"><h4 class="hh">%H</h4><span class="label">hours</span><span class="cs-slash">&#x2F</span></div><div class="time-box"><h4 class="mm">%M</h4> <span class="label">minutes</span><span class="cs-slash">&#x2F</span></div><div class="time-box"><h4 class="ss">%S</h4> <span class="label">seconds</span></div> '));
            });
        }


        /* ------------------------------- Quantity plus minus Funtions ------------------------------- */
        // This button will increment the value
        jQuery('.qtyplus').click(function(e) {
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var valueInput = jQuery(this).prev('input');
            // Get its current value
            var currentVal = parseInt(valueInput.val());
            // If is not undefined
            if (!isNaN(currentVal)) {
                // Increment
                valueInput.val(currentVal + 1);
            } else {
                // Otherwise put a 0 there
                valueInput.val(0);
            }
        });
        // This button will decrement the value till 0
        jQuery(".qtyminus").click(function(e) {
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var valueInput = jQuery(this).next('input');
            // Get its current value
            var currentVal = parseInt(valueInput.val());
            // If it isn't undefined or its greater than 0
            if (!isNaN(currentVal) && currentVal > 0) {
                // Decrement one
                valueInput.val(currentVal - 1);
            } else {
                // Otherwise put a 0 there
                valueInput.val(0);
            }
        });
        /* ------------------------------- Quantity plus minus Funtions End ------------------------------- */


        /*Lazy Image Loader Start*/
        echo.init({
            offset: 100,
            throttle: 10,
            unload: false,
            callback: function(element, op) {
                console.log(element, 'has been', op + 'ed')
            }
        });
        /*Lazy Image Loader End*/

        jQuery(function() {
            jQuery(".more-text").slice(0, 1).show(500); // select the first ten
            jQuery('#hide-text').hide();
            jQuery("#load-text").click(function(e) { // click event for load more
                e.preventDefault();
                jQuery(".more-text:hidden").slice(0, 1).show(500); // select next 10 hidden divs and show them
                if (jQuery(".more-text:hidden").length == 0) { // check if any hidden divs still exist

                }
                jQuery('#load-text').hide();
                jQuery('#hide-text').show();
            });
            jQuery("#hide-text").click(function(e) { // click event for load more
                e.preventDefault();
                jQuery(".more-text").slice(1).hide(500); // select the first ten
                jQuery('#load-text').show();
                jQuery('#hide-text').hide();
            });
        });

        /*Fitvideo Script*/
        if (jQuery("body").length != '') {
            jQuery("body").fitVids();
        }


    });
    /* ------------------------------- Document Rready Funtions End ------------------------------- */


    /* ------------------------------- Window Load Funtions Start ------------------------------- */


    jQuery(window).on('load',function () {
        if (jQuery(".cs-select-model .cs-checkbox-list").length != '') {
            jQuery(".cs-select-model .cs-checkbox-list").mCustomScrollbar({
                setHeight: 300,
                theme: "dark"
            });
        }
        /*
         * Popup hover function  
         */
        var notH = 1,
            $pop = jQuery('#popup').hover(function() {
                notH ^= 1;
            });

        jQuery(document).on('mousedown keydown', function(e) {
            if (notH || e.which == 27)
                $pop.stop().fadeOut();
        });

        jQuery('.pop').click(function() {
            $pop.stop().fadeIn();
        });

        /*
         * End Popup hover function  
         */

    });
    /* 
     * Window Load Funtions End 
     */

    /*
     * Window Scroll Funtions Start
     */

    jQuery(window).scroll(function() {
        /*
         * Header Add Class Start
         */
        //Detail Button Section Start
        var scroll = jQuery(window).scrollTop();
        if (scroll >= 700) {
            jQuery(".cs-button-style").addClass("cs-button-style-none");
        } else {
            jQuery(".cs-button-style").removeClass("cs-button-style-none");
        }
        //Detail Button Section End

        //Detail Nav bar Start
//        var scroll = jQuery(window).scrollTop();
//        if (scroll >= 700) {
//            jQuery(".cs-detail-nav").addClass("cs-detail-nav-fixed");
//        } else {
//            jQuery(".cs-detail-nav").removeClass("cs-detail-nav-fixed");
//        }
        //Detail Nav bar End


    });
    /* ------------------------------- Window Scroll Funtions End ------------------------------- */




//    jQuery(document).ready(function() {
//        jQuery(document).on("scroll", onScroll);
//
//        //smoothscroll
//        jQuery('.cs-detail-nav ul li a[href^="#"]').on('click', function(e) {
//            e.preventDefault();
//            jQuery(document).off("scroll");
//
//            jQuery('.cs-detail-nav ul li a').each(function() {
//                jQuery(this).removeClass('active');
//            })
//            jQuery(this).addClass('active');
//
//            var target = this.hash,
//                menu = target;
//            $target = jQuery(target);
//            jQuery('html, body').stop().animate({
//                'scrollTop': $target.offset().top + 2
//            }, 500, 'swing', function() {
//                window.location.hash = target;
//                jQuery(document).on("scroll", onScroll);
//            });
//        });
//    });
//
//    function onScroll(event) {
//        var scrollPos = jQuery(document).scrollTop();
//        jQuery('.cs-detail-nav ul li a').each(function() {
//            var currLink = jQuery(this);
//            var refElement = jQuery(currLink.attr("href"));
//            if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
//                jQuery('.cs-detail-nav ul li a').removeClass("active");
//                currLink.addClass("active");
//            } else {
//                currLink.removeClass("active");
//            }
//        });
//    }

})(jQuery);

/* ------------------------------- Chimp Solutions All Funtions End ------------------------------- */

/* ---------------------------------------------------------------------------
 * Post like Counter 
 * --------------------------------------------------------------------------- */
function automobile_post_likes_count(admin_url, id) {
    "use strict";
    var dataString = 'post_id=' + id + '&action=automobile_post_likes_count';
    jQuery("#post_likes" + id).html('<i class="icon-spinner8 fa-spin"></i>');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function(response) {
            if (response != 'error') {
                jQuery("#post_likes" + id).html(response);
                jQuery("#post_likes" + id).removeAttr("onclick");
            } else {
                jQuery("#post_likes" + id).html(' There is an error.');
            }
        }
    });
    return false;
}


/* ---------------------------------------------------------------------------
 * Sticky Header  
 * --------------------------------------------------------------------------- */


jQuery(window).scroll(function() {

    var scroll = jQuery(window).scrollTop();

    if (scroll >= 100) {
        jQuery(".sticky").addClass("fixed-header");
    } else {
        jQuery(".sticky").removeClass("fixed-header");
    }
});

