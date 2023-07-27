(function ($) {

    jQuery(document).ready(function () {

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

})(jQuery);

var $ = jQuery;
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

function automobile_display_url_field(val) {
    if (val == 'yes') {
        jQuery('#advance_url_field').show();
    } else {
        jQuery('#advance_url_field').hide();
    }
}
/*
jQuery(document).on('click', '.btndeleteit', function () {
 //   var conf = confirm("Are you sure you want to delete it!");
    if (conf == true) {
        jQuery(this).parents('tr').remove();
    } else {
        return false;
    }
});
*/

jQuery(document).on('change', 'input[name="automobile_user_img_media"], input[name*="automobile_gallery_user_img_media"]', function () {
    var file,
            img,
            img_width,
            img_height,
            parent_div = jQuery(this).parents('.col-lg-8');
           
    var _URL = window.URL || window.webkitURL;
    parent_div.find('.cs-upload-warning').html('');
    img_width = 0;
    img_height = 0;
    if ((file = this.files[0])) {
        img = new Image();
        img.onload = function () {
            img_width = this.width;
            img_height = this.height;
            if (img_width < 128 || img_height < 68) {
                parent_div.find('.cs-upload-warning').html('Incorrect Image Size.');
                jQuery(this).val('');
            }
        };
        img.src = _URL.createObjectURL(file);
    }
});

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

function automobile_check_fields_avail() {
    "use strict";
    jQuery('input[id^="check_field_name"]').change(function (e) {
        var automobile_ajaxurl = jQuery('#tabbed-content').data('ajax-url');
        var doneTypingInterval = 1000; //time in ms, 5 second for example
        var name = jQuery(this).val();
        var serializedValues = jQuery("form").serialize();
        var $this = jQuery(this);
        var dataString = 'name=' + name +
                '&form_field_names=' + serializedValues +
                '&action=automobile_check_fields_avail'

        setTimeout(function () {

            $this.next('span').html('<i class="icon-spinner icon-spin"></i>');
            jQuery.ajax({
                type: "POST",
                url: automobile_ajaxurl,
                data: dataString,
                dataType: 'json',
                success: function (response) {
                    if (response.type == 'success') {
                        $this.next('.name-checking').html(response.message);
                        jQuery('input[type="button"]').removeAttr('disabled');
                    } else if (response.type == 'error') {
                        $this.next('.name-checking').html(response.message);
                        jQuery('input[type="button"]').attr('disabled', 'disabled');
                    }
                }
            });
        }, doneTypingInterval)

    });
}

function automobile_custom_fields_js() {
    var parentItem = jQuery("#cs-pb-formelements");
    parentItem.sortable({
        cancel: 'div div.poped-up,.pb-toggle',
        handle: ".pbwp-legend",
        placeholder: "ui-state-highlighter"
    });
    var c = 0;
    parentItem.on("click", "img.pbwp-clone-field", function (e) {
        e.preventDefault();
        var _this = jQuery(this),
                b = _this.closest('div.pbwp-clone-field');        
        var dataString = b.clone().html();
        var counter = $( "pbwp-clone-field" ).length;
        var dataResponse = dataString.replace(/automobile_cus_field_dropdown_options_imgs/g, 'automobile_cus_field_dropdown_options_imgs'+counter+1);
        jQuery('<div class="pbwp-clone-field clearfix">'+dataResponse+'</div>').insertAfter(b);
        var a = _this.parents('.pbwp-form-sub-fields').find('input:radio');
        a.each(function (index, el) {
            jQuery(this).val(index + 1);
        });

    });
    
    parentItem.on("click", "img.pbwp-remove-field", function (e) {
        jQuery(this).parent('.pbwp-clone-field').remove();
    });
    parentItem.on("click", ".pbwp-remove", function (e) {
        e.preventDefault();
        var a = confirm("This will delete Item");
        if (a) {
            jQuery(this).parents(".pb-item-container").remove();
        }
    })
    parentItem.on("click", "a.pbwp-toggle", function (e) {
        e.preventDefault();
        jQuery(this).parents(".pbwp-legend").next().slideToggle(300);
    });
}

function automobile_inventory_type_change(slug, post_id) {
    "use strict";

    var automobile_ajaxurl = jQuery('#tabbed-content').data('ajax-url');
    var dataString = 'inventory_type_slug=' + slug + '&post_id=' + post_id + '&action=inventory_type_dyn_fields';

    jQuery('#cs-inventory-type-field').html('<div class="cs-fields-loader"><i class="icon-spinner icon-spin"></i></div>');
    jQuery.ajax({
        type: "POST",
        url: automobile_ajaxurl,
        data: dataString,
        dataType: 'json',
        success: function (response) {
            if (response.inventory_fields !== 'undefined') {
                jQuery('#cs-inventory-type-field').html(response.inventory_fields);
            } else {
                jQuery('#cs-inventory-type-field').html('Error');
            }
        }
    });
}

function automobile_inv_elem_type_change(type_slug) {
    "use strict";

    var automobile_ajaxurl = jQuery('#add_page_builder_item').data('ajax-url');
    var dataString = 'inventory_type_slug=' + type_slug + '&action=automobile_inv_elem_type_change';

    jQuery('.cs-inv-elem-makes').html('<div class="cs-fields-loader"><i class="icon-spinner icon-spin"></i></div>');
    jQuery.ajax({
        type: "POST",
        url: automobile_ajaxurl,
        data: dataString,
        dataType: 'json',
        success: function (response) {
            if (response.type_makes !== 'undefined') {
                jQuery('.cs-inv-elem-makes').html(response.type_makes);
            } else {
                jQuery('.cs-inv-elem-makes').html('Error');
            }
        }
    });
}

function automobile_inv_elem_view_change(type_slug) {
    "use strict";
  
    if(type_slug == 'fancy'){
        jQuery('.cs-not-fancy-view-area-inv').hide();
        jQuery('.cs-not-slider-view-area-inv').show();
    }
   else if(type_slug == 'slider'){
        jQuery('.cs-not-slider-view-area-inv').hide();
        jQuery('.cs-slider-view-area-inv').show();
    } else {
         jQuery('.cs-not-fancy-view-area-inv').show();
        jQuery('.cs-not-slider-view-area-inv').show();
        jQuery('.cs-slider-view-area-inv').hide();
    }
}

function automobile_load_make_models(make, post_id) {
    "use strict";

    var automobile_ajaxurl = jQuery('#tabbed-content').data('ajax-url');
    var dataString = 'inventory_make=' + make + '&post_id=' + post_id + '&action=dyn_inventory_models';

    jQuery('#cs-inv-model-box').html('<div class="cs-fields-loader"><i class="icon-spinner icon-spin"></i></div>');
    jQuery.ajax({
        type: "POST",
        url: automobile_ajaxurl,
        data: dataString,
        dataType: 'json',
        success: function (response) {
            if (response.models !== 'undefined') {
                jQuery('#cs-inv-model-box').html(response.models);
            } else {
                jQuery('#cs-inv-model-box').html('Error');
            }
        }
    });
}

function automobile_var_createpop(data, type) {
    "use strict";
    var _structure = "<div id='cs-pbwp-outerlay'><div id='cs-widgets-list'></div></div>",
            $elem = jQuery('#cs-widgets-list');
    jQuery('body').addClass("cs-overflow");
    if (type == "csmedia") {
        $elem.append(data);
    }
    if (type == "filter") {
        jQuery('#' + data).wrap(_structure).delay(100).fadeIn(150);
        jQuery('#' + data).parent().addClass("wide-width");
    }
    if (type == "filterdrag") {
        jQuery('#' + data).wrap(_structure).delay(100).fadeIn(150);
    }

    if (jQuery('.chosen-select, .chosen-select-deselect, .chosen-select-no-single, .chosen-select-no-results, .chosen-select-width').length != '') {
        var config = {
            '.chosen-select': {width: "100%"},
            '.chosen-select-deselect': {allow_single_deselect: true},
            '.chosen-select-no-single': {disable_search_threshold: 10, width: "100%"},
            '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
            '.chosen-select-width': {width: "95%"}
        }
        for (var selector in config) {
            jQuery(selector).chosen(config[selector]);
        }
    }

}

function automobile_var_removeoverlay(id, text) {
    "use strict";
    jQuery("#cs-widgets-list .loader").remove();
    var _elem1 = "<div id='cs-pbwp-outerlay'></div>",
            _elem2 = "<div id='cs-widgets-list'></div>",
            $elem = jQuery("#" + id);
    jQuery("#cs-widgets-list").unwrap();
    if (text == "append" || text == "filterdrag") {
        $elem.hide().unwrap();
    }
    if (text == "widgetitem") {
        $elem.hide().unwrap();
        jQuery("body").append("<div id='cs-pbwp-outerlay'><div id='cs-widgets-list'></div></div>");
        return false;

    }
    if (text == "ajax-drag") {
        jQuery("#cs-widgets-list").remove();
    }
    jQuery("body").removeClass("cs-overflow");
}

function add_inventory_feature(admin_url) {

    var dataString = 'automobile_feature_name=' + jQuery("#automobile_feature_name").val() + '&action=add_feature_to_list';
    jQuery(".feature-loader").html("<i class='icon-spinner icon-spin'></i>");
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {
            jQuery("#total_features").append(response);
            jQuery(".feature-loader").html("");
            automobile_var_removeoverlay('add_feature_title', 'append');
            jQuery("#automobile_feature_name").val("Title");
        }
    });
    return false;
}
