var $ = jQuery;

function automobile_search_view_change(id) {
    "use strict";
    if (jQuery('#' + id).attr('value') == 'on') {
        jQuery('#automobile_search_view_area').show();
    } else {
        jQuery('#automobile_search_view_area').hide();
    }
}

function automobile_dealer_search_switch(value) {
    "use strict";
    if (value == 'yes') {
        jQuery("#automobile_search_view_area").show();
    } else {
        jQuery("#automobile_search_view_area").hide();
    }
}

/*
 * maps function
 */

/**
 * Dealer switch map
 */
function automobile_dealer_map_switch(value) {
    "use strict";
    if (value == 'yes') {
        jQuery("#automobile_dealer_map_area").show();
    } else {
        jQuery("#automobile_dealer_map_area").hide();
    }
}

function automobile_single_city_change(value) {
    "use strict";
    if (value == 'single_city') {
        jQuery('#automobile_single_city_area').show();
    } else {
        jQuery('#automobile_single_city_area').hide();
    }
}

jQuery("[id^=map_canvas]").css("pointer-events", "none");
jQuery("[id^=cs-map-location]").css("pointer-events", "none");

var onMapMouseleaveHandler = function (event) {
    var that = jQuery(this);

    that.on('click', onMapClickHandler);
    that.off('mouseleave', onMapMouseleaveHandler);
    jQuery("[id^=map_canvas]").css("pointer-events", "none");
    jQuery("[id^=cs-map-location]").css("pointer-events", "none");
}

var onMapClickHandler = function (event) {
    var that = jQuery(this);
    // Disable the click handler until the user leaves the map area
    that.off('click', onMapClickHandler);

    // Enable scrolling zoom
    that.find('[id^=map_canvas]').css("pointer-events", "auto");
    that.find('[id^=cs-map-location]').css("pointer-events", "auto");

    // Handle the mouse leave event
    that.on('mouseleave', onMapMouseleaveHandler);
}

jQuery(document).on('change', '.side-location-field, .geo-search-location', function () {
    jQuery(this).parents('form.side-loc-srch-form').submit();
});

/*
 * Enable map zooming with mouse scroll when the user clicks the map
 */
jQuery('.cs-map-section').on('click', onMapClickHandler);

jQuery('body').on('change', '.cs-uploadimg', function (e) {

    jQuery('#automobile_dealer_img_box').show();
    var img_path = URL.createObjectURL(e.target.files[0]);
    var file_type = e.target.files[0]["type"];

    var validimage = 0;
    if (file_type == "image/jpeg" || file_type == "image/jpg" || file_type == "image/png") {
        validimage = 1;
        jQuery('#automobile_dealer_img_img').attr('src', img_path);
    } else {
        validimage = 0;
        jQuery('#automobile_dealer_profile_img_msg').addClass("error-msg");

        jQuery('#automobile_dealer_img_img').attr('src', "");
        jQuery('#automobile_dealer_img').attr('value', "");
    }

    // get width and height
    var _URL = window.URL || window.webkitURL;
    var files = e.target.files[0];


    var img = new Image(),
            fileSize = Math.round(files.size / 1024);
    if (fileSize >= 1024) {

        validimage = 0;
        jQuery('#automobile_edealer_profile_img_msg').addClass("error-msg");
        jQuery('#automobile_edealer_img_img').attr('src', "");
        jQuery('#automobile_edealer_img').attr('value', "");

    } else {
        validimage = 1;
    }
    img.onload = function () {
        var width = this.width,
                height = this.height,
                imgsrc = this.src;
        if (width >= 270 && height >= 210) {
            validimage = 1;
        } else {
            validimage = 0;
            jQuery('#automobile_edealer_profile_img_msg').addClass("error-msg");

            jQuery('#automobile_edealer_img_img').attr('src', "");
            jQuery('#automobile_edealer_img').attr('value', "");
        }

    };
    img.src = _URL.createObjectURL(files);
    // end get width and height

    if (validimage == 1) {
        jQuery('#automobile_edealer_profile_img_msg').removeClass("error-msg");


        jQuery('#automobile_edealer_img_img').attr('src', img_path);
        jQuery('#automobile_edealer_img').attr('value', img_path);

    }

});

jQuery('body').on('change', '.cs-cover-uploadimg', function (e) {
    jQuery('#automobile_cover_edealer_img_box').show();
    var img_path = URL.createObjectURL(e.target.files[0]);
    var file_type = e.target.files[0]["type"];
    var validimage = 0;
    if (file_type == "image/jpeg" || file_type == "image/jpg" || file_type == "image/png") {
        validimage = 1;
    } else {
        validimage = 0;
        jQuery('#automobile_edealer_profile_cover_msg').addClass("error-msg");

        jQuery('#automobile_cover_edealer_img_img').attr('src', "");
        jQuery('#automobile_cover_edealer_img').attr('value', "");
    }

    // get width and height
    var _URL = window.URL || window.webkitURL;
    var files = e.target.files[0];


    var img = new Image(),
            fileSize = Math.round(files.size / 1024);
    if (fileSize >= 1024) {

        validimage = 0;
        jQuery('#automobile_edealer_profile_cover_msg').addClass("error-msg");
        jQuery('#automobile_cover_edealer_img_img').attr('src', "");
        jQuery('#automobile_cover_edealer_img').attr('value', "");

    } else {
        validimage = 1;
    }
    img.onload = function () {
        var width = this.width,
                height = this.height,
                imgsrc = this.src;
        if (width >= 1600 && height >= 400) {
            validimage = 1;
        } else {
            validimage = 0;
            jQuery('#automobile_edealer_profile_cover_msg').addClass("error-msg");

            jQuery('#automobile_cover_edealer_img_img').attr('src', "");
            jQuery('#automobile_cover_edealer_img').attr('value', "");
        }

    };
    img.src = _URL.createObjectURL(files);
    // end get width and height

    if (validimage == 1) {
        jQuery('#automobile_edealer_profile_cover_msg').removeClass("error-msg");


        jQuery('#automobile_cover_edealer_img_img').attr('src', img_path);
        jQuery('#automobile_cover_edealer_img').attr('value', img_path);

    }

});
/*
 function custom validation
 */
function validateForm()
{
    // Validate URL


    var form = document.getElementById('cs-emp-form');
    error_exist = 'no';
    for (var i = 0; i < form.elements.length; i++) {
        if (form.elements[i].value === '' && form.elements[i].hasAttribute('required') || form.elements[i].value === '0') {
            var element_name = form.elements[i];
            jQuery(element_name).parent('.cs-field').addClass('has-error');
            jQuery(element_name).parent('.cs-field').append(jQuery('' + element_name + '<span> field is required</span>'));
            error_exist = 'yes';
            //jQuery('#myModal').hide();
        }
        if (error_exist == 'no') {
            jQuery('.cs-field').removeClass('has-error');
            jQuery('.cs-field span').html('');
            jQuery('#myModal').modal();
        }
    }


    /*
     // Validate Title
     var title = $("#frtitle").val();
     if (title=="" || title==null) { } else {
     alert("Please enter only alphanumeric values for your advertisement title");
     }
     
     // Validate Email 
     var email = $("#fremail").val();
     if ((/(.+)@(.+){2,}\.(.+){2,}/.test(email)) || email=="" || email==null) { } else {
     alert("Please enter a valid email");
     }
     return false;
     */
}
jQuery('body').on('change', '.cs-uploadimginventoryseek', function (e) {
    jQuery('#automobile_user_img_box').show();
    var img_path = URL.createObjectURL(e.target.files[0]);
    var file_type = e.target.files[0]["type"];
    var validimage = 0;
    if (file_type == "image/jpeg" || file_type == "image/jpg" || file_type == "image/png") {
        validimage = 1;
    } else {
        validimage = 0;
        jQuery('#automobile_candidate_profile_img_msg').addClass("error-msg");

        jQuery('#automobile_user_img_img').attr('src', "");
        jQuery('#automobile_user_img').attr('value', "");
    }

    // get width and height
    var _URL = window.URL || window.webkitURL;
    var files = e.target.files[0];


    var img = new Image(),
            fileSize = Math.round(files.size / 1024);
    if (fileSize >= 1024) {

        validimage = 0;
        jQuery('#automobile_candidate_profile_img_msg').addClass("error-msg");
        jQuery('#automobile_user_img_img').attr('src', "");
        jQuery('#automobile_user_img').attr('value', "");
    } else {
        validimage = 1;
    }
    img.onload = function () {
        var width = this.width,
                height = this.height,
                imgsrc = this.src;
        if (width >= 128 && height >= 68) {
            validimage = 1;
        } else {
            validimage = 0;
            jQuery('#automobile_candidate_profile_img_msg').addClass("error-msg");
            jQuery('#automobile_user_img_img').attr('src', "");
            jQuery('#automobile_user_img').attr('value', "");
        }

    };
    img.src = _URL.createObjectURL(files);
    // end get width and height
    if (validimage == 1) {
        jQuery('#automobile_candidate_profile_img_msg').removeClass("error-msg");

        jQuery('#automobile_user_img_img').attr('src', img_path);
        jQuery('#automobile_user_img').attr('value', img_path);

    }

});

jQuery('body').on('change', '.cs-uploadimginventory', function (e) {

    var img_path = URL.createObjectURL(e.target.files[0]);
    var file_type = e.target.files[0]["type"];
    var validimage = 0;
    if (file_type == "image/jpeg" || file_type == "image/jpg" || file_type == "image/png") {
        validimage = 1;
    } else {
        validimage = 0;
        jQuery('#automobile_edealer_user-post-vehicle_img_msg').addClass("error-msg");
        jQuery('#inventory_img_img').attr('src', "");
        jQuery('#inventory_img').attr('value', "");
    }

    // get width and height
    var _URL = window.URL || window.webkitURL;
    var files = e.target.files[0];


    var img = new Image(),
            fileSize = Math.round(files.size / 1024);
    if (fileSize >= 1024) {

        validimage = 0;
        jQuery('#automobile_edealer_user-post-vehicle_img_msg').addClass("error-msg");
        jQuery('#inventory_img_img').attr('src', "");
        jQuery('#inventory_img').attr('value', "");
    } else {
        validimage = 1;
    }
    img.onload = function () {
        var width = this.width,
                height = this.height,
                imgsrc = this.src;
        if (width >= 270 && height >= 210) {
            validimage = 1;
        } else {
            validimage = 0;
            jQuery('#automobile_edealer_user-post-vehicle_img_msg').addClass("error-msg");
            jQuery('#inventory_img_img').attr('src', "");
            jQuery('#inventory_img').attr('value', "");
        }

    };
    img.src = _URL.createObjectURL(files);
    // end get width and height

    if (validimage == 1) {
        jQuery('#automobile_edealer_user-post-vehicle_img_msg').removeClass("error-msg");

        jQuery('#inventory_img_img').attr('src', img_path);
        jQuery('#inventory_img').attr('value', img_path);

    }
});


$("#user-post-vehicle, #editinventory").on('change', 'input, select, textarea', function () {
    var $ = jQuery;
    if ($(this).val() != '') {
        $(this).css({"border": "1px solid #e4e4e4"});
    }
});

$(".cs-post-pkg").on('change', 'input, select, textarea', function () {
    var $ = jQuery;
    if ($(this).val() != '') {
        $(this).css({"border": "1px solid #e4e4e4"});
    }
});

$(document).on('click', '.cs-all-gates div', function () {
    var $ = jQuery;
    jQuery('.cs-all-gates').find('div > input:radio').prop("checked", false);
    jQuery('.cs-all-gates').find('div').removeClass('active');

    $(this).find('input:radio').prop("checked", true);
    $(this).addClass('active');
});

$('.cs-post-pkg').on('click', '.cs-all-gates li', function () {
    var $ = jQuery;
    jQuery('.cs-all-gates').find('li > input:radio').prop("checked", false);
    jQuery('.cs-all-gates').find('li').removeClass('active');

    $(this).find('input:radio').prop("checked", true);
    $(this).addClass('active');
});

$('.slct-cv-pkg').click(function () {

    $(this).next('input[type="radio"]').prop("checked", true);
});

$("#user-post-vehicle, #editinventory").on('click', '[id^="inventory_pckge_"], #automobile_inventory_featured', function (e) {

    var $ = jQuery;
    automobile_inventory_pricing();
});

$("#user-post-vehicle, #editinventory").on('click', '.cs-check-tabs', function (e) {

    var $ = jQuery;
    var automobile_ad_form = $('form#cs-emp-form');
    var automobile_form_validity = 'valid';
    var validation_message = jQuery("#edealer-dashboard").data('validationmsg');
    $(":input[required]").each(function () {
        if (!automobile_ad_form[0].checkValidity()) {
            automobile_form_validity = 'invalid';
            if ($(this).val() == '') {
                $(this).css({"border": "1px solid #ff0000"});
            }
        } else {
            if ($(this).val() != '') {
                $(this).css({"border": "1px solid #e4e4e4"});
            }
            automobile_form_validity = 'valid';
        }
    });
    if (automobile_form_validity == 'valid') {
        if (!jQuery(this).hasClass('cs-confrmation-tab') && !jQuery('.cs-post-inventory').hasClass('cs-prevent')) {
            $('.cs-post-inventory .tabs-nav').find('li').removeClass('active');
            if ($(this).hasClass('acc-submit')) {
                $('#automobile_pakg_step').addClass('active');
            } else {
                $(this).parent().parent('li').addClass('active');
            }
            var active = $('.cs-post-inventory').find('.tabs-nav .active a').attr('href');
            $('.cs-post-inventory .tabs-content').find('.tabs').hide();
            $('.cs-post-inventory .tabs-content').find('div#' + active).show();
            return false;
        } else {
            if (jQuery('#automobile_emp_email').hasClass('has-error'))
                jQuery("#automobile_emp_email").css({"border": "1px solid #ff0000"});
            if (jQuery('#automobile_user').hasClass('has-error'))
                jQuery("#automobile_user").css({"border": "1px solid #ff0000"});

            jQuery('#automobile_alerts').html('<div class="cs-remove-msg"><i class="icon-check-circle"></i>' + validation_message + '</div>');
            classes = jQuery('#automobile_alerts').attr('class');
            classes = classes + " active";
            jQuery('#automobile_alerts').addClass(classes);
            setTimeout(function () {
                jQuery('#automobile_alerts').removeClass("active");
            }, 4000);
        }
    } else {
        jQuery('#automobile_alerts').html('<div class="cs-remove-msg"><i class="icon-check-circle"></i>' + validation_message + '</div>');
        classes = jQuery('#automobile_alerts').attr('class');
        classes = classes + " active";
        jQuery('#automobile_alerts').addClass(classes);
        setTimeout(function () {
            jQuery('#automobile_alerts').removeClass("active");
        }, 4000);
        var automobile_detail_tab = $('#cs-detail-tab');
        $('.cs-post-inventory .tabs-nav').find('li').removeClass('active');
        automobile_detail_tab.parent().parent('li').addClass('active');
        var active = $('.cs-post-inventory').find('.tabs-nav .active a').attr('href');
        $('.cs-post-inventory .tabs-content').find('.tabs').hide();
        $('.cs-post-inventory .tabs-content').find('div#' + active).show();
        return false;
    }
});
$("#resumes").on('click', '[id^="jb-cont-send-"]', function (event) {

    var $ = jQuery;
    event.preventDefault();
    var candidate_id = jQuery(this).data('id');
    //var default_message ='Please ensure that all required fields are completed and formatted correctly'; //jQuery("#automobile_edealer_id_" + candidate_id).data('validationmsg');
    var default_message = jQuery("#automobile_edealer_id_" + candidate_id).data('validationmsg');
    jQuery('#automobile_edealer_id_' + candidate_id + ' #main-cs-loader_' + candidate_id).html('<i class="icon-spinner8 icon-spin"></i>');
    var ajaxurl = jQuery(".cs-resumes").data('adminurl');
    jQuery.ajax({
        type: "POST",
        url: ajaxurl,
        dataType: "html",
        data: $('#ajaxcontactform-' + candidate_id).serialize() + "&candidateid=" + candidate_id + "&action=ajaxcontact_send_mail",
        success: function (response) {
            if (response != "" && response == 'result2') {
                jQuery('#automobile_edealer_id_' + candidate_id + ' #main-cs-loader_' + candidate_id).html('');
                show_alert_msg(response);
            } else {
                if (response != "" && response == 'result1') {

                    jQuery('#automobile_edealer_id_' + candidate_id + ' #main-cs-loader_' + candidate_id).html('');
                    show_alert_msg(default_message);
                } else {
                    jQuery('#automobile_edealer_id_' + candidate_id + ' #main-cs-loader_' + candidate_id).html('');
                    show_alert_msg(response);
                }
            }
        }
    });
    return false;
});
/**
 * inventory post
 */
function automobile_inventory_post_tabs() {
    var preActive = jQuery('.cs-post-inventory').find('.tabs-nav .active a').attr('href');
    jQuery('.cs-post-inventory .tabs-content').find('.tabs').hide();
    jQuery('.cs-post-inventory .tabs-content').find('div#' + preActive).show();
    jQuery('.cs-post-inventory .tabs-nav a').click(function (event) {
        event.preventDefault();
        var activeCheck = jQuery(this).parents('li').hasClass('active');
        if (!activeCheck) {
            if (!jQuery(this).hasClass('cs-confrmation-tab') && !jQuery('.cs-post-inventory').hasClass('cs-prevent')) {
                jQuery('.cs-post-inventory .tabs-nav').find('li').removeClass('active');
                jQuery(this).parents('li').addClass('active');
                var active = jQuery('.cs-post-inventory').find('.tabs-nav .active a').attr('href');
                jQuery('.cs-post-inventory .tabs-content').find('.tabs').hide();
                jQuery('.cs-post-inventory .tabs-content').find('div#' + active).show();
            }
        }
    });
}
/**
 * number format
 */
function automobile_number_format(num) {
    return parseFloat(Math.round(num * 100) / 100).toFixed(2);
}

/**
 * Change Package
 */
function automobile_inventory_pricing() {
    "use strict";
    var $ = jQuery;
    var automobile_currency = $('.cs-sumry-clacs').data('currency');
    // Localize Text
    var automobile_subs_text = $('[name="inventory_pckge"]:checked').data('title') + ' ' + $('.cs-sumry-clacs').data('subs');
    var automobile_feat_text = $('.cs-sumry-clacs').data('feat');
    var automobile_totl_text = $('.cs-sumry-clacs').data('total');
    var automobile_vat_text = $('.cs-sumry-clacs').data('vat');
    var automobile_gtotl_text = $('.cs-sumry-clacs').data('gtotal');
    //

    var automobile_total_amount = 0;
    var automobile_inventory_fee = 0;
    var automobile_inventory_vat = 0;
    var automobile_app_html = '';
    var automobile_app_con = $('.cs-sumry-clacs');
    var packg_price = $('[name="inventory_pckge"]:checked').data('price');
    if (typeof (packg_price) !== 'undefined') {
        automobile_total_amount = parseFloat(automobile_total_amount) + parseFloat(packg_price);
        automobile_app_html += '<li><span>' + automobile_subs_text + '</span><strong>' + automobile_currency + automobile_number_format(packg_price) + '</strong></li>';
    }

    if (!$('[name="automobile_inventory_featured"]').hasClass('cs-paid')) {
        var feature_price = $('[name="automobile_inventory_featured"]:checked').data('price');
        if (typeof (feature_price) !== 'undefined' && feature_price > 0) {
            automobile_total_amount = parseFloat(automobile_total_amount) + parseFloat(feature_price);
            automobile_app_html += '<li><span>' + automobile_feat_text + '</span><strong>' + automobile_currency + automobile_number_format(feature_price) + '</strong></li>';
        }
    }

    automobile_app_html += '<li><span>' + automobile_totl_text + '</span><strong>' + automobile_currency + automobile_number_format(automobile_total_amount) + '</strong></li>';
    // VAT Percentage
    var automobile_vat_percent = $('.cs-package-detail').attr('data-vatp');
    if (typeof (automobile_vat_percent) !== 'undefined') {

        if (automobile_vat_percent < 0) {
            automobile_vat_percent = 1;
        }

        automobile_inventory_vat = (automobile_total_amount * automobile_vat_percent) / 100;
        $('.cs-package-detail').attr('data-vat', automobile_number_format(automobile_inventory_vat));
    }

    automobile_inventory_vat = $('.cs-package-detail').attr('data-vat');
    if (typeof (automobile_inventory_vat) !== 'undefined' && automobile_inventory_vat > 0) {
        automobile_total_amount = parseFloat(automobile_total_amount) + parseFloat(automobile_inventory_vat);
        automobile_app_html += '<li><span>' + automobile_vat_text + '</span><strong>' + automobile_currency + automobile_number_format(automobile_inventory_vat) + '</strong></li>';
    }

    automobile_app_html += '<li><span>' + automobile_gtotl_text + '</span><strong>' + automobile_currency + automobile_number_format(automobile_total_amount) + '</strong></li>';
    automobile_app_con.html(automobile_app_html);
    if (automobile_total_amount > 0) {
        $('.cs-pay-box').show("slow");
        $('.cs-add-up-box').hide("slow");
    } else {
        $('.cs-pay-box').hide("slow");
        $('.cs-add-up-box').show("slow");
    }
}

$(document).ready(function ($) {
    'use strict';
// Inventory Post Tab function call
    automobile_inventory_post_tabs();
    var url_hash = window.location.hash;
    if (url_hash != '') {

        $('ul.nav-tabs').find('li').removeClass('active');
        $('ul.nav-tabs').find('a[href="' + url_hash + '"]').parent('li').addClass('active');
        $('.cs-tabs').find('.tab-pane').removeClass('active');
        $('.cs-tabs').find('div' + url_hash).addClass('active');
    }

    $("[id^='automobile_emp_check_']").click(function () {

        $("#cs-not-emp").slideDown('slow', '', function () {
            setTimeout(function () {
                $("#cs-not-emp").slideUp('slow');
            }, 5000);
        });
    });
    $("[id^='automobile_empl_check_']").click(function () {
        var candidate_id = $(this).data('id');
        $("#automobile_empl_check_" + candidate_id).parent('span').append('<div class="cs-remove-msg">' + $("#cs-not-emp").html() + '</div>');
        setTimeout(function () {
            $("#automobile_empl_check_" + candidate_id).parent('span').find(".cs-remove-msg").slideUp('slow');
        }, 2000);
    });
    //tooltip
    $('[data-toggle="tooltip"]').tooltip();


    /*
     * for selct boxes design and jquery implementation
     */

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

});

/*
 * Enable map zooming with mouse scroll when the user clicks the map
 */
function automobile_user_avail(field) {

    var $ = jQuery;
    var ajaxurl = $('#cs-emp-form').data('ajaxurl');
    //var msg_con = $('#cs-email-chk');
    var email_pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    var user_email = $('input[name="automobile_emp_email"]').val();
    var username = $('input[name="automobile_user"]').val();
    if (user_email !== '' || username !== '') {
        if (field == 'email') {
            $('#automobile_user_email_validation').html('<i class="icon-spinner8 icon-spin"></i>');
        } else if (field == 'username') {
            $('#automobile_user_name_validation').html('<i class="icon-spinner8 icon-spin"></i>');
        }
        if (email_pattern.test(user_email)) {

            //msg_con.html('<i class="icon-spinner8 icon-spin"></i>');
            var dataString = 'emp_email=' + user_email
                    + '&emp_username=' + username
                    + '&action=automobile_check_user_avail';
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: dataString,
                dataType: "json",
                success: function (response) {
                    if (response.type == 'error') {
                        $('.cs-post-inventory, .cs-post-pkg').addClass('cs-prevent');
                        if (field == 'email') {
                            $("#automobile_emp_email").addClass("has-error");
                            $('#automobile_user_email_validation').html('<i class="icon-cross3"></i>');
                        } else if (field == 'username') {
                            $("#automobile_user").addClass("has-error");
                            $('#automobile_user_name_validation').html('<i class="icon-cross3"></i>');
                        }

                        show_alert_msg(response.msg);
                    } else if (response.type == 'success') {
                        $('.cs-post-inventory, .cs-post-pkg').removeClass('cs-prevent');
                        if (field == 'email') {
                            $("#automobile_emp_email").removeClass("has-error");
                            $('#automobile_user_email_validation').html('<i class="icon-checkmark6"></i>');
                        } else if (field == 'username') {
                            $("#automobile_user").removeClass("has-error");
                            $('#automobile_user_name_validation').html('<i class="icon-checkmark6"></i>');
                        }
                    }
                    //msg_con.html(response.msg);
                }
            });
            return false;
        }
    }

    return false;
}
/*
 * Add to list Function
 */
function automobile_add_to_list(admin_url, id) {
    "use strict";
    var dataString = 'id=' + id + '&action=automobile_add_to_list';
    jQuery('#add-to-btn-' + id).addClass('no-border');
    jQuery('#add-to-btn-' + id).html('<i class="icon-spinner8 icon-spin"></i>');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        dataType: "json",
        success: function (response) {
            jQuery('#add-to-btn-' + id).removeAttr('onclick');
            jQuery('#add-to-btn-' + id).html(response.btn_txt);
            jQuery('#add-to-btn-' + id).removeClass('no-border');
            show_alert_msg(response.msg);
        }
    });
    return false;
}

/*
 * Add to Favourite Function
 */
function automobile_add_favr(admin_url, id, type) {
    type = type || '';
    "use strict";
    var classes = '';
    var dataString = 'id=' + id + '&action=automobile_add_favr&type=' + type;
    jQuery('#add-to-btn-' + id).addClass('no-border');
    jQuery('#add-to-btn-' + id).html('<i class="icon-spinner8 icon-spin"></i>');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        dataType: "json",
        success: function (response) {
            //jQuery('#add-to-btn-' + id).parent('span').append('<div class="cs-remove-msg">' + response.msg + '</div>');
            jQuery('#automobile_alerts').html('<div class="cs-remove-msg"><i class="icon-check-circle"></i>' + response.msg + '</div>');
            classes = jQuery('#automobile_alerts').attr('class');
            classes = classes + " active";
            jQuery('#automobile_alerts').addClass(classes);
            jQuery('#add-to-btn-' + id).html(response.btn_txt);
            jQuery('#add-to-btn-' + id).removeClass('no-border');
            classes = jQuery('#add-to-btn-' + id).attr('class');
            if (response.class == 'add') {
                classes = classes + " automobile_resume_added";
                jQuery('#add-to-btn-' + id).addClass(classes);
                jQuery('#add-to-btn-' + id).attr("onclick", "automobile_add_favr('" + admin_url + "','" + id + "','remove')");
            } else {
                jQuery('#add-to-btn-' + id).attr("onclick", "automobile_add_favr('" + admin_url + "','" + id + "','add')");
                jQuery('#add-to-btn-' + id).removeClass("automobile_resume_added");
            }

            setTimeout(function () {
                //jQuery('#add-to-btn-' + id).parent('span').find(".cs-remove-msg").slideUp('slow');
                jQuery('#automobile_alerts').removeClass("active");
            }, 2000);
        }
    });
    return false;
}
/*
 * Dealer user-genral-setting Ajax Function
 */
function automobile_ajax_dealer_profile(admin_url, automobile_uid) {
    "use strict";
	
    var dataString = 'automobile_uid=' + automobile_uid + '&action=automobile_dealer_ajax_profile';
	 
    automobile_data_loader_load('#user-genral-setting');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {
			jQuery('#user-genral-setting').show();
            jQuery('#user-genral-setting').html(response);
            jQuery("#user-genral-setting .cs-loader").fadeTo(2000, 500).slideUp(500);
        }
    });
    return false;
}
/*
 * Dealer Favourite Resumes Ajax Function
 */
function automobile_ajax_shortlisted_vehicles(admin_url, automobile_uid) {
    "use strict";
    var dataString = 'automobile_uid=' + automobile_uid + '&action=automobile_ajax_shortlisted_vehicles';
    automobile_data_loader_load('#user-car-shortlist');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {
			
            jQuery('#user-car-shortlist').html(response);
            jQuery("#user-car-shortlist .cs-loader").fadeTo(2000, 500).slideUp(500);
        }
    });
    return false;
}
/*
 * Dealer Manage Inventorys Ajax Function
 */
function automobile_ajax_manage_inventory(admin_url, automobile_uid, uri) {
    "use strict";
    var dataString = 'automobile_uid=' + automobile_uid + '&automobile_uri=' + uri + '&action=automobile_ajax_manage_inventory';
    automobile_data_loader_load('#user-car-listing');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {
            jQuery('#user-car-listing').html(response);
            jQuery("#user-car-listing .cs-loader").fadeTo(2000, 500).slideUp(500);
        }
    });
    return false;
}
/*
 * Dealer Transactions Ajax Function
 */
function automobile_ajax_trans_history(admin_url, automobile_uid) {
    "use strict";
    var dataString = 'automobile_uid=' + automobile_uid + '&action=automobile_ajax_trans_history';
    automobile_data_loader_load('#transactions');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {
            jQuery("#transactions").html(response);
            jQuery("#transactions .cs-loader").fadeTo(2000, 500).slideUp(500);
        }
    });
    return false;
}
/*
 * Dealer inventory packages Ajax Function
 */
function automobile_ajax_inventory_packages(pkg_array) {
    "use strict";

    if (typeof (pkg_array) !== 'undefined') {
        var perc_obj = JSON.parse(pkg_array);
        var admin_url = perc_obj.ajax_url;
        var automobile_uid = perc_obj.user_id;
        var dataString = 'automobile_uid=' + automobile_uid +
                '&pkg_array=' + pkg_array +
                '&action=automobile_ajax_inventory_packages';
        automobile_data_loader_load('#packages');
        jQuery.ajax({
            type: "POST",
            url: admin_url,
            data: dataString,
            success: function (response) {
                jQuery('#packages').html(response);
                jQuery("#packages .cs-loader").fadeTo(2000, 500).slideUp(500);
            }
        });
    }

    return false;
}
/*
 * Dealer Post Inventory Ajax Function
 */
function automobile_dealer_post_inventory(admin_url, automobile_uid, pkg_array) {
    "use strict";
    
    if (typeof (pkg_array) !== 'undefined' && pkg_array !== '') {

        var dataString = 'automobile_uid=' + automobile_uid +
                '&automobile_posting=new&pkg_array=' + escape(pkg_array) +
                '&action=automobile_dealer_post_inventory';
        automobile_data_loader_load('#user-post-vehicle');

        jQuery.ajax({
            type: "POST",
            url: admin_url,
            data: dataString,
            success: function (response) {
                jQuery('#user-post-vehicle').html(response);
                jQuery("#user-post-vehicle .cs-loader").fadeTo(2000, 500).slideUp(500);
                // Inventory Post Tab function call
                automobile_inventory_post_tabs();
            }
        });
    }
    return false;
}
/*
 * Inventory Delete Function
 */
function automobile_inventory_delete(admin_url, u_id) {
    "use strict";
    document.getElementById('id_confrmdiv').style.display = "block"; //this is the replace of this line
    document.getElementById('id_truebtn').onclick = function () {
        var dataString;
        dataString = 'u_id=' + u_id + '&action=automobile_inventory_delete';
        jQuery('#cs-inventory-' + u_id).html('<i class="icon-spinner8 icon-spin"></i>');
        jQuery.ajax({
            type: "POST",
            url: admin_url,
            data: dataString,
            success: function (response) {
                jQuery('#cs-inventory-' + u_id).html(response);
                jQuery('#cs-inventory-parent-' + u_id).hide("slow");
            }
        });
        document.getElementById('id_confrmdiv').style.display = "none";
        return false;
    };

    document.getElementById('id_falsebtn').onclick = function () {
        document.getElementById('id_confrmdiv').style.display = "none";
        return false;
    };
}

/*
 * Update Trans Function
 */
function automobile_update_transaction_status(admin_url, automobile_id, automobile_val) {
    "use strict";
    var dataString = 'automobile_id=' + automobile_id + '&automobile_val=' + automobile_val + '&action=update_trans';
    jQuery('#cs-status-' + automobile_id + ' .cs-holder').html('<i class="icon-spinner8 icon-spin"></i>');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {
            jQuery('#cs-status-' + automobile_id + ' .cs-holder').html('<i style="left:-48px;">' + response + '</i>');
            setTimeout(function () {
                jQuery('#cs-status-' + automobile_id + ' .cs-holder').find("i").slideUp('slow');
            }, 2000);
        }
    });
    return false;
}
/*
 * Favorite Delete Function
 */
function automobile_unset_user_fav(admin_url, automobile_id) {
    "use strict";
    var dataString = 'automobile_id=' + automobile_id + '&action=automobile_unset_user_fav';
    jQuery('#cs-rem-' + automobile_id).html('<i class="icon-spinner8 icon-spin"></i>');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        dataType: "json",
        data: dataString,
        success: function (response) {
            jQuery('#cs-rem-' + automobile_id).html('');
            jQuery('#cs-fav-counts').html(response.count);
            jQuery('#cs-rem-' + automobile_id).parent('li').hide("slow");
        }
    });
    return false;
}
/*
 * unset user inventory av
 */
function automobile_map_select_style_2(style) {
    var styles = '';
    if (style == 'map-box') {
        var styles = [
            {
                "featureType": "water",
                "stylers": [
                    {
                        "saturation": 43
                    },
                    {
                        "lightness": -11
                    },
                    {
                        "hue": "#0088ff"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "hue": "#ff0000"
                    },
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 99
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#808080"
                    },
                    {
                        "lightness": 54
                    }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ece2d9"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ccdca1"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#767676"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "poi",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "landscape.natural",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#b8cb93"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "poi.sports_complex",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "poi.medical",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "poi.business",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            }
        ];
    } else if (style == 'blue-water') {
        var styles = [
            {
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#444444"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#f2f2f2"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 45
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#46bcec"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            }
        ];
    } else if (style == 'icy-blue') {
        var styles = [
            {
                "stylers": [
                    {
                        "hue": "#2c3e50"
                    },
                    {
                        "saturation": 250
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [
                    {
                        "lightness": 50
                    },
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            }
        ];
    } else if (style == 'bluish') {
        var styles = [
            {
                "stylers": [
                    {
                        "hue": "#007fff"
                    },
                    {
                        "saturation": 89
                    }
                ]
            },
            {
                "featureType": "water",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "administrative.country",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            }
        ];
    } else if (style == 'light-blue-water') {
        var styles = [
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "hue": "#71d6ff"
                    },
                    {
                        "saturation": 100
                    },
                    {
                        "lightness": -5
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "hue": "#ffffff"
                    },
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 100
                    },
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "hue": "#ffffff"
                    },
                    {
                        "saturation": 0
                    },
                    {
                        "lightness": 100
                    },
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry",
                "stylers": [
                    {
                        "hue": "#deecec"
                    },
                    {
                        "saturation": -73
                    },
                    {
                        "lightness": 72
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "labels",
                "stylers": [
                    {
                        "hue": "#bababa"
                    },
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 25
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "geometry",
                "stylers": [
                    {
                        "hue": "#e3e3e3"
                    },
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 0
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [
                    {
                        "hue": "#ffffff"
                    },
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 100
                    },
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "labels",
                "stylers": [
                    {
                        "hue": "#59cfff"
                    },
                    {
                        "saturation": 100
                    },
                    {
                        "lightness": 34
                    },
                    {
                        "visibility": "on"
                    }
                ]
            }
        ];
    } else if (style == 'clad-me') {
        var styles = [
            {
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#444444"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#f2f2f2"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 45
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#4f595d"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            }
        ];
    } else if (style == 'chilled') {
        var styles = [
            {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "stylers": [
                    {
                        "hue": 149
                    },
                    {
                        "saturation": -78
                    },
                    {
                        "lightness": 0
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "stylers": [
                    {
                        "hue": -31
                    },
                    {
                        "saturation": -40
                    },
                    {
                        "lightness": 2.8
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "label",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "stylers": [
                    {
                        "hue": 163
                    },
                    {
                        "saturation": -26
                    },
                    {
                        "lightness": -1.1
                    }
                ]
            },
            {
                "featureType": "transit",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "water",
                "stylers": [
                    {
                        "hue": 3
                    },
                    {
                        "saturation": -24.24
                    },
                    {
                        "lightness": -38.57
                    }
                ]
            }
        ];
    } else if (style == 'two-tone') {
        var styles = [
            {
                "featureType": "all",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#c9323b"
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#c9323b"
                    },
                    {
                        "weight": 1.2
                    }
                ]
            },
            {
                "featureType": "administrative.locality",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "lightness": "-1"
                    }
                ]
            },
            {
                "featureType": "administrative.neighborhood",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "lightness": "0"
                    },
                    {
                        "saturation": "0"
                    }
                ]
            },
            {
                "featureType": "administrative.neighborhood",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "weight": "0.01"
                    }
                ]
            },
            {
                "featureType": "administrative.land_parcel",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "weight": "0.01"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#c9323b"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#99282f"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#99282f"
                    }
                ]
            },
            {
                "featureType": "road.highway.controlled_access",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#99282f"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#99282f"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#99282f"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#99282f"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#090228"
                    }
                ]
            }
        ];
    } else if (style == 'light-and-dark') {
        var styles = [
            {
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#444444"
                    }
                ]
            },
            {
                "featureType": "administrative.land_parcel",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#f2f2f2"
                    }
                ]
            },
            {
                "featureType": "landscape.natural",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#052366"
                    },
                    {
                        "saturation": "-70"
                    },
                    {
                        "lightness": "85"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "simplified"
                    },
                    {
                        "lightness": "-53"
                    },
                    {
                        "weight": "1.00"
                    },
                    {
                        "gamma": "0.98"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 45
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [
                    {
                        "saturation": "-18"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#57677a"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            }
        ];
    } else if (style == 'ilustracao') {
        var styles = [
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [
                    {
                        "hue": "#71ABC3"
                    },
                    {
                        "saturation": -10
                    },
                    {
                        "lightness": -21
                    },
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "landscape.natural",
                "elementType": "geometry",
                "stylers": [
                    {
                        "hue": "#7DC45C"
                    },
                    {
                        "saturation": 37
                    },
                    {
                        "lightness": -41
                    },
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "geometry",
                "stylers": [
                    {
                        "hue": "#C3E0B0"
                    },
                    {
                        "saturation": 23
                    },
                    {
                        "lightness": -12
                    },
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "hue": "#A19FA0"
                    },
                    {
                        "saturation": -98
                    },
                    {
                        "lightness": -20
                    },
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [
                    {
                        "hue": "#FFFFFF"
                    },
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 100
                    },
                    {
                        "visibility": "simplified"
                    }
                ]
            }
        ];
    } else if (style == 'flat-pale') {
        var styles = [
            {
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#6195a0"
                    }
                ]
            },
            {
                "featureType": "administrative.province",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "geometry",
                "stylers": [
                    {
                        "lightness": "0"
                    },
                    {
                        "saturation": "0"
                    },
                    {
                        "color": "#f5f5f2"
                    },
                    {
                        "gamma": "1"
                    }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "all",
                "stylers": [
                    {
                        "lightness": "-3"
                    },
                    {
                        "gamma": "1.00"
                    }
                ]
            },
            {
                "featureType": "landscape.natural.terrain",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#bae5ce"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 45
                    },
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#fac9a9"
                    },
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "labels.text",
                "stylers": [
                    {
                        "color": "#4e4e4e"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#787878"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "transit.station.airport",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "hue": "#0a00ff"
                    },
                    {
                        "saturation": "-77"
                    },
                    {
                        "gamma": "0.57"
                    },
                    {
                        "lightness": "0"
                    }
                ]
            },
            {
                "featureType": "transit.station.rail",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#43321e"
                    }
                ]
            },
            {
                "featureType": "transit.station.rail",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "hue": "#ff6c00"
                    },
                    {
                        "lightness": "4"
                    },
                    {
                        "gamma": "0.75"
                    },
                    {
                        "saturation": "-68"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#eaf6f8"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#c7eced"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "lightness": "-49"
                    },
                    {
                        "saturation": "-53"
                    },
                    {
                        "gamma": "0.79"
                    }
                ]
            }
        ];
    } else if (style == 'title') {
        var styles =
                [
                    {
                        "featureType": "administrative",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#444444"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.neighborhood",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "visibility": "off"
                            },
                            {
                                "hue": "#17ff00"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.neighborhood",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "visibility": "on"
                            }
                        ]
                    },
                    {
                        "featureType": "landscape",
                        "elementType": "all",
                        "stylers": [
                            {
                                "color": "#f2f2f2"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "all",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "poi.business",
                        "elementType": "all",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "poi.business",
                        "elementType": "labels.text",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "poi.business",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "all",
                        "stylers": [
                            {
                                "saturation": -100
                            },
                            {
                                "lightness": 45
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "all",
                        "stylers": [
                            {
                                "visibility": "simplified"
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "color": "#ff0000"
                            }
                        ]
                    },
                    {
                        "featureType": "road.arterial",
                        "elementType": "labels.icon",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "road.local",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "visibility": "on"
                            }
                        ]
                    },
                    {
                        "featureType": "transit",
                        "elementType": "all",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "all",
                        "stylers": [
                            {
                                "color": "#0088cc"
                            },
                            {
                                "visibility": "on"
                            }
                        ]
                    }
                ]

                ;
    } else if (style == 'moret') {
        var styles = [
            {
                "featureType": "administrative.country",
                "elementType": "labels.text",
                "stylers": [
                    {
                        "color": "#737373"
                    },
                    {
                        "weight": "0.01"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": "97"
                    },
                    {
                        "color": "#ffffff"
                    },
                    {
                        "visibility": "simplified"
                    },
                    {
                        "lightness": "81"
                    }
                ]
            },
            {
                "featureType": "landscape.natural.landcover",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": "100"
                    },
                    {
                        "lightness": "100"
                    },
                    {
                        "gamma": "10.00"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": "100"
                    },
                    {
                        "lightness": "100"
                    },
                    {
                        "gamma": "10.00"
                    },
                    {
                        "weight": "0.01"
                    }
                ]
            },
            {
                "featureType": "poi.attraction",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#565656"
                    }
                ]
            },
            {
                "featureType": "poi.business",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#565656"
                    }
                ]
            },
            {
                "featureType": "poi.government",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#565656"
                    }
                ]
            },
            {
                "featureType": "poi.medical",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#565656"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": "100"
                    },
                    {
                        "lightness": "100"
                    },
                    {
                        "gamma": "10.00"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#565656"
                    }
                ]
            },
            {
                "featureType": "poi.place_of_worship",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#565656"
                    }
                ]
            },
            {
                "featureType": "poi.school",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#565656"
                    }
                ]
            },
            {
                "featureType": "poi.sports_complex",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#565656"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": "-70"
                    },
                    {
                        "lightness": "43"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#39d2ca"
                    }
                ]
            }
        ];
    }
    return styles;
}


function automobile_unset_user_inventory_fav(admin_url, post_id) {

    "use strict";
    //var post_id = jQuery(_this).data("postid");
    var dataString = 'post_id=' + post_id + '&action=automobile_delete_wishlist';
    jQuery('#cs-rem-' + post_id).html('<i class="icon-spinner8 icon-spin"></i>');
    var count = jQuery('#cs-fav-counts').html();
    count = count - 1;
    if (count < 0) {
        count = 0;
    }
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {
            jQuery('#cs-rem-' + post_id).html('');
            jQuery('#cs-fav-counts').html(count);
            jQuery('#cs-heading-counts').html(count);
            jQuery('#cs-rem-' + post_id).parent('li').hide('slow');
        }
    });
    return false;
}
function automobile_googlecluster_listing_map(id, Latitude, Longitude, cluster_icon, marker_icon, dataobj, map_zoom, map_color, autozoom, automobile_map_lock, style) {


    var markerClusterer = null;
    var map = null;
    var open_info_window = null;
    var imageUrl;

    var lock = 'unlock';
    var automobile_scrollwheel = false;
    var automobile_draggable = true;

    if (automobile_map_lock == 'on') {
        var lock = 'lock';
    }

    if (lock == 'lock') {
        var automobile_scrollwheel = false;
        var automobile_draggable = false;
    }

    if (!jQuery.isNumeric(map_zoom)) {
        var map_zoom = 6;
    }
    if (Latitude != '' && Longitude != '') {
        var map_type_id = google.maps.MapTypeId.ROADMAP;
        map = new google.maps.Map(document.getElementById('automobile_map_' + id), {
            zoom: map_zoom,
            icon: marker_icon,
            scrollwheel: automobile_scrollwheel,
            draggable: automobile_draggable,
            streetViewControl: true,
            center: new google.maps.LatLng(Latitude, Longitude),
            position: new google.maps.LatLng(Latitude, Longitude),
            mapTypeId: map_type_id,
        });

        if (style != '') {
            var styles = automobile_inventorydoor_map_select_style(style);
            if (styles != '') {
                var styledMap = new google.maps.StyledMapType(styles,
                        {name: 'Styled Map'});
                map.mapTypes.set('map_style', styledMap);
                map.setMapTypeId('map_style');
            }
        }

        var myLatlng = new google.maps.LatLng(Latitude, Longitude);
        var markers = [];
        var LatLngList = [];
        var mc;
        jQuery.each(dataobj.posts, function (index, element) {
            var i = element.post_id;

            var latLng = new google.maps.LatLng(element.latitude, element.longitude);
            LatLngList.push(new google.maps.LatLng(element.latitude, element.longitude));
            var marker = new google.maps.Marker({
                position: latLng,
                center: latLng,
                draggable: false,
                icon: marker_icon,
                content: element.post_title,
            });
            map.addListener('click', function() {
                map.set('scrollwheel', true);
            });
            var automobile_location = '';
            var automobile_position = '';
            var automobile_author = '';
            var automobile_price = '';
            if (element.complete_address != '' && (typeof element.complete_address != "undefined")) {
                automobile_location = '<span class="cs-location">' + element.complete_address + '</span>';
            }
            if (element.automobile_phone_number != '') {
                automobile_position = '<div class="post-option"><span class="cs-postion"><strong>' + element.automobile_phone_number + '</strong></div>';
            }

            if (element.author != '' && (typeof element.author != "undefined")) {
                automobile_author = '<span class="cs-author"><h5>' + element.author + '</h5>'+ element.user_status_icon +'</span>';
            }
           
            if (element.new_price != '' && (typeof element.new_price != "undefined")) {
                automobile_price = '<span class="cs-price">' + element.new_price + '</span>';
            }
            var contentString = '<div class="map-tooltip">\
				<div class="cs-media">\
				  <figure><img alt="" src="' + element.map_image + '"></figure>\
				</div>\
				<div class="cs-text">\
                                ' + automobile_author + '\
				<div class="cs-post-title">\
                                        <h6><a href="' + element.permalink + '">' + element.post_title + '</a></h6>\n\
                                        ' + automobile_price + '\
					' + automobile_location + '\
				  </div>\
				  ' + automobile_position + '\
				</div>\
			  </div>';

            var infobox = new InfoBox({
                boxClass: 'automobile_map_info',
                content: contentString,
                disableAutoPan: true,
                maxWidth: 0,
                alignBottom: true,
                //pixelOffset: new google.maps.Size(139, -152),
                zIndex: null,
                closeBoxMargin: "2px",
                closeBoxURL: "close",
                infoBoxClearance: new google.maps.Size(1, 1),
                isHidden: false,
                pane: "floatPane",
                enableEventPropagation: false,
                pixelOffset: new google.maps.Size(-390, 121),
                zIndex: null,
                        boxStyle: {
                            width: "344px",
                            height: "190px",
                        },
            });
            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    map.panTo(marker.getPosition());
                    map.panBy(40, -70);
                    if (open_info_window)
                        open_info_window.close();
                    infobox.open(map, marker);
                    open_info_window = infobox;
                }
            })(marker, i));
            markers.push(marker);
        });


        var mcOptions;
        var clusterStyles = [
            {
                textColor: map_color,
                opt_textColor: map_color,
                url: cluster_icon,
                height: 40,
                width: 40,
                textSize: 12
            }
        ];
        mcOptions = {
            gridSize: 45,
            ignoreHidden: true,
            maxZoom: 12,
            styles: clusterStyles
        };

        mc = new MarkerClusterer(map, markers, mcOptions);
        if (document.getElementById('gmaplock' + id)) {
            google.maps.event.addDomListener(document.getElementById('gmaplock' + id), 'click', function () {
                if (lock == 'lock') {
                    map.setOptions({scrollwheel: true});
                    map.setOptions({draggable: true});
                    document.getElementById('gmaplock' + id).innerHTML = '<i class="icon-unlock"></i>';
                    lock = 'unlock';
                } else if (lock == 'unlock') {
                    map.setOptions({scrollwheel: false});
                    map.setOptions({draggable: false});
                    document.getElementById('gmaplock' + id).innerHTML = '<i class="icon-lock3"></i>';
                    lock = 'lock';
                }
            });
        }
        map.setZoom(map_zoom);
    }
}
function automobile_googlecluster_map(id, Latitude, Longitude, cluster_icon, marker_icon, dataobj, map_zoom, map_color, autozoom, automobile_map_lock, style, map_control) {


    var markerClusterer = null;
    var map = null;
    var open_info_window = null;
    var imageUrl;

    var lock = 'unlock';
    var automobile_scrollwheel = false;
    var automobile_draggable = true;

    if (automobile_map_lock == 'on') {
        var lock = 'lock';
    }

    if (lock == 'lock') {
        var automobile_scrollwheel = false;
        var automobile_draggable = false;
    }
   if( map_control == null ){
       map_control = true;
   }

    if (!jQuery.isNumeric(map_zoom)) {
        var map_zoom = 6;
    }
    if (Latitude != '' && Longitude != '') {
        var map_type_id = google.maps.MapTypeId.ROADMAP;
        map = new google.maps.Map(document.getElementById('automobile_map_' + id), {
            zoom: map_zoom,
            icon: marker_icon,
            scrollwheel: automobile_scrollwheel,
            draggable: automobile_draggable,
            streetViewControl: true,
            mapTypeControl: map_control,
            center: new google.maps.LatLng(Latitude, Longitude),
            position: new google.maps.LatLng(Latitude, Longitude),
            mapTypeId: map_type_id,
        });

        if (style != '') {
            var styles = automobile_inventorydoor_map_select_style(style);
            if (styles != '') {
                var styledMap = new google.maps.StyledMapType(styles,
                        {name: 'Styled Map'});
                map.mapTypes.set('map_style', styledMap);
                map.setMapTypeId('map_style');
            }
        }

        var myLatlng = new google.maps.LatLng(Latitude, Longitude);
        var markers = [];
        var LatLngList = [];
        var mc;
        jQuery.each(dataobj.posts, function (index, element) {
            var i = element.post_id;

            var latLng = new google.maps.LatLng(element.latitude, element.longitude);
            LatLngList.push(new google.maps.LatLng(element.latitude, element.longitude));
            var marker = new google.maps.Marker({
                position: latLng,
                center: latLng,
                draggable: false,
                icon: marker_icon,
                content: element.post_title,
            });
            map.addListener('click', function() {
                map.set('scrollwheel', true);
            });
//            var automobile_location = '';
//            var automobile_position = '';
//            var automobile_author = '';
//            var automobile_price = '';
//            if (element.complete_address != '' && (typeof element.complete_address != "undefined")) {
//                automobile_location = '<span class="cs-location">' + element.complete_address + '</span>';
//            }
//            if (element.position != '' && element.company != '') {
//                automobile_position = '<div class="post-option"><span class="cs-postion"><em>' + element.position + ' </em> @ ' + element.company + '</span></div>';
//            }
//
//            if (element.author != '' && (typeof element.author != "undefined")) {
//                automobile_author = '<span class="cs-author"><h5>' + element.author + '</h5>'+ element.user_status_icon +'</span>';
//            }
//           
//            if (element.new_price != '' && (typeof element.new_price != "undefined")) {
//                automobile_price = '<span class="cs-price">' + element.new_price + '</span>';
//            }
//            var contentString = '<div class="map-tooltip">\
//				<div class="cs-media">\
//				  <figure><img alt="" src="' + element.map_image + '"></figure>\
//				</div>\
//				<div class="cs-text">\
//                                ' + automobile_author + '\
//				<div class="cs-post-title">\
//                                        <h6><a href="' + element.permalink + '">' + element.post_title + '</a></h6>\n\
//                                        ' + automobile_price + '\
//					' + automobile_location + '\
//				  </div>\
//				  ' + automobile_position + '\
//				</div>\
//			  </div>';

//            var infobox = new InfoBox({
//                boxClass: 'automobile_map_info',
//                content: contentString,
//                disableAutoPan: true,
//                maxWidth: 0,
//                alignBottom: true,
//                //pixelOffset: new google.maps.Size(139, -152),
//                zIndex: null,
//                closeBoxMargin: "2px",
//                closeBoxURL: "close",
//                infoBoxClearance: new google.maps.Size(1, 1),
//                isHidden: false,
//                pane: "floatPane",
//                enableEventPropagation: false,
//                pixelOffset: new google.maps.Size(-390, 121),
//                zIndex: null,
//                        boxStyle: {
//                            width: "344px",
//                            height: "190px",
//                        },
//            });
//            google.maps.event.addListener(marker, 'click', (function (marker, i) {
//                return function () {
//                    map.panTo(marker.getPosition());
//                    map.panBy(40, -70);
//                    if (open_info_window)
//                        open_info_window.close();
//                    infobox.open(map, marker);
//                    open_info_window = infobox;
//                }
//            })(marker, i));
            markers.push(marker);
        });


        var mcOptions;
        var clusterStyles = [
            {
                textColor: map_color,
                opt_textColor: map_color,
                url: cluster_icon,
                height: 40,
                width: 40,
                textSize: 12
            }
        ];
        mcOptions = {
            gridSize: 45,
            ignoreHidden: true,
            maxZoom: 12,
            styles: clusterStyles
        };

        mc = new MarkerClusterer(map, markers, mcOptions);
        if (document.getElementById('gmaplock' + id)) {
            google.maps.event.addDomListener(document.getElementById('gmaplock' + id), 'click', function () {
                if (lock == 'lock') {
                    map.setOptions({scrollwheel: true});
                    map.setOptions({draggable: true});
                    document.getElementById('gmaplock' + id).innerHTML = '<i class="icon-unlock"></i>';
                    lock = 'unlock';
                } else if (lock == 'unlock') {
                    map.setOptions({scrollwheel: false});
                    map.setOptions({draggable: false});
                    document.getElementById('gmaplock' + id).innerHTML = '<i class="icon-lock3"></i>';
                    lock = 'lock';
                }
            });
        }
        map.setZoom(map_zoom);
    }
}

function automobile_map_select_style_3(style) {
    var styles = '';
    if (style == 'style-1') {
        var styles = [
            {
                "featureType": "administrative",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "lightness": 33
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#f2e5d4"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#c5dac6"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "lightness": 20
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "lightness": 20
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#c5c6c6"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#e4d7c6"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#fbfaf7"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#acbcc9"
                    }
                ]
            }
        ];
    } else if (style == 'style-2') {
        var styles = [
            {
                "featureType": "landscape",
                "stylers": [
                    {
                        "hue": "#FFBB00"
                    },
                    {
                        "saturation": 43.400000000000006
                    },
                    {
                        "lightness": 37.599999999999994
                    },
                    {
                        "gamma": 1
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "stylers": [
                    {
                        "hue": "#FFC200"
                    },
                    {
                        "saturation": -61.8
                    },
                    {
                        "lightness": 45.599999999999994
                    },
                    {
                        "gamma": 1
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "stylers": [
                    {
                        "hue": "#FF0300"
                    },
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 51.19999999999999
                    },
                    {
                        "gamma": 1
                    }
                ]
            },
            {
                "featureType": "road.local",
                "stylers": [
                    {
                        "hue": "#FF0300"
                    },
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 52
                    },
                    {
                        "gamma": 1
                    }
                ]
            },
            {
                "featureType": "water",
                "stylers": [
                    {
                        "hue": "#0078FF"
                    },
                    {
                        "saturation": -13.200000000000003
                    },
                    {
                        "lightness": 2.4000000000000057
                    },
                    {
                        "gamma": 1
                    }
                ]
            },
            {
                "featureType": "poi",
                "stylers": [
                    {
                        "hue": "#00FF6A"
                    },
                    {
                        "saturation": -1.0989010989011234
                    },
                    {
                        "lightness": 11.200000000000017
                    },
                    {
                        "gamma": 1
                    }
                ]
            }
        ];
    } else if (style == 'style-3') {
        var styles = [
            {
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#444444"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#f2f2f2"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 45
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#46bcec"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            }
        ];
    }
    return styles;
}

function automobile_inventorydoor_map_select_style(style) {
    var styles = '';
    if (style == 'style-1') {
        var styles = [
            {
                "featureType": "administrative",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "lightness": 33
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#f2e5d4"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#c5dac6"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "lightness": 20
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "lightness": 20
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#c5c6c6"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#e4d7c6"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#fbfaf7"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "color": "#acbcc9"
                    }
                ]
            }
        ];
    } else if (style == 'style-2') {
        var styles = [
            {
                "featureType": "landscape",
                "stylers": [
                    {
                        "hue": "#FFBB00"
                    },
                    {
                        "saturation": 43.400000000000006
                    },
                    {
                        "lightness": 37.599999999999994
                    },
                    {
                        "gamma": 1
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "stylers": [
                    {
                        "hue": "#FFC200"
                    },
                    {
                        "saturation": -61.8
                    },
                    {
                        "lightness": 45.599999999999994
                    },
                    {
                        "gamma": 1
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "stylers": [
                    {
                        "hue": "#FF0300"
                    },
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 51.19999999999999
                    },
                    {
                        "gamma": 1
                    }
                ]
            },
            {
                "featureType": "road.local",
                "stylers": [
                    {
                        "hue": "#FF0300"
                    },
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 52
                    },
                    {
                        "gamma": 1
                    }
                ]
            },
            {
                "featureType": "water",
                "stylers": [
                    {
                        "hue": "#0078FF"
                    },
                    {
                        "saturation": -13.200000000000003
                    },
                    {
                        "lightness": 2.4000000000000057
                    },
                    {
                        "gamma": 1
                    }
                ]
            },
            {
                "featureType": "poi",
                "stylers": [
                    {
                        "hue": "#00FF6A"
                    },
                    {
                        "saturation": -1.0989010989011234
                    },
                    {
                        "lightness": 11.200000000000017
                    },
                    {
                        "gamma": 1
                    }
                ]
            }
        ];
    } else if (style == 'style-3') {
        var styles = [
            {
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#444444"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#f2f2f2"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 45
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#46bcec"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            }
        ];
    } else if (style == 'shunli_home') {
        var styles = [
            {
                "featureType": "administrative.country",
                "elementType": "labels.text",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            }
        ];
    } else if (style == 'shunli_home') {
        var styles = [
            {
                "featureType": "administrative.country",
                "elementType": "labels.text",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            }
        ];
    } else if (style == 'new') {
        var styles = [
            {
                "featureType": "all",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#63b5e5"
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "gamma": 0.01
                    },
                    {
                        "lightness": 20
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "saturation": -31
                    },
                    {
                        "lightness": -33
                    },
                    {
                        "weight": 2
                    },
                    {
                        "gamma": 0.8
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "geometry",
                "stylers": [
                    {
                        "lightness": 30
                    },
                    {
                        "saturation": 30
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "geometry",
                "stylers": [
                    {
                        "saturation": 20
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "geometry",
                "stylers": [
                    {
                        "lightness": 20
                    },
                    {
                        "saturation": -20
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [
                    {
                        "lightness": 10
                    },
                    {
                        "saturation": -30
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "saturation": 25
                    },
                    {
                        "lightness": 25
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "lightness": -20
                    }
                ]
            }
        ];
    } else if (style == 'pinky_wedding') {
        var styles = [
            {
                "featureType": "all",
                "elementType": "all",
                "stylers": [
                    {
                        "hue": "#ff0000"
                    },
                    {
                        "visibility": "on"
                    },
                    {
                        "lightness": "80"
                    },
                    {
                        "gamma": "0.42"
                    },
                    {
                        "saturation": "-93"
                    },
                    {
                        "weight": "1.44"
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#63b5e5"
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ffe4e8"
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#f0a7a7"
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.text",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "gamma": 0.01
                    },
                    {
                        "lightness": 20
                    },
                    {
                        "color": "#fff7f7"
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "saturation": -31
                    },
                    {
                        "lightness": -33
                    },
                    {
                        "weight": 2
                    },
                    {
                        "gamma": 0.8
                    },
                    {
                        "color": "#c4aeae"
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "geometry",
                "stylers": [
                    {
                        "lightness": 30
                    },
                    {
                        "saturation": 30
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "geometry",
                "stylers": [
                    {
                        "saturation": 20
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "geometry",
                "stylers": [
                    {
                        "lightness": 20
                    },
                    {
                        "saturation": -20
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [
                    {
                        "lightness": 10
                    },
                    {
                        "saturation": -30
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "saturation": 25
                    },
                    {
                        "lightness": 25
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "lightness": -20
                    }
                ]
            }
        ];
    } else if (style == 'photobooth') {
        var styles = [
            {
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#444444"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#f2f2f2"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 45
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#b3dbea"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            }
        ];
    } else if (style == 'mapa_blanco') {
        var styles = [
            {
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#444444"
                    }
                ]
            },
            {
                "featureType": "administrative.country",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative.country",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "administrative.country",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "administrative.country",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative.province",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "administrative.province",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative.province",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "administrative.province",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "administrative.province",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "administrative.locality",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative.locality",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "administrative.locality",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#f2f2f2"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 45
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#32577b"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            }
        ];
    } else if (style == 'mint') {
        var styles = [
            {
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#444444"
                    }
                ]
            },
            {
                "featureType": "administrative.country",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "administrative.country",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "administrative.country",
                "elementType": "labels.text",
                "stylers": [
                    {
                        "lightness": "100"
                    }
                ]
            },
            {
                "featureType": "administrative.country",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#040404"
                    }
                ]
            },
            {
                "featureType": "administrative.country",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "hue": "#ff0000"
                    }
                ]
            },
            {
                "featureType": "administrative.country",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "saturation": "83"
                    },
                    {
                        "lightness": "100"
                    }
                ]
            },
            {
                "featureType": "administrative.land_parcel",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "hue": "#ff0000"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#f2f2f2"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": -100
                    },
                    {
                        "lightness": 45
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "color": "#c8e6e0"
                    },
                    {
                        "visibility": "on"
                    }
                ]
            }
        ];
    } else if (style == 'zenmap') {
        var styles=
                [
                    {
                        "featureType": "administrative",
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "color": "#444444"
                            }
                        ]
                    },
                    {
                        "featureType": "landscape",
                        "elementType": "all",
                        "stylers": [
                            {
                                "color": "#f2f2f2"
                            }
                        ]
                    },
                    {
                        "featureType": "landscape.natural",
                        "elementType": "all",
                        "stylers": [
                            {
                                "hue": "#ff0000"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "all",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "all",
                        "stylers": [
                            {
                                "saturation": -100
                            },
                            {
                                "lightness": 45
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "all",
                        "stylers": [
                            {
                                "visibility": "simplified"
                            }
                        ]
                    },
                    {
                        "featureType": "road.arterial",
                        "elementType": "labels.icon",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "transit",
                        "elementType": "all",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "all",
                        "stylers": [
                            {
                                "color": "#2283c1"
                            },
                            {
                                "visibility": "on"
                            }
                        ]
                    }
                ]

                ;
    } else if (style == 'paper') {
        var styles = [
            {
                "featureType": "administrative",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    },
                    {
                        "hue": "#0066ff"
                    },
                    {
                        "saturation": 74
                    },
                    {
                        "lightness": 100
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    },
                    {
                        "weight": 0.6
                    },
                    {
                        "saturation": -85
                    },
                    {
                        "lightness": 61
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "simplified"
                    },
                    {
                        "color": "#5f94ff"
                    },
                    {
                        "lightness": 26
                    },
                    {
                        "gamma": 5.86
                    }
                ]
            }
        ];
    } else if (style == 'bentley') {
        var styles = [
            {
                "featureType": "landscape",
                "stylers": [
                    {
                        "hue": "#F1FF00"
                    },
                    {
                        "saturation": -27.4
                    },
                    {
                        "lightness": 9.4
                    },
                    {
                        "gamma": 1
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "stylers": [
                    {
                        "hue": "#0099FF"
                    },
                    {
                        "saturation": -20
                    },
                    {
                        "lightness": 36.4
                    },
                    {
                        "gamma": 1
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "stylers": [
                    {
                        "hue": "#00FF4F"
                    },
                    {
                        "saturation": 0
                    },
                    {
                        "lightness": 0
                    },
                    {
                        "gamma": 1
                    }
                ]
            },
            {
                "featureType": "road.local",
                "stylers": [
                    {
                        "hue": "#FFB300"
                    },
                    {
                        "saturation": -38
                    },
                    {
                        "lightness": 11.2
                    },
                    {
                        "gamma": 1
                    }
                ]
            },
            {
                "featureType": "water",
                "stylers": [
                    {
                        "hue": "#00B6FF"
                    },
                    {
                        "saturation": 4.2
                    },
                    {
                        "lightness": -63.4
                    },
                    {
                        "gamma": 1
                    }
                ]
            },
            {
                "featureType": "poi",
                "stylers": [
                    {
                        "hue": "#9FFF00"
                    },
                    {
                        "saturation": 0
                    },
                    {
                        "lightness": 0
                    },
                    {
                        "gamma": 1
                    }
                ]
            }
        ];
    }

    return styles;
}