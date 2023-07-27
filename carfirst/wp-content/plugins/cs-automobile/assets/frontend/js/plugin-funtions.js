/*Function For Plugins*/
jQuery(document).ready(function ($) {

    /*Banner Slider Start*/
    if (jQuery(".cs-banner-slider").length != '') {
        jQuery('.cs-banner-slider').slick({
            
            dots: false,
            arrows: true,
            swipeToSlide: true,
            infinite: true,
            speed: 300,
            autoplay: true,
            autoplaySpeed: 2000,
            slidesToShow: 4,
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
                }]
        });
    }
        if (jQuery(".cs-detail-nav").length != '') {
            var fixmeTop = $(".cs-detail-nav").offset().top;
            $(window).scroll(function() {
                var $window = $(this);
                if ($window.width() > 990) {
                    var currentScroll = $(window).scrollTop();
                    var header = $('.cs-detail-nav');
                    var headerHeight = header.outerHeight();
                    var body = $('body .wrapper');
                    var adminBarHeight = 0;
                    if (body.hasClass('admin-bar')) {
                        adminBarHeight = $('#wpadminbar').outerHeight();
                    }
                    if (currentScroll >= fixmeTop) {
                        body.css('padding-top', headerHeight);
                        header.addClass('cs-detail-nav-fixed').css('top', adminBarHeight);
                    } else {
                        body.css('padding-top', 0);
                        header.removeClass('cs-detail-nav-fixed').css('top', 'auto');
                    }
                }
            });
        }
        /*User Navigation*/
        var UserDetailNav = $(".cs-detail-nav").outerHeight();
        jQuery('.cs-detail-nav ul li a').each(function() {
            var $this = jQuery(this),
                target = this.hash;
            jQuery(this).click(function(e) {
                e.preventDefault();
                if ($this.length > 0) {
                    if ($this.attr('href') == '#') {
                        // Do nothing   
                    } else {
                        jQuery('html, body').animate({
                            scrollTop: (jQuery(target).offset().top) - parseInt(UserDetailNav)
                        }, 500, 'swing', function() {
                            $(document).on("scroll", onScroll);
                        });
                    }
                }
            });
        });
        /*User Navigation*/	

});
    /*User Navigation Active*/
    function onScroll(event) {
        var scrollPos = jQuery(document).scrollTop();
        jQuery('.cs-detail-nav ul li a').each(function() {
            var currLink = jQuery(this);
            var refElement = jQuery(currLink.attr("href"));
            
            //alert(refElement);
            
            if (refElement.position() <= scrollPos && refElement.position() > scrollPos) {
                jQuery('.cs-detail-nav ul li a').removeClass("active");
                currLink.addClass("active");
            } else {
                currLink.removeClass("active");
            }
        });
    }
    jQuery(window).on('scroll', function() {
        jQuery(document).on("scroll", onScroll);
    });	
    /*User Navigation Active*/

window.addEvent("domready",function() {
	
	//alert(data_src);
	
	        	
/*
---
description:     LazyLoad

authors:
  - David Walsh (http://davidwalsh.name)

license:
  - MIT-style license

requires:
  core/1.2.1:   "*"

provides:
  - LazyLoad
...
*/
var LazyLoad = new Class({

	Implements: [Options,Events],

	/* additional options */
	options: {
		range: 200,
		elements: "img",
		container: window,
		mode: "vertical",
		realSrcAttribute: "data-src",
		useFade: true,
		src: 'src'
		
	},

	/* initialize */
	initialize: function(options) {
		
		// Set the class options
		this.setOptions(options);
		
		// Elementize items passed in
		this.container = document.id(this.options.container);
		this.elements = document.id(this.container == window ? document.body : this.container).getElements(this.options.elements);
		
		// Set a variable for the "highest" value this has been
		this.largestPosition = 0;
		
		// Figure out which axis to check out
		var axis = (this.options.mode == "vertical" ? "y": "x");
		
		// Calculate the offset
		var offset = (this.container != window && this.container != document.body ? this.container : "");

		// Find elements remember and hold on to
		this.elements = this.elements.filter(function(el) {
			// Make opacity 0 if fadeIn should be done
			if(this.options.useFade) el.setStyle("opacity", 0);
			// Get the image position
			var elPos = el.getPosition(offset)[axis];
			// If the element position is within range, load it
			if(elPos < this.container.getSize()[axis] + this.options.range) {
				this.loadImage(el);
				return false;
			}
			return true;
		},this);
		
		// Create the action function that will run on each scroll until all images are loaded
		var action = function(e) {
			
			// Get the current position
			var cpos = this.container.getScroll()[axis];
			
			// If the current position is higher than the last highest
			if(cpos > this.largestPosition) {
				
				// Filter elements again
				this.elements = this.elements.filter(function(el) {
					
					// If the element is within range...
					if((cpos + this.options.range + this.container.getSize()[axis]) >= el.getPosition(offset)[axis]) {
						
						// Load the image!
						this.loadImage(el);
						return false;
					}
					return true;
					
				},this);
				
				// Update the "highest" position
				this.largestPosition = cpos;
			}
			
			// relay the class" scroll event
			this.fireEvent("scroll");
			
			// If there are no elements left, remove the action event and fire complete
			if(!this.elements.length) {
				this.container.removeEvent("scroll", action);
				this.fireEvent("complete");
			}
			
		}.bind(this);
		
		// Add scroll listener
		this.container.addEvent("scroll", action);
	},
	loadImage: function(image) {
		// Set load event for fadeIn
		if(this.options.useFade) {
			image.addEvent("load", function(){
				image.fade(1);
			});
		}
		// Set the SRC
		if(image.get(this.options.realSrcAttribute)!=null){
		//console.log(image.get(this.options.realSrcAttribute));
		image.set("src", image.get(this.options.realSrcAttribute));
		// Fire the image load event
		this.fireEvent("load", [image]);
		}
		if(image.get(this.options.realSrcAttribute)==null){
		//console.log(image.get(this.options.realSrcAttribute));
		image.set("src", image.get(this.options.src));
		// Fire the image load event
		this.fireEvent("load", [image]);
		}
	}
});
	var lazyloader = new LazyLoad({
            
		range: 200,
		realSrcAttribute: "data-src",
		useFade: true,
		elements: 'img',
		container: window,
		src: 'src',
	
	});
	
	
	

	/*
	var realSrcAttribute = this.options.realSrcAttribute;
	Slick.definePseudo('has-real-src-attr', function(){
	    return Element.get(this, realSrcAttribute) != null;
	});
	 
    this.elements = document.id(this.container == window ? document.body : this.container).getElements(this.options.elements + ':has-real-src-attr');
	*/
	});



/* Window Scroll Funtions Start */
jQuery(window).scroll(function () {
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
//    var scroll = jQuery(window).scrollTop();
//    if (scroll >= 700) {
//        jQuery(".cs-detail-nav").addClass("cs-detail-nav-fixed");
//    } else {
//        jQuery(".cs-detail-nav").removeClass("cs-detail-nav-fixed");
//    }
    //Detail Nav bar End


});
/*Window Scroll Funtions End */
//var listElement = jQuery('.cs-detail-nav ul li');
//var offset = jQuery('.cs-detail-nav , .cs-detail-nav.cs-detail-nav-fixed').outerHeight();
//listElement.find('a[href^="#"]').click(function (event) {
//    event.preventDefault();
//    var anchorId = $(this).attr("href");
//    if (anchorId.length > 1 && $(anchorId).length > 0) {
//        var target = $(anchorId).offset().top - offset;
//    } else {
//        var target = 0;
//    }
//    jQuery('html, body').animate({
//        scrollTop: target
//    }, 500, function () {
//        window.location.hash = anchorId;
//    });
//    setActiveListElements();
//});
//
//function setActiveListElements(event) {
//    var windowPos = jQuery(window).scrollTop();
//    jQuery('.cs-detail-nav ul li a[href^="#"]').each(function () {
//
//        var currentLink = jQuery(this);
//        if (jQuery(currentLink.attr("href")).length > 0) {
//            var refElement = jQuery(currentLink.attr("href"));
//            if (refElement.position().top <= windowPos && (refElement.position().top + refElement.height() + jQuery(".cs-detail-nav").height()) > windowPos) {
//                jQuery('.cs-detail-nav ul li a').removeClass("active");
//                currentLink.addClass("active");
//            } else {
//                currentLink.removeClass("active");
//            }
//        }
//    });
//}
//// Update menu item on scroll
//jQuery(window).scroll(function () {
//    // Call function
//    setActiveListElements();
//});

jQuery(document).ready(function() {
    if(document.getElementById("request-video") !== null) {
        jQuery("#request-video iframe").attr("id", "popup_video");
        var iframe = document.getElementById('popup_video');
        if( iframe != null ){
            var players = 'youtube.com';
            if( iframe.src.search(players) !== -1 ) {
               var src = iframe.src + '&enablejsapi=1';
               iframe.src = src;
            }
        }
    }
});
jQuery( "body" ).click(function( event ) {
    var class_name = event.target.className
    if( class_name !== 'btn-video' ) {
        var iframe = document.getElementById('popup_video');
        if(typeof(iframe) != "undefined" && iframe !== null) {
            var iframe = jQuery('#popup_video')[0];
            var player = $f(iframe);
            player.api('pause');
            jQuery('#popup_video')[0].contentWindow.postMessage('{"event":"command","func":"' + 'pauseVideo' + '","args":""}', '*');
        }
    }
});
if( typeof( jQuery( ".inventory_type_shortcode" ).val() ) != "undefined" && jQuery(".inventory_type_shortcode").val() != '' ){
    jQuery(".inventory_type_shortcode").trigger('change');
}

if (jQuery(".cs-banner-slider").length != '') {
    jQuery('.cs-banner-slider').addClass("slider-loader")
    setTimeout(function() {
        jQuery('.slider-loader').fadeOut("slow", function() {
            jQuery(this).removeClass("slider-loader");
        });
        jQuery('.cs-banner-slider').fadeIn();
    }, 5000);
}

// bottom thumbnail slider
if (jQuery(".cs-bottom-slides").length != '') {
jQuery('.cs-bottom-slides').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: true,
 swipeToSlide:true,
 speed: 1500,
  asNavFor: '.cs-bottom-slides-thumb'
});
jQuery('.cs-bottom-slides-thumb').slick({
  slidesToShow: 5,
  slidesToScroll: 1,
  asNavFor: '.cs-bottom-slides',
  centerPadding: '0',
  verticalPadding: '50px',
  dots: false,
  arrows: false,
  centerMode: false,
  focusOnSelect: true,
  swipeToSlide:true,
  responsive: [
    
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    }
  
  ]
});

}

jQuery('.cs-bottom-slides-thumb').on('setPosition', function (slick) {
        visibileFrame();
    }).trigger('setPosition')
    jQuery('.cs-bottom-slides-thumb').on('setPosition', function (slick) {
        visibileFrame();
    }).trigger('afterChange')
	
 jQuery(".cs-bottom-slides-thumb").click(function () {
       visibileFrame();
	   
   });
 function visibileFrame(){
 	if(jQuery(".slick-active").hasClass("slick-video")) {
 	jQuery(".slider-holder").addClass("slides-video-frame");
	}else{
            jQuery(".slider-holder").removeClass("slides-video-frame");	 
        }
    }
    
    
function fancy_view_listing_js_func(thisObj){
    
     //msg_con.html('<i class="icon-spinner8 icon-spin"></i>');
     
     var value = thisObj.innerText; value = value.toLowerCase();      
     var ajax_url = thisObj.getAttribute('data-ajax');
     
     var dataString = 'tab_value=' + value +'&action=tabs_search_result_func';

    jQuery(".cs-inventories-listing-loader").html('<div class="sk-circle"><div class="sk-circle1 sk-child"></div><div class="sk-circle2 sk-child"></div><div class="sk-circle3 sk-child"></div><div class="sk-circle4 sk-child"></div><div class="sk-circle5 sk-child"></div><div class="sk-circle6 sk-child"></div><div class="sk-circle7 sk-child"></div><div class="sk-circle8 sk-child"></div><div class="sk-circle9 sk-child"></div><div class="sk-circle10 sk-child"></div><div class="sk-circle11 sk-child"></div><div class="sk-circle12 sk-child"></div></div>');
    jQuery('.cs-inventories-listing-loader').show();

//    jQuery(".cs-inventories-listing-loader").html('<i class="icon-spinner icon-spin"></i>');
//    jQuery('.cs-inventories-listing-loader').show();
   
            jQuery.ajax({
                
                type: "POST",
                url: ajax_url,
                data: dataString,
                dataType: "json",
                
                success: function (response) {
                
            jQuery('.cs-inventories-listing-loader').html('');
            jQuery('.cs-inventories-listing-loader').hide();
            
                jQuery("#content_div_fancy_view").html(response.success);
                jQuery("#on_load_records").html("");

                }
            });
            
            return false;
    
    

    
}    