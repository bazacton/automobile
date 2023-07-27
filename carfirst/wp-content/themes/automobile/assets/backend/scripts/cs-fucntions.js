var $ = jQuery;

if (jQuery('body.rtl a.cs-help').length != '') {
	jQuery('body.rtl a.cs-help').attr("data-placement", "left");
}	    


/*
 * Media Upload 
 */
jQuery(document).on("click", ".cs-automobile-media", function () {
    var $ = jQuery;
    var id = $(this).attr("name");
    var custom_uploader = wp.media({
        title: 'Select File',
        button: {
            text: 'Add File'
        },
        multiple: false
    }).on('select', function () {
        var attachment = custom_uploader.state().get('selection').first().toJSON();
        jQuery('#' + id).val(attachment.url);
        jQuery('#' + id + '_img').attr('src', attachment.url);
        jQuery('#' + id + '_box').show();
    }).open();

});

jQuery(document).ready(function ($) {

    "use strict";
    $('[data-toggle="popover"]').popover();
    

    /*
     * CS meta fileds Tabs
     */
    var myUrl = window.location.href; //get URL
    var myUrlTab = myUrl.substring(myUrl.indexOf("#")); // For localhost/tabs.html#tab2, myUrlTab = #tab2     
    var myUrlTabName = myUrlTab.substring(0, 4); // For the above example, myUrlTabName = #tab
    jQuery("#tabbed-content > div").addClass('hidden-tab'); // Initially hide all content #####EDITED#####
    jQuery("#cs-options-tab li:first a").attr("id", "current"); // Activate first tab
    jQuery("#tabbed-content > div:first").hide().removeClass('hidden-tab').fadeIn(); // Show first tab content   #####EDITED#####
    jQuery("#cs-options-tab > li:first").addClass('active');

    jQuery(document).on("click", "#cs-options-tab li > a", function (e) {
        e.preventDefault();
        if (jQuery(this).attr("id") == "current") { //detection for current tab
            return
        } else {
            automobile_reset_tabs();
            console.log(this);
            jQuery("#cs-options-tab > li").removeClass('active')
            jQuery(this).attr("id", "current"); // Activate this
            jQuery(this).parents('li').addClass('active');
            jQuery(jQuery(this).attr('name')).hide().removeClass('hidden-tab').fadeIn(); // Show content for current tab
        }
    });

    var i;
    for (i = 1; i <= jQuery("#cs-options-tab li").length; i++) {
        if (myUrlTab == myUrlTabName + i) {
            automobile_reset_tabs();
            jQuery("a[name='" + myUrlTab + "']").attr("id", "current"); // Activate url tab
            jQuery(myUrlTab).hide().removeClass('hidden-tab').fadeIn(); // Show url tab content        
        }
    }

    /*
     * End CS meta fileds Tabs
     */
});

function automobile_reset_tabs() {
    "use strict";
    jQuery("#tabbed-content > div").addClass('hidden-tab'); //Hide all content
    jQuery("#cs-options-tab a").attr("id", ""); //Reset id's      
}

jQuery(document).on('click', 'label.cs-chekbox', function () {
    var checkbox = jQuery(this).find('input[type=checkbox]');

    if (checkbox.is(":checked")) {
        jQuery('#' + checkbox.attr('name')).val(checkbox.val());
        jQuery('#' + checkbox.attr('name')).attr('value', 'on');
    } else {
        jQuery('#' + checkbox.attr('name')).val('');
        jQuery('#' + checkbox.attr('name')).attr('value', '');
    }
});

function automobile_var_show_slider(automobile_value) {

    if (automobile_value == 'slider') {
        $('#cs-rev-slider-fields').show();
        $('#cs-no-headerfields').hide();
        $('#cs-breadcrumbs-fields').hide();
        $('#cs-subheader-with-bc').hide();
        $('#sub_header_bg_clr').hide();
        $('#cs-subheader-with-bg').hide();
    } else if (automobile_value == 'no_header') {
        $('#cs-no-headerfields').show();
        $('#cs-breadcrumbs-fields').hide();
        $('#cs-rev-slider-fields').hide();
        $('#cs-subheader-with-bc').hide();
        $('#sub_header_bg_clr').hide();
        $('#cs-subheader-with-bg').hide();
    } else {
        var sub_header_style_value = $('select#automobile_var_sub_header_style option:selected').val();
        $('#cs-breadcrumbs-fields').show();
        $('#cs-no-headerfields').hide();
        $('#cs-rev-slider-fields').hide();
        $('#cs-subheader-with-bc').show();
        $('#sub_header_bg_clr').show();
        if( sub_header_style_value == 'with_bg' ){
            $('#cs-subheader-with-bg').show();
            $('#cs-breadcrumbs_sub_header_fields').show();
            $('#cs-subheader-with-bc').hide();
        }else{
           $('#cs-subheader-with-bg').hide();
           $('#cs-breadcrumbs_sub_header_fields').hide();
           $('#cs-subheader-with-bc').show(); 
        }
        
    }
}

function automobile_var_subheader_style(automobile_value) {

    if (automobile_value == 'with_bg') {
        $('#cs-subheader-with-bg').show();
        $('#cs-breadcrumbs_sub_header_fields').show();
        $('#sub_header_bg_clr').show();
        $('#cs-subheader-with-bc').hide();
        
    } else {
        $('#cs-subheader-with-bg').hide();
        $('#cs-breadcrumbs_sub_header_fields').hide();
        $('#cs-subheader-with-bc').show();
        $('#sub_header_bg_clr').show();
    }
}

/*
 *  Message Slide show functions
 */
function slideout() {
    "use strict";
    setTimeout(function () {
        jQuery(".form-msg").slideUp("slow", function () {
        });
    }, 5000);
}
/*
 *End Message Slide show functions
 */

/*
 *  Remove div Function
 */
function automobile_div_remove(id) {
    "use strict";
    jQuery("#" + id).remove();
}

/*
 *End Remove div Function
 */


/*
 * Delete Media Functions
 */
function del_media(id) {
    
    "use strict";
    var $ = jQuery;
    //jQuery('input[name="'+id+'"]').show();
    jQuery('#' + id + '_box').hide();
    jQuery('#' + id).val('');
    jQuery('#' + id).next().show();
}
/*
 * End Delete Media Functions
 */

/*
jQuery(document).on("click", ".delImgMedia", function () {
    var $ = jQuery;
    jQuery(this).parent().parent().parent().parent().parent().parent().parent().hide();
    jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().children('.browse-icon').show();
    jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent().children('input').val('');
    //jQuery(this).parent('.gal-edit-opts').parent('.thumb-secs').parent('li').parent('ul').parent('.dragareamain').parent('.gal-active').parent('.page-wrap').hide();
    //jQuery(this).parent('.gal-edit-opts').parent('.thumb-secs').parent('li').parent('ul').parent('.dragareamain').parent('.gal-active').parent('.page-wrap').parent('.cs-dr-option-img').children('.browse-icon').show();
    //jQuery(this).parent('.gal-edit-opts').parent('.thumb-secs').parent('li').parent('ul').parent('.dragareamain').parent('.gal-active').parent('.page-wrap').parent('.cs-dr-option-img').children('input').val('');
});*/


function automobile_var_toggle(id) {
    jQuery("#" + id).slideToggle("slow");
}

function chosen_selectionbox() {
    
    if (jQuery('.chosen-select, .chosen-select-deselect, .chosen-select-no-single, .chosen-select-no-results, .chosen-select-width').length != '') {
        var config = {
            '.chosen-select': {width: "100%"},
            '.chosen-select-deselect': {allow_single_deselect: true},
            '.chosen-select-no-single': {disable_search_threshold: 10, width: "100%"},
            '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
            '.chosen-select-width': {width: "95%"}
        };
        for (var selector in config) {
            jQuery(selector).chosen(config[selector]);
        }
    }
}

/*
 *   Overley remove function
 */
function _removerlay(object) {
    "use strict";
    var $elem;
    jQuery("#cs-widgets-list .loader").remove();
    var _elem1 = "<div id='cs-pbwp-outerlay'></div>",
            _elem2 = "<div id='cs-widgets-list'></div>";
    $elem = object.closest('div[class*="cs-wrapp-class-"]');
    $elem.unwrap();
    $elem.unwrap();
    $elem.hide()
}

/*
 * End Overley remove function
 */

/*
 * Bannner widget options function
 */
function automobile_service_view_change(value) {
    "use strict";
    if (value == 'image') {
        jQuery(".cs-sh-service-image-area").show();
        jQuery(".cs-sh-service-icon-area").hide();
    }
    else {
        jQuery(".cs-sh-service-image-area").hide();
        jQuery(".cs-sh-service-icon-area").show();
    }
}