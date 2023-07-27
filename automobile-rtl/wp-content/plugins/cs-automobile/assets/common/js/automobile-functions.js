/*
 *  jquery document.ready functions 
 */

var $ = jQuery;
var ajaxRequest;
jQuery(document).ready(function ($) {
// Custom Styling for Defualt Themes    
    if ($(".section-content").width() <= 768) {
        $(".section-content").addClass('full-width-custom')
    }
    if ($(".section-sidebar").width() <= 250) {
        $(".section-sidebar").addClass('full-width-custom')
    }
    if ($(".cs-related-inventories").width() <= 825) {
        $(".cs-detail-slider").addClass('cs-detail-slider-custom')
    }
    if ($(".cs-detail-nav").width() <= 713) {
        $(".cs-detail-nav").addClass('cs-detail-nav-custom')
    }

    /*
     *  media file upload 
     */




    $(document).ready(function () {
        var counter = 2;
        $("#automobile_button_add").click(function () {
            $("#add_more").append('<div class="adding-more-img">\n\
<input id="automobile_gallery_user_img" name="gallery_user_img[]" type="hidden" class="" value="">\n\
<label style="" class="browse-icon">\n\
<input name="automobile_gallery_user_img_media[]" type="file" value="Browse">\n\
</label><div class="page-wrap" style="display: none;" id="automobile_gallery_user_img_box">\n\
<div class="gal-active"><div class="dragareamain" style="padding-bottom:0px;">\n\
<ul id="gal-sortable"><li class="ui-state-default" id=""><div class="thumb-secs">\n\
<img src="" id="automobile_gallery_user_img_img" width="100" alt="">\n\
<div class="gal-edit-opts">\n\
<a href="javascript:del_media(\'automobile_gallery_user_img\')" class="delete"></a> </div></div></li></ul></div></div></div><p></p></div>');

            counter++;
            ;
        });

    });
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
     *  media file upload 
     */
    jQuery("body").on('click', '.cs-uploadMedia', function () {

        var $ = jQuery;
        var id = $(this).attr("name");
        //jQuery('input[name="'+id+'"]').hide();
        var custom_uploader = wp.media({
            title: 'Select File',
            button: {
                text: 'Add File'
            },
            multiple: false
        })
                .on('select', function () {
                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                    jQuery('#' + id).val(attachment.url);
                    jQuery('#' + id).next().hide();
                    jQuery('#' + id + '_img').attr('src', attachment.url);
                    jQuery('#' + id + '_box').show();
                }).open();
    });
    /*
     * 
     * payment gateway
     */
    "use strict";
    $('[id^=automobile_extra_feat_], [name=automobile_payment_part], [name=automobile_payment_gateway]').click(function () {
    });
    // Checkbox
    $(document).on('click', 'label.cs-chekbox', function () {
        var checkbox = $(this).find('input[type=checkbox]');

        if (checkbox.is(":checked")) {
            $('#' + checkbox.attr('name')).val(checkbox.val());
            $('#' + checkbox.attr('name')).attr('value', 'on');
        } else {
            $('#' + checkbox.attr('name')).val('');
            $('#' + checkbox.attr('name')).attr('value', '');
        }
    });
    /*
     * 
     * Media Upload
     */

    "use strict";
    var ww = jQuery('#post_id_reference').text();
    window.original_send_to_editor = window.send_to_editor;
    window.send_to_editor_clone = function (html) {
        imgurl = jQuery('a', '<p>' + html + '</p>').attr('href');
        jQuery('#' + formfield).val(imgurl);
        tb_remove();
    }
    jQuery('input.uploadfile').click(function () {
        window.send_to_editor = window.send_to_editor_clone;
        formfield = jQuery(this).attr('name');
        tb_show('', 'media-upload.php?post_id=' + ww + '&type=image&TB_iframe=true');
        return false;
    });
    /*
     * 
     * currency type
     */
    "use strict";
    jQuery("#automobile_currency_type").change(function (e) {
        automobile_get_currencies(this.value);
    });






    /*
     * 
     * dealer contact us
     */
    "use strict";
    $('#dealerid_contactus').click(function (event) {

        automobile_data_loader_load('.cs-profile-contact-detail #main-dealer-loader');
//        var default_message = jQuery("#automobile_dealer_contactus").data('validationmsg');
        event.preventDefault();
        var ajaxurl = jQuery(".cs-profile-contact-detail").data('adminurl');
        var dealerid = jQuery(".profile-contact-btn").data('dealerid');


        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            dataType: "html",
            data: $('#ajaxcontactdealer').serialize() + "&dealerid=" + dealerid + "&action=ajaxcontact_send_mail",
            success: function (response) {
                //alert(response);
                jQuery("#ajaxdealeremail").removeClass('has_error');
                jQuery("#ajaxdealername").removeClass('has_error');
                jQuery("#ajaxdealercontents").removeClass("has_error");
                jQuery("#ajaxdealerphone").removeClass("has_error");

                var pattern = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
                var response_data = response.split("|");
                if (jQuery("#ajaxdealername").val() == '') {
                    jQuery("#ajaxdealername").addClass('has_error');
                } else
                if (!pattern.test(jQuery("#ajaxdealeremail").val())) {
                    jQuery("#ajaxdealeremail").addClass('has_error');
                } else
                if (jQuery("#ajaxdealercontents").val().length < 35) {
                    jQuery("#ajaxdealercontents").addClass('has_error');
                } else
                if (jQuery("#ajaxdealerphone").val().length < 35) {
                    jQuery("#ajaxdealerphone").addClass('has_error');
                }
                var error_container = '';
                if (response_data[1] == 1) {
                    error_container = '<div class="alert alert-danger"><button aria-hidden="true" data-dismiss="alert" type="button" class="close">&times;</button><p><i class="icon-warning4"></i>' + response_data[0] + '</p></div>';
                    jQuery("#ajaxcontact-response").html(error_container);
                } else {
                    error_container = '<div class="alert alert-success"><button aria-hidden="true" data-dismiss="alert" type="button" class="close">&times;</button><p>' + response_data[0] + '</p></div>';
                    jQuery("#ajaxcontact-response").html(error_container);

                }

                jQuery('.cs-profile-contact-detail #main-dealer-loader').hide();

            }
        });
        return false;
    });




    /*
     * 
     * Skillbar
     */

    "use strict";
    if (jQuery('.skillbar').length != '') {
        jQuery('.skillbar').each(function () {
            $(this).waypoint(function (direction) {
                jQuery(this).find('.skillbar-bar').animate({
                    width: jQuery(this).attr('data-percent')
                }, 2000);
            }, {
                offset: "100%",
                triggerOnce: true
            });
        });
    }
    /*
     * 
     * Candidate contact us
     */
    "use strict";
    $('#location_redius_popup').click(function (event) {
        event.preventDefault();
        jQuery("#popup").removeClass('hide');
        return false;
    });

    /*
     * 
     * sticky element
     */

    jQuery(function () {
        "use strict";
        if (jQuery('#sidemenu').length != '') {
            $('#sidemenu').visualNav({
                scrollOnInit: false, // disable auto scroll when come first time
                useHash: false, // if true, the location hash will be updated
                initialized: function () {
                    var XposNav = $("#sidemenu").offset().top;
                    $(window).scroll(function () {

                        var scrollPos = $(window).scrollTop();
                        if (scrollPos >= XposNav) {
                            $("#sidemenu").addClass('fixed');
                        } else if (scrollPos < XposNav) {
                            $("#sidemenu").removeClass('fixed');
                        }
                    });
                }
            });
        }
    });

    /*
     * 
     * frontend user Login Form hide/show
     */

    jQuery('.login-link-page').on('click', function (e) {
        e.preventDefault();
        jQuery('.nav-tabs-page, .nav-tabs-page~.tab-content-page, .forgot-box').hide(function () {
            jQuery('.user-box').show();
            jQuery(".dealer-signup").hide();

        });
    });
    jQuery('.register-link').on('click', function (e) {
        e.preventDefault();
        jQuery('.login-box, .forgot-box').hide(function () {
            jQuery('.nav-tabs, .nav-tabs~.tab-content').show();
            jQuery(".dealer-signup").show();
            jQuery('.user-box').hide();
        });
    });
    jQuery('.user-forgot-password-page').on('click', function (e) {
        e.preventDefault();
        jQuery('.login-box, .forgot-box').hide(function () {
            jQuery('.nav-tabs, .nav-tabs~.tab-content').show();
            jQuery(".dealer-signup").hide();
            jQuery('.user-box').hide();
            jQuery('.forgot-box').show();
        });
    });








    /*
     * 
     * Popup function
     */

    "use strict";
    $('#location_redius_popup_close').click(function (event) {
        event.preventDefault();
        jQuery("#popup").addClass('hide');
        return false;
    });
    /**
     * @scrool sticky menu
     *
     */
    jQuery(function ($) {
        "use strict";
        $(document).ready(function () {
            if (jQuery('.navbar-wrapper').length != '') {
                $('.navbar-wrapper').stickUp({
                    parts: {
                        0: 'home',
                        1: 'features',
                        2: 'updates',
                        3: 'installation',
                        4: 'one-pager',
                        5: 'extras',
                        6: 'wordpress',
                        7: 'contact'
                    },
                    itemClass: 'menuItem',
                    itemHover: 'active',
                    topMargin: 'auto'
                });
            }
        });
    });


    jQuery('[data-toggle="popover"]').popover();
});

jQuery(function ($) {
    // Product gallery file uploads
    var gallery_frame;

    jQuery('.add_gallery').on('click', 'input', function (event) {
        var $el = $(this);

        get_id = $el.parent('.add_gallery').data('id');
        rand_id = $el.parent('.add_gallery').data('rand_id');
        automobile_var_theme_url = $("#automobile_var_theme_url").val();
        $gallery_images = $('#gallery_container_' + rand_id + ' ul.gallery_images');
        automobile_var_gallery_id = $('#gallery_container_' + rand_id).data("csid");
        event.preventDefault();

        // If the media frame already exists, reopen it.
        if (gallery_frame) {
            gallery_frame.open();
            return;
        }

        // Create the media frame.
        gallery_frame = wp.media({
            title: "Select Image",
            multiple: true,
            library: {type: 'image'},
            button: {text: 'Add Gallery Image'}
        });

        // When an image is selected, run a callback.
        gallery_frame.on('select', function () {

            var selection = gallery_frame.state().get('selection');

            selection.map(function (attachment) {

                attachment = attachment.toJSON();

                if (attachment.type == 'image') {
                    var gallery_url = attachment.url;
                }

                if (attachment.url) {
                    attachment_ids = Math.floor((Math.random() * 965674) + 1);
                    $('#gallery_container_' + rand_id + ' ul.gallery_images').append('\
                        <li class="image" data-attachment_id="' + attachment_ids + '">\
                            <img src="' + gallery_url + '" />\
                            <input type="hidden" value="' + gallery_url + '" name="' + automobile_var_gallery_id + '_url[]" />\
                            <div class="actions">\
                                <span><a href="javascript:;" class="delete" title="' + $el.data('delete') + '"><i class="icon-times"></i></a></span>\
                            </div>\
                        </li>');
                }

            });
            jQuery('#' + automobile_var_gallery_id + '_temp').html('');
        });

        // Finally, open the modal.
        gallery_frame.open();
    });

});

/**
 * @Sorting
 *
 */

function automobile_var_gallery_sorting_list(id, random_id) {
    var gallery = []; // more efficient than new Array()
    jQuery('#gallery_sortable_' + random_id + ' li').each(function () {
        var data_value = jQuery.trim(jQuery(this).data('attachment_id'));
        gallery.push(jQuery(this).data('attachment_id'));
    });

    jQuery("#" + id).val(gallery.toString());
}

function gal_num_of_items(id, rand_id, numb) {
    var automobile_var_gal_count = 0;
    jQuery("#gallery_sortable_" + rand_id + " > li").each(function (index) {
        automobile_var_gal_count++;
        jQuery('input[name="automobile_' + id + '_num"]').val(automobile_var_gal_count);
    });

    if (numb != '') {
        var automobile_var_data_temp = jQuery('#automobile_var_' + id + '_temp');
        if (jQuery('input[name="automobile_' + id + '_num"]').val() == numb) {
            automobile_var_data_temp.html('<input type="hidden" name="automobile_' + id + '_url[]" value="">');
        }
    }
}

function cv_removeinventorys(admin_url, post_id, obj) {

    document.getElementById('id_confrmdiv').style.display = "block"; //this is the replace of this line
    document.getElementById('id_truebtn').onclick = function () {
        var dataString = 'post_id=' + post_id + '&action=automobile_remove_applied_inventory_to_usermeta';
        jQuery('.holder-' + post_id).find('remove_resume_link' + post_id).html('<i class="icon-spinner8 icon-spin"></i>');
        jQuery.ajax({
            type: "POST",
            url: admin_url,
            data: dataString,
            dataType: "JSON",
            success: function (response) {
                if (response.status == 0) {
                    show_alert_msg(response.msg);
                } else {
                    jQuery('.holder-' + post_id).remove();
                    jQuery('.feature-inventorys').find('.holder-' + post_id).remove();
                }
            }
        });
        document.getElementById('id_confrmdiv').style.display = "none";
    };

    document.getElementById('id_falsebtn').onclick = function () {
        document.getElementById('id_confrmdiv').style.display = "none";
        return false;
    };
}


setTimeout(function () {
    jQuery('.cs-booking-create .messagebox').slideUp(800);
}, 3000);

function automobile_get_location(elem) {
    "use strict";

    if (navigator.geolocation) {

        navigator.geolocation.getCurrentPosition(function (position) {

            var elem_obj = jQuery(elem);

            showPosition(position, elem_obj)
        });

    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

function showPosition(position, elem) {
    "use strict";
    var parent_form = jQuery(elem.parents('form'));
    //parent_form.find('.geo-search-location').attr('sadsadsa','342');
    jQuery.ajax({
        url: 'https://maps.googleapis.com/maps/api/geocode/json?key='+automobile_globals.google_api_key+'&latlng=' + position.coords.latitude + ',' + position.coords.longitude + '&sensor=true',
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            parent_form.find('.automobile_search_location_field').attr('name', 'location');
            parent_form.find('.automobile_search_location_field').attr('value', data.results[0].formatted_address);
            parent_form.find('.automobile_search_location_field').show();
            parent_form.find('.cs-undo-select').show();
            parent_form.find('.cs-select-holder').hide();
            parent_form.find('.search_keyword').removeAttr('name');
            automobile_set_geo_loc(data.results[0].formatted_address);
            var radius_value = jQuery('input[name="radius"]').val();
            var input = $("<input>")
                       .attr("type", "hidden")
                       .attr("name", 'location')
                       .val(data.results[0].formatted_address);
            jQuery('.searchform').append($(input));
            var radius_input = $("<input>")
                       .attr("type", "hidden")
                       .attr("name", 'radius')
                       .val(radius_value);
            jQuery('.searchform').append($(radius_input));
        }
    });
}

function automobile_set_geo_loc(geo_loc) {
    "use strict";
    var admin_url = jQuery('#top-view-srch-form').data('ajaxurl');
    var dataString = 'geo_loc=' + geo_loc + '&action=automobile_set_geo_loc';
    jQuery.ajax({
        url: admin_url,
        type: 'POST',
        data: dataString,
        success: function (data) {

        }
    });
}

function automobile_unset_geo_loc() {
    "use strict";
    var admin_url = jQuery('#top-view-srch-form').data('ajaxurl');
    var dataString = 'geo_loc=&action=automobile_unset_geo_loc';
    jQuery.ajax({
        url: admin_url,
        type: 'POST',
        data: dataString,
        success: function (data) {

        }
    });
}

jQuery(document).on('click', '.cs-undo-select', function () {
    "use strict";
    jQuery(this).hide();
    var parent_form = jQuery(jQuery(this).parents('form'));
    parent_form.find('.geo-search-location').hide();
    parent_form.find('.geo-search-location').removeAttr('name');
    parent_form.find('.cs-select-holder').show();
    parent_form.find('.search_keyword').attr('name', 'location');

    automobile_unset_geo_loc();
});


/**
 * Settings Tabs Responsive Function
 */

var windowWidth = jQuery(window).width();
if (windowWidth < 768) {
    jQuery('.col1').find('.admin-navigtion').addClass('navigation-small');
} else {
    jQuery('.col1').find('.admin-navigtion').removeClass('navigation-small');
}
jQuery('.nav-button').on('click', function (e) {
    "use strict";
    e.preventDefault();
    var windowWidth = jQuery(window).width();
    if (windowWidth < 768) {
        jQuery('.nav-button').closest('.admin-navigtion').addClass('navigation-small');
    }
});
jQuery(window).resize(function () {
    "use strict";
    var windowWidth = jQuery(window).width();
    if (windowWidth < 768) {
        jQuery('.col1').find('.admin-navigtion').addClass('navigation-small');
        jQuery('.nav-button').on('click', function (e) {
            e.preventDefault();
            jQuery(this).parents('.admin-navigtion').addClass('navigation-small');
        });
    } else {
        jQuery('.col1').find('.admin-navigtion').removeClass('navigation-small');
    }
});
/**
 * Update Title
 */
function update_title(id) {
    "use strict";
    var val;
    val = jQuery('#address_name' + id).val();
    jQuery('#address_name' + id).html(val);
}

/**
 * Create Popup
 */
function automobile_createpop(data, type) {
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
}
function automobile_fe_search_map() {

    var vals;
    vals = jQuery('#loc_address').val();
    vals = vals + ", " + jQuery('#loc_city').val();
    vals = vals + ", " + jQuery('#loc_region').val();
    vals = vals + ", " + jQuery('#loc_country').val();
    jQuery('.gllpSearchField').val(vals);

}
/**
 * Remove Popup
 */
function automobile_remove_overlay(id, text) {
    "use strict";
    jQuery("#cs-widgets-list .loader").remove();
    var _elem1 = "<div id='cs-pbwp-outerlay'></div>",
            _elem2 = "<div id='cs-widgets-list'></div>";
    var $elem = jQuery("#" + id);
    jQuery("#cs-widgets-list").unwrap(_elem1);
    if (text == "append" || text == "filterdrag") {
        $elem.hide().unwrap(_elem2);
    }
    if (text == "widgetitem") {
        $elem.hide().unwrap(_elem2);
        jQuery("body").append("<div id='cs-pbwp-outerlay'><div id='cs-widgets-list'></div></div>");
        return false;
    }
    if (text == "ajax-drag") {
        jQuery("#cs-widgets-list").remove();
    }
    jQuery("body").removeClass("cs-overflow");
}


/**
 * Number Format
 */
function automobile_number_format(num) {
    "use strict";
    return parseFloat(Math.round(num * 100) / 100).toFixed(2);
}

/**
 * Plugin Option Saving
 *
 */
function plugin_option_save(admin_url) {
    "use strict";
    jQuery(".outerwrapp-layer,.loading_div").fadeIn(100);
    function newValues() {
        var serializedValues = jQuery("#plugin-options input,#plugin-options select,#plugin-options textarea").serialize() + '&action=plugin_option_save';
        return serializedValues;
    }
    var serializedReturn = newValues();
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: serializedReturn,
        success: function (response) {

            jQuery(".loading_div").hide();
            jQuery(".form-msg .innermsg").html(response);
            jQuery(".form-msg").show();
            jQuery(".outerwrapp-layer").fadeTo(2000, 1000).slideUp(1000);
            slideout();
        }
    });
}
/**
 * Plugin Reset Option
 *
 */
function automobile_rest_plugin_options(admin_url) {
    "use strict";

    var var_confirm = confirm("You current Plugin options will be replaced with the default options.");
    if (var_confirm == true) {
        var dataString = 'action=plugin_option_rest_all';
        jQuery.ajax({
            type: "POST",
            url: admin_url,
            data: dataString,
            success: function (response) {

                jQuery(".form-msg").show();
                jQuery(".form-msg").html(response);
                jQuery(".loading_div").hide();
                window.location.reload(true);
                slideout();
            }
        });
    }
}

function automobile_set_p_filename(file_value, file_path) {
    "use strict";
    jQuery(".backup_action_btns").find('input[type="button"]').attr('data-file', file_value);
    jQuery(".backup_action_btns").find('> a').attr('href', file_path + file_value);
    jQuery(".backup_action_btns").find('> a').attr('download', file_value);
}

function automobile_pl_backup_generate(admin_url) {
    "use strict";
    jQuery(".outerwrapp-layer,.loading_div").fadeIn(100);

    var dataString = 'action=automobile_pl_opt_backup_generate';
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {

            jQuery(".loading_div").hide();
            jQuery(".form-msg .innermsg").html(response);
            jQuery(".form-msg").show();
            jQuery(".outerwrapp-layer").delay(100).fadeOut(100);
            window.location.reload(true);
            slideout();
        }
    });
    //return false;
}

jQuery('.backup_generates_area').on('click', '#cs-p-backup-delte', function () {
    "use strict";
    var var_confirm = confirm("This action will delete your selected Backup File. Are you want to continue?");
    if (var_confirm == true) {
        jQuery(".outerwrapp-layer,.loading_div").fadeIn(100);

        var admin_url = jQuery('.backup_generates_area').data('ajaxurl');
        var file_name = jQuery(this).data('file');

        var dataString = 'file_name=' + file_name + '&action=automobile_pl_backup_file_delete';
        jQuery.ajax({
            type: "POST",
            url: admin_url,
            data: dataString,
            success: function (response) {

                jQuery(".loading_div").hide();
                jQuery(".form-msg .innermsg").html(response);
                jQuery(".form-msg").show();
                jQuery(".outerwrapp-layer").delay(2000).fadeOut(100);
                window.location.reload(true);
                slideout();
            }
        });
        //return false;
    }
});

jQuery(document).on('click', '#cs-p-backup-restore, #cs-p-backup-url-restore', function () {

    "use strict";
    jQuery(".outerwrapp-layer,.loading_div").fadeIn(100);

    var admin_url = jQuery('.backup_generates_area').data('ajaxurl');
    var file_name = jQuery(this).data('file');

    var dataString = 'file_name=' + file_name + '&action=automobile_pl_backup_file_restore';

    if (typeof (file_name) === 'undefined') {

        var file_name = jQuery('#bkup_import_url').val();

        var dataString = 'file_name=' + file_name + '&file_path=yes&action=automobile_pl_backup_file_restore';
    }

    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {

            jQuery(".loading_div").hide();
            jQuery(".form-msg .innermsg").html(response);
            jQuery(".form-msg").show();
            jQuery(".outerwrapp-layer").delay(2000).fadeOut(100);
            window.location.reload(true);
            slideout();
        }
    });

});
/**
 * Plugin Reset Option
 *
 */
function automobile_rest_plugin_options(admin_url, plugin_url) {
    "use strict";
    //jQuery(".loading_div").show('');
    var var_confirm = confirm("You current plugin options will be replaced with the default plugin activation options.");
    if (var_confirm == true) {
        var dataString = 'action=plugin_option_rest_all';
        jQuery.ajax({
            type: "POST",
            url: admin_url + "/admin-ajax.php",
            data: dataString,
            success: function (response) {
                jQuery(".form-msg").show();
                jQuery(".form-msg").html(response);
                jQuery(".loading_div").hide();
                window.location.reload(true);
                slideout();
            }
        });
    }
    //return false;
}
/**
 * Plugin Reset Option
 *
 */

function automobile_get_currencies(code) {
    "use strict";
    if (code != '') {
        var dataString = 'code=' + code +
                '&action=automobile_get_currency_symbol';
        var plugin_url = jQuery("#automobile_plugin_url").val();
        jQuery("#currency_sign").parent('.to-field').append("<span><i class='icon-spinner8 icon-spin'></i></span>");
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: dataString,
            success: function (response) {
                jQuery("#currency_sign").val(response);
                jQuery("#currency_sign").parent('.to-field').find('span').remove();
            }
        });
    }

    return false;
}
/**
 * Accomodation Toggle Function
 *
 */
jQuery(".plain-info").find('.cslist-info').hide();
jQuery('.info-toggle').on('click', function (e) {
    e.preventDefault();
    var datalink = jQuery(this).attr('id');
    var active = jQuery(this).hasClass('active');
    if (active) {
        jQuery(this).removeClass('active');
        jQuery(this).parents(".plain-info").find('.cslist-info').toggle("slow");
        jQuery(this).find('i').removeClass().addClass('icon-plus8');
    } else {
        jQuery(this).addClass('active');
        jQuery(this).parents(".plain-info").find('.cslist-info').toggle("slow");
        jQuery(this).find('i').removeClass().addClass('icon-minus8');
    }
});

/**
 * Check Availabilty
 */
function automobile_check_fields_avail() {
    "use strict";
    jQuery('input[id^="check_field_name"]').change(function (e) {
        var doneTypingInterval = 1000; //time in ms, 5 second for example
        var name = jQuery(this).val();
        var serializedValues = jQuery("form").serialize();
        var $this = jQuery(this);
        var dataString = 'name=' + name +
                '&form_field_names=' + serializedValues +
                '&action=automobile_check_fields_avail'

        setTimeout(function () {

            $this.next('span').html('<i class="icon-spinner8 icon-spin"></i>');
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: dataString,
                dataType: 'json',
                success: function (response) {
                    if (response.type == 'success') {
                        $this.parents('.pbwp-form-rows').children('.name-checking').html(response.message);
                        jQuery('input[type="button"]').removeAttr('disabled');
                    } else if (response.type == 'error') {
                        $this.parents('.pbwp-form-rows').children('.name-checking').html(response.message);
                        jQuery('input[type="button"]').attr('disabled', 'disabled');
                    }
                }
            });
        }, doneTypingInterval)

    });
}

/*
 load more
 */
var i = 1;

function  automobile_load_more_ajax(admin_url) {

    i++;

    var dataString = 'action=automobile_ajax_manage_inventory_ajax&post_to_load=' + i;
    var e = document.getElementById("automobile_inventory_status");
    var value_selected_index = e.options[e.selectedIndex].value;
    if (value_selected_index != '' && value_selected_index != 'all') {
        var dataString = 'action=automobile_ajax_manage_inventory_ajax&post_to_load=' + i + '&status_val=' + value_selected_index;
    }

    //automobile_data_loader_load('#dealer-dashboard .main-cs-loader');
    jQuery('.loadmore-btn').html('<i class="icon-spinner8 icon-spin"></i>');
    jQuery.ajax({
        type: "POST",
        url: admin_url + "admin-ajax.php",
        data: dataString,
        success: function (response) {
            //alert(response);
            if (response != 'error') {
                jQuery('.ajax-load-more-div').append(response);
                jQuery('.loadmore-btn').html('Load More');

            } else {
                alert('error');
                jQuery('.loadmore-btn').html('Load More');
            }
        }
    });
}
function  automobile_load_more_ajax_with_status(admin_url, status_val) {


    var status_value = status_val.value;
    var dataString = 'action=automobile_ajax_manage_inventory&post_to_load=' + i + '&status_val=' + status_value;
    automobile_data_loader_load('#dealer-dashboard .main-cs-loader');
    jQuery.ajax({
        type: "POST",
        url: admin_url + "admin-ajax.php",
        data: dataString,
        success: function (response) {
            //alert(response);
            if (response != 'error') {
                jQuery('.cs-manage-inventory').empty();
                jQuery('.cs-manage-inventory').append(response);
                jQuery('#dealer-dashboard .main-cs-loader').empty();

            } else {
                alert('error');
                jQuery('#dealer-dashboard .main-cs-loader').empty();
            }
        }
    });
}




/**
 * Check dealer custom fields Availabilty
 */
function automobile_check_dealer_fields_avail() {
    //alert("test");
    "use strict";
    jQuery('input[id^="check_field_name"]').change(function (e) {
        var doneTypingInterval = 1000; //time in ms, 5 second for example
        var name = jQuery(this).val();
        var serializedValues = jQuery("form").serialize();
        var $this = jQuery(this);
        var dataString = 'name=' + name +
                '&form_field_names=' + serializedValues +
                '&action=automobile_check_dealer_fields_avail'

        setTimeout(function () {

            $this.next('span').html('<i class="icon-spinner8 icon-spin"></i>');
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: dataString,
                dataType: 'json',
                success: function (response) {
                    if (response.type == 'success') {
                        $this.parents('.pbwp-form-rows').children('.name-checking').html(response.message);
                        jQuery('input[type="button"]').removeAttr('disabled');
                    } else if (response.type == 'error') {
                        $this.parents('.pbwp-form-rows').children('.name-checking').html(response.message);
                        jQuery('input[type="button"]').attr('disabled', 'disabled');
                    }
                }
            });
        }, doneTypingInterval)

    });
}
/**
 * Add reviews
 */
function automobile_reviews_submission(admin_url) {
    'use strict';
    var email = jQuery("#reviewer_email").val();
    var subject = jQuery("#reviews_title").val();
    var name = jQuery("#reviewer_name").val();
    var description = jQuery("#reviews_description").val();
    if (email == '' || subject == '' || name == '' || description == '') {
        alert('Please fill all fields.');
        return false;
    }

    if (!validateEmail(email)) {
        alert('Please enter a valid email address.');
        return false;
    }
    jQuery(".review-message-type").html('');
    jQuery("#loading").html('<i class="icon-spinner8 icon-spin"></i>');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        dataType: "json",
        data: jQuery('#cs-reviews-form').serialize() + '&action=automobile_add_reviews',
        success: function (response) {
            jQuery("#loading").html('');
            jQuery(".review-message-type").html(response.message);
            jQuery(".review-message-type").show();
        }
    });
    return false;
}
/**
 * validate email
 */
function validateEmail($email) {
    "use strict";
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test($email);
}
/**
 * Render Custom Fields
 */

function automobile_custom_fields_script(id) {
    "use strict";
    var parentItem = jQuery("#" + id);
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
        b.clone().insertAfter(b);
        var a = _this.parents('.pbwp-form-sub-fields').find('input:radio');
        a.each(function (index, el) {
            jQuery(this).val(index + 1);
        });
    });
    parentItem.on("click", "img.pbwp-remove-field", function (e) {
        e.preventDefault();
        var _this = jQuery(this),
                b = _this.closest('.pbwp-form-sub-fields');
        c = b.find('div.pbwp-clone-field').length;
        if (c > 1) {
            _this.closest("div.pbwp-clone-field").remove()
        }
        _this.parents('div.pbwp-clone-field').remove();
    });
    parentItem.on("click", ".pbwp-remove", function (e) {
        e.preventDefault();
        var a = confirm("This will delete Item");
        if (a) {
            jQuery(this).parents(".pb-item-container").remove()
            alertbox();
        }
    })

    parentItem.on("click", "a.pbwp-toggle", function (e) {
        e.preventDefault();
        jQuery(this).parents(".pbwp-legend").next().slideToggle(300);
    });
}

jQuery('#automobile_city_select_country').on('change', function () {

    "use strict";
    var plugin_url = jQuery(this).parents("#locations_wrap").data('plugin_url');
    var dataString = 'country=' + this.value + '&action=automobile_load_states';
    jQuery(".loader-states").html("<img src='" + plugin_url + "/assets/backend/images/ajax-loader.gif' />");
    jQuery(".loader-states").show();
    jQuery.ajax({
        type: "POST",
        url: ajaxurl,
        data: dataString,
        success: function (response) {
            jQuery("#automobile_select_states").html(response);
            jQuery(".loader-states").html('').hide();

        }
    });
});
jQuery('[name=automobile_update_select_country]').change(function () {
    "use strict";
    var id = jQuery(this).data('id');
    var plugin_url = jQuery(this).parents("#locations_wrap").data('plugin_url');
    var dataString = 'country=' + this.value + '&action=automobile_load_states';
    jQuery(".update-loader-states-" + id).html("<img src='" + plugin_url + "/assets/backend/images/ajax-loader.gif' />");
    jQuery(".update-loader-states-" + id).show();
    jQuery.ajax({
        type: "POST",
        url: ajaxurl,
        data: dataString,
        success: function (response) {
            jQuery("#automobile_update_select_states_" + id).html(response);
            jQuery(".update-loader-states-" + id).html('').hide();
        }
    });
});

/**
 * add package to list
 */
var counter_package = 0;
function add_package_to_list(admin_url, plugin_url) {
    "use strict";
    counter_package++;
    var dataString = 'counter_package=' + counter_package +
            '&package_title=' + jQuery("#package_title").val() +
            '&package_type=' + jQuery("#package_type").val() +
            '&package_price=' + jQuery("#package_price").val() +
            '&package_duration=' + jQuery("#package_duration").val() +
            '&package_duration_period=' + jQuery("#package_duration_period").val() +
            '&package_no_ads=' + jQuery("#package_no_ads").val() +
            '&package_description=' + jQuery("#package_description").val() +
            '&automobile_package_type=' + jQuery("#automobile_package_type").val() +
            '&package_listings=' + jQuery("#package_listings").val() +
            '&package_cvs=' + jQuery("#package_cvs").val() +
            '&package_submission_limit=' + jQuery("#package_submission_limit").val() +
            '&automobile_list_dur=' + jQuery("#automobile_list_dur").val() +
            '&package_featured_ads=' + jQuery("#package_featured_ads").val() +
            '&package_feature=' + jQuery("#package_feature").val() +
            '&action=automobile_add_package_to_list';
    jQuery(".package-loader").html("<img src='" + plugin_url + "/assets/backend/images/ajax-loader.gif' />");
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {
            jQuery("#total_packages").append(response);
            jQuery(".package-loader").html("");
            automobile_remove_overlay('add_package_title', 'append');
            jQuery("#package_title").val("Title");
        }
    });
    return false;
}
/**
 * package type toogle
 */
function automobile_package_type_toogle(value, id) {
    "use strict";
    var $ = jQuery;
    if (value == "single") {
        jQuery("#package_listings_con" + id).hide();
    } else {
        jQuery("#package_listings_con" + id).show();
    }
}


/**
 * search map
 */
function automobile_gl_search_map() {

    "use strict";
    var vals;
    vals = jQuery('#loc_address').val();
    jQuery('.gllpSearchField').val(vals);
}
/**
 * sugg change
 */
function automobile_inventory_loc_sugg_change(value) {
    "use strict";
    var $ = jQuery;
    if (value == 'website') {
        $("#automobile_search_by_location_select").show();
    } else {
        $("#automobile_search_by_location_select").hide();
    }
}

/**
 * Value toggle
 */
function automobile_search_by_location_change(value) {

    "use strict";
    var $ = jQuery;
    if (value == 'single_city') {
        $("#automobile_search_by_location_city_select").show();
    } else {
        $("#automobile_search_by_location_city_select").hide();
    }
}

/**
 * Add to Wishlist Function
 */
function automobile_addto_wishlist(admin_url, post_id) {
    "use strict";

    var dataString = 'post_id=' + post_id + '&action=automobile_addto_usermeta';
    jQuery(".cs-add-wishlist").html('<i class="icon-spinner8 icon-spin"></i>');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {
            jQuery(".cs-add-wishlist").html(response);
            jQuery("a.cs-add-wishlist").attr("onclick", "automobile_delete_from_favourite('" + admin_url + "','" + post_id + "','post')");
            jQuery("a.cs-add-wishlist").attr("data-original-title", "Shortlist");
            //jQuery(".outerwrapp-layer").fadeTo(2000, 500).slideUp(500);
            automobile_inventory_shortlist_load(admin_url);
        }
    });
    return false;
}
/**
 * Do Confirme
 */
function doConfirmed(msg, yesFn, noFn) {
    "use strict";
    var confirmBox = jQuery("#confirmBox");
    confirmBox.find(".message").text(msg);
    confirmBox.find(".yes,.no").unbind().click(function () {
        confirmBox.hide();
    });
    confirmBox.find(".yes").click(yesFn);
    confirmBox.find(".no").click(noFn);
    confirmBox.show();

}

/**
 * Remove Shortlist Function
 */
function automobile_delete_wishlist(admin_url, _this) {
    "use strict";
    document.getElementById('id_confrmdiv').style.display = "block"; //this is the replace of this line
    document.getElementById('id_truebtn').onclick = function () {
        var post_id = jQuery(_this).data("postid");
        var dataString = 'post_id=' + post_id + '&action=automobile_delete_wishlist';
        jQuery(".close-" + post_id).html('<i class="icon-spinner8 icon-spin"></i>');
        jQuery.ajax({
            type: "POST",
            url: admin_url,
            data: dataString,
            success: function (response) {
                jQuery(".close-" + post_id).parents('.holder-' + post_id).remove();
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





/**
 * Remove Wishlist Function
 */
function automobile_delete_from_favourite(admin_url, post_id) {
    "use strict";
    var dataString = 'post_id=' + post_id + '&action=automobile_delete_from_favourite';
    automobile_data_loader_load(".cs-add-wishlist");
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {
            jQuery(".cs-add-wishlist").html(response);
            jQuery("a.cs-add-wishlist").attr("onclick", "automobile_addto_wishlist('" + admin_url + "','" + post_id + "','post')");
            jQuery("a.cs-add-wishlist").attr("data-original-title", "Shortlisted");
            automobile_inventory_shortlist_load(admin_url);
        }
    });
    return false;


}


function ajax_form_save(admin_url, theme_url, form_id, id) {

    "use strict";
    id = id || 0;
    var classes = '';

    automobile_data_loader_load('#candidate-dashboard .main-cs-loader');
    function newValues() {
        var serializedValues = jQuery("#" + form_id).serialize();
        return serializedValues;
    }
    var serializedReturn = newValues();
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: serializedReturn,
        success: function (response) {
            setTimeout(function () {
                trigger_func('#candidate_resume_click_link_id');
            }, 200);
        }
    });
    //return false;
}
function ajax_profile_form_save(admin_url, theme_url, form_id) {
    "use strict";
    automobile_data_loader_load('#candidate-dashboard .main-cs-loader');
    var validation_message = jQuery("#candidate-dashboard").data('validationmsg');
    var error = 0;
    var classes = '';
    jQuery('#candidate input, #candidate radio, #candidate checkbox, #candidate file').each(
            function () {
                var input = jQuery(this);
                if (input.attr('required') == 'required') {
                    if (input.val() == '') {
                        classes = input.attr("class");
                        input.addClass(classes + " has-error");
                        error = 1;
                    } else {
                        input.removeClass("has-error");
                    }
                }
            }
    );
    jQuery('#candidate select').each(
            function () {
                var input = jQuery(this);
                if (input.attr('required') == 'required') {
                    if (input.val() == '') {
                        classes = input.parent().attr("class");
                        input.parent().addClass(classes + " has-error");
                        error = 1;
                    } else {
                        input.parent().removeClass("has-error");
                    }
                }
            }
    );

    if (error == 0) {
        var fd = new FormData();
        var file_data = fd.append('media_upload', jQuery('input[type=file]')[0].files[0]);
        var serializedValues = jQuery("#" + form_id).serializeArray();
        jQuery.each(serializedValues, function (key, input) {
            fd.append(input.name, input.value);
        });
        jQuery.ajax({
            url: admin_url,
            data: fd,
            contentType: false,
            processData: false,
            dataType: "html",
            type: "POST",
            success: function (response) {
                jQuery('#candidate-dashboard .main-cs-loader').html('');
                jQuery('#automobile_alerts').html('<div class="cs-remove-msg"><i class="icon-check-circle"></i>' + response + '</div>');
                classes = jQuery('#automobile_alerts').attr('class');
                classes = classes + " active";
                jQuery('#automobile_alerts').addClass(classes);

                setTimeout(function () {
                    jQuery('#automobile_alerts').removeClass("active");
                }, 4000);
            }
        });
    } else {
        jQuery('#candidate-dashboard .main-cs-loader').html('');
        jQuery('#automobile_alerts').html('<div class="cs-remove-msg"><i class="icon-check-circle"></i>' + validation_message + '</div>');
        classes = jQuery('#automobile_alerts').attr('class');
        classes = classes + " active";
        jQuery('#automobile_alerts').addClass(classes);

        setTimeout(function () {
            jQuery('#automobile_alerts').removeClass("active");
        }, 4000);
    }
    //return false;
}



function ajax_dealer_profile_form_save(admin_url, theme_url, form_id) {
    "use strict";

    automobile_data_loader_load('#dealer-dashboard .main-cs-loader');
    var validation_message = jQuery("#dealer-dashboard").data('validationmsg');
    var error = 0;
    var classes = '';
    jQuery('#automobile_dealer_form input, #automobile_dealer_form radio, #automobile_dealer_form checkbox, #automobile_dealer_form file').each(
            function () {
                var input = jQuery(this);
                if (input.attr('required') == 'required') {
                    if (input.val() == '') {
                        classes = input.attr("class");
                        input.addClass(classes + " has-error");
                        error = 1;
                    } else {
                        input.removeClass("has-error");
                    }
                }
            }
    );
    jQuery('#automobile_dealer_form select').each(
            function () {
                var input = jQuery(this);
                if (input.attr('required') == 'required') {
                    if (input.val() == '') {
                        classes = input.parent().attr("class");
                        input.parent().addClass(classes + " has-error");
                        error = 1;
                    } else {
                        input.parent().removeClass("has-error");
                    }
                }
            }
    );
    if (error == 0) {
        var fd = new FormData();
        var file_data = fd.append('media_upload', jQuery('input[type=file]')[0].files[0]);
        //Dealer Dashboard Gallery 
        jQuery('input[type=file]').each(function (index) {
            if (index != 0) {
                fd.append('gallery_user_img[]', jQuery('input[type=file]')[index].files[0]);
            }
        });

        var serializedValues = jQuery("#" + form_id).serializeArray();
        jQuery.each(serializedValues, function (key, input) {
            fd.append(input.name, input.value);
        });

        jQuery.ajax({
            url: admin_url,
            data: fd,
            contentType: false,
            processData: false,
            dataType: "html",
            type: "POST",
            success: function (response) {

                jQuery('#dealer-dashboard .main-cs-loader').html('');
                show_alert_msg(response);
            }
        });
    } else {
        jQuery('#dealer-dashboard .main-cs-loader').html('');
        show_alert_msg(validation_message);
    }
    //return false;
}

function ajax_candidate_cv_form_save(admin_url, theme_url, form_id, uid) {
    "use strict";
    var error = 0;
    var save_msg = '';
    var classes = '';
    automobile_data_loader_load('#candidate-dashboard .main-cs-loader');
    var fd = new FormData();
    var file_data = fd.append('media_upload', jQuery('input[type=file]')[1].files[0]);
    var serializedValues = jQuery("#" + form_id).serializeArray();
    jQuery.each(serializedValues, function (key, input) {
        fd.append(input.name, input.value);
    });
    console.log(fd);
    jQuery.ajax({
        url: admin_url,
        data: fd,
        contentType: false,
        processData: false,
        dataType: "html",
        type: "POST",
        success: function (response) {
            save_msg = response;
            // get again data
            var dataString = 'automobile_uid=' + uid + '&action=automobile_ajax_candidate_cvcover';
            jQuery.ajax({
                type: "POST",
                url: admin_url,
                data: dataString,
                success: function (response) {
                    jQuery('#cv').html(response);
                    jQuery('#candidate-dashboard .main-cs-loader').html('');
                    show_alert_msg(save_msg);
                }
            });
        }
    });
    //return false;
}

function checkName(el, to, sbm) {
    "use strict";
    var ar_ext = ['pdf', 'doc', 'rtf', 'docx'];
// - coursesweb.net
    // get the file name and split it to separe the extension
    var name = el.value;
    var ar_name = name.split('.');
    // for IE - separe dir paths (\) from name
    var ar_nm = ar_name[0].split('\\');
    for (var i = 0; i < ar_nm.length; i++)
        var nm = ar_nm[i];
    // check the file extension
    var re = 0;
    for (var i = 0; i < ar_ext.length; i++) {
        if (ar_ext[i] == ar_name[1]) {
            re = 1;
            break;
        }
    }

    if (re != 1) {
        jQuery('.cs-status-msg-cv-upload').addClass("error-msg");
        el.value = '';
    } else {
        jQuery('.cs-status-msg-cv-upload').removeClass("error-msg");
        // add the name in 'to'
        var html_txt = "<div id='selecteduser-cv'><div class='alert alert-dismissible user-resume' id='automobile_candidate_cv_box'><div>" + nm + "<div class='gal-edit-opts close'><a href='javascript:automobile_del_media(\"automobile_candidate_cv\")' class='delete'><span aria-hidden='true'>×</span></a></div></div></div></div>";
        jQuery("#selecteduser-cv").html(html_txt);

    }

}

function ajax_form_remove(admin_url, theme_url, form_id, id) {
    "use strict";
    /**
     * Delete Confirm Html popup
     */
    // alert(admin_url+ ", "+ theme_url+ ", "+ form_id+ ", "+ id);
    var html_popup = "<div id='confirmOverlay' style='display:block'> \
				  <div id='confirmBox'><div id='confirmText'>Are you sure to do this?</div> \
				  <div id='confirmButtons'><div class='button confirm-yes'>Delete</div>\
				  <div class='button confirm-no'>Cancel</div><br class='clear'></div></div></div>"
    jQuery(".delete-" + id).on("click", function () {

        jQuery(".delete-" + id).parents(".parentdelete").remove();
        ajax_form_save(admin_url, theme_url, form_id);
        // return false;
    });
    return false;
}

/****
 *  remove candidate resume options
 * @param {type} admin_url
 * @param {type} post_id
 * @param {type} obj
 * @returns {Boolean}
 * 
 * 
 */
function doConfirm(msg, yesFn, noFn) {
    "use strict";
    var confirmBox = jQuery("#confirmBox");
    confirmBox.find(".message").text(msg);
    confirmBox.find(".yes,.no").unbind().click(function () {
        confirmBox.hide();
    });
    confirmBox.find(".yes").click(yesFn);
    confirmBox.find(".no").click(noFn);
    confirmBox.show();
}

function automobile_remove_resume_options_fromlist(admin_url, list_type, list_id) {
    "use strict";
    document.getElementById('id_confrmdiv').style.display = "block"; //this is the replace of this line
    document.getElementById('id_truebtn').onclick = function () {
        //doConfirm("Are you sure to remove?", function yes() {
        var dataString = 'list_type=' + list_type + '&list_id=' + list_id + '&action=automobile_remove_resume_options_fromlist';
        //alert('.delete-' + list_id);
        automobile_data_loader_load('.delete-' + list_id);
        //salert(jQuery('.delete-' + list_id).html());
        jQuery.ajax({
            type: "POST",
            url: admin_url,
            data: dataString,
            success: function (response) {
                //alert(response);
                if (response != 'error') {
                    jQuery(".parentdeleterow-" + list_id).fadeTo(1000, 500).slideUp(500);
                    jQuery(".parentdeleterow-" + list_id).remove();
                    document.getElementById('id_confrmdiv').style.display = "none";
                } else {
                    jQuery('.delete-' + list_id).html('<i class="icon-trash"></i>');
                }
            }
        });
        return false;
    };
    document.getElementById('id_falsebtn').onclick = function () {
        document.getElementById('id_confrmdiv').style.display = "none";
        return false;
    };
}

/**
 * Add inventorys to Wishlist Function
 */
function automobile_addinventorys_to_wishlist(admin_url, post_id, obj) {
    "use strict";
    var dataString = 'post_id=' + post_id + '&action=automobile_addinventory_to_usermeta';
    jQuery(obj).parents('li').find('.whishlist_icon').html('<i class="icon-spinner8 icon-spin"></i>');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {
            jQuery(obj).parents('li').find('.whishlist_icon').html(response);
            jQuery(obj).parents('li').find('.whishlist_icon').attr("onclick", "automobile_removeinventorys_to_wishlist('" + admin_url + "','" + post_id + "',this)");
            jQuery(obj).parents('li').find('.whishlist_icon').attr("data-original-title", "Shortlist");
            automobile_inventory_shortlist_load(admin_url);
        }
    });
    return false;
}
function automobile_addinventorys_to_wish(admin_url, post_id, obj) {
    "use strict";
    var dataString = 'post_id=' + post_id + '&action=automobile_addinventory_to_user';
    jQuery(obj).parents('li').find('.whishlist_icon').html('<i class="icon-spinner8 icon-spin"></i>');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {
            jQuery(obj).parents('li').find('.whishlist_icon').html(response);
            jQuery(obj).parents('li').find('.whishlist_icon').attr("onclick", "automobile_removeinventorys_to('" + admin_url + "','" + post_id + "',this)");
            jQuery(obj).parents('li').find('.whishlist_icon').attr("data-original-title", "Shortlist");
            automobile_inventory_shortlist_load(admin_url);
        }
    });
    return false;
}

/**
 * Remove Wishlist Function
 */
function automobile_removeinventorys_to_wishlist(admin_url, post_id, obj) {
    "use strict";
    var dataString = 'post_id=' + post_id + '&action=automobile_removeinventory_to_usermeta';
    jQuery(obj).parents('li').find('.whishlist_icon').html('<i class="icon-spinner8 icon-spin"></i>');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {
            jQuery(obj).parents('li').find('.whishlist_icon').html(response);
            jQuery(obj).parents('li').find('.whishlist_icon').attr("onclick", "automobile_addinventorys_to_wishlist('" + admin_url + "','" + post_id + "',this)");
            jQuery(obj).parents('li').find('.whishlist_icon').attr("data-original-title", "Shortlisted");
            automobile_inventory_shortlist_load(admin_url);
        }
    });
    return false;
}


/**
 * Remove Wishlist Function
 */
function automobile_removeinventorys_to(admin_url, post_id, obj) {
    "use strict";
    var dataString = 'post_id=' + post_id + '&action=automobile_removeinventory_to_user';
    jQuery(obj).parents('li').find('.whishlist_icon').html('<i class="icon-spinner8 icon-spin"></i>');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {
            jQuery(obj).parents('li').find('.whishlist_icon').html(response);
            jQuery(obj).parents('li').find('.whishlist_icon').attr("onclick", "automobile_addinventorys_to_wish('" + admin_url + "','" + post_id + "',this)");
            jQuery(obj).parents('li').find('.whishlist_icon').attr("data-original-title", "Shortlisted");
            automobile_inventory_shortlist_load(admin_url);
        }
    });
    return false;
}

/**
 * Add inventorys to applied list Function
 */
function automobile_addinventorys_to_applied(admin_url, post_id, obj) {
    "use strict";
    var dataString = 'post_id=' + post_id + '&action=automobile_add_applied_inventory_to_usermeta';
    jQuery(obj).parents('li').find('.applied_icon').html('<i class="icon-spinner8 icon-spin"></i>');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {
            jQuery(obj).parents('li').find('.applied_icon').html(response);
        }
    });
    return false;
}
/**
 * removed inventory to applied
 */

/*
 * 
 * add applied list for left box
 */
function automobile_addinventorys_left_to_applied(admin_url, post_id, obj) {
    "use strict";
    var dataString = 'post_id=' + post_id + '&action=automobile_add_applied_inventory_to_usermeta';
    var old_html = jQuery(obj).parents('div').find('.applied_icon').html();
    jQuery(obj).parents('div').find('.applied_icon').html('<span><i class="icon-spinner8 icon-spin"></i></span>');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        dataType: "json",
        success: function (response) {
            if (response.status == 0) {
                jQuery(obj).parents('div').find('.applied_icon').html(old_html);
                show_alert_msg(response.msg);
            } else {
                var application_count = jQuery("#applications_count").html();
                application_count = (parseInt(application_count) + parseInt(1));
                jQuery(obj).parents('div').find('.applied_icon').html(response.msg);
                jQuery("#applications_count").html(application_count);
                jQuery(".outerwrapp-layer" + post_id).fadeTo(2000, 500).slideUp(500);
            }
        }
    });
    return false;
}


/**
 * Remove inventory from applied list Function
 */
function automobile_removeinventorys_left_to_applied(admin_url, post_id, obj) {
    "use strict";
    var dataString = 'post_id=' + post_id + '&action=automobile_remove_applied_inventory_to_usermeta';
    var old_html = jQuery(obj).parents('div').find('.applied_icon').html();
    jQuery(obj).parents('div').find('.applied_icon').html('<i class="icon-spinner8 icon-spin"></i>');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        dataType: "json",
        success: function (response) {
            if (response.status == 0) {
                jQuery(obj).parents('div').find('.applied_icon').html(old_html);
                show_alert_msg(response.msg);
            } else {
                var application_count = jQuery("#applications_count").html();
                application_count = (parseInt(application_count) - parseInt(1));
                jQuery(obj).parents('div').find('.applied_icon').html(response);
                jQuery(obj).parents('div').find('.applied_icon').attr("onclick", "automobile_addinventorys_left_to_applied('" + admin_url + "','" + post_id + "',this)");
                jQuery(obj).parents('div').find('.applied_icon').attr("data-original-title", "Shortlisted");
                jQuery("#applications_count").html(application_count);
                jQuery(".outerwrapp-layer" + post_id).fadeTo(2000, 500).slideUp(500);
            }
        }
    });
    return false;
}
/**
 * load location ajax
 */
function automobile_load_location_ajax() {
    //alert('map loading');
    "use strict";
    jQuery('.form-select-country').change(function () {

        var plugin_url = jQuery(this).parents("#locations_wrap").data('plugin_url');
        var ajaxurl = jQuery(this).parents("#locations_wrap").data('ajaxurl');
        var dataString = 'country=' + this.value + '&action=automobile_load_country_states';
        var html = "<img src='" + plugin_url + "/assets/backend/images/ajax-loader.gif' />";

        jQuery(".loader-cities").html(html);
        jQuery(".loader-cities").show();
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: dataString,
            dataType: "json",
            success: function (response) {
                jQuery(".form-select-city").html(response.cities);
                jQuery(".loader-cities").html('').hide();
                // only for style implementation
                jQuery(".chosen-select").data("placeholder", "Select").trigger('chosen:updated');
                // resize map after load
//                google.maps.event.addListenerOnce(_self.vars.map, 'idle', function () {
//                    var center = _self.vars.map.getCenter();
//                    google.maps.event.trigger(_self.vars.map, 'resize');
//                    _self.vars.map.setCenter(center);
//                });


            }
        });
    });

    /**
     * Get cities only
     */
    jQuery('.form-select-state').change(function () {

        var plugin_url = jQuery(this).parents("#locations_wrap").data('plugin_url');
        var ajaxurl = jQuery(this).parents("#locations_wrap").data('ajaxurl');
        var country = jQuery(".form-select-country").val();
        var dataString = 'country=' + country + '&state=' + this.value + '&action=automobile_load_country_cities';
        var html = "<img src='" + plugin_url + "/assets/backend/images/ajax-loader.gif' />";
        jQuery(".loader-cities").html(html);
        jQuery(".loader-cities").show();
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: dataString,
            dataType: "json",
            success: function (response) {
                jQuery(".form-select-city").html(response.cities);
                jQuery(".chosen-select").data("placeholder", "Select").trigger('chosen:updated');
                jQuery(".loader-cities").html('').hide();
            }
        });
    });
    jQuery(document).ready(function (e) {

        //changeMap();
        jQuery('input#automobile-search-location').keypress(function (e) {

            if (e.which == '13') {
                e.preventDefault();
                automobile_search_map(this.value);
                return false;
            }
        });
        jQuery('#loc_country').change(function (e) {

            setAutocompleteCountry();
        });
    });
    function setAutocompleteCountry() {
        "use strict";
        var country = jQuery('select#loc_country option:selected').val(); /*document.getElementById('country').value;*/

        if (country != '') {
            autocomplete.setComponentRestrictions({'country': country});

        } else {
            autocomplete.setComponentRestrictions([]);
        }
    }

}
/**
 * Map
 */

function automobile_map_location_load(field_postfix) {

    field_postfix = field_postfix || '';
    "use strict";
    jQuery.noConflict();
    (function (jQuery) {

        // for ie9 doesn't support debug console
        if (!window.console)
            window.console = {};
        if (!window.console.log)
            window.console.log = function () {
            };
        // ^^^
        //alert(field_postfix);
        var GMapsLatLonPicker = (function () {

            var _self = this;

            // PARAMETERS (MODIFY THIS PART)
            _self.params = {
                defLat: 0,
                defLng: 0,
                defZoom: 1,
                queryLocationNameWhenLatLngChanges: true,
                queryElevationWhenLatLngChanges: true,
                mapOptions: {
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    mapTypeControl: false,
                    disableDoubleClickZoom: true,
                    zoomControlOptions: true,
                    streetViewControl: false,
                    scrollwheel: true,
                },
                strings: {
                    markerText: "Drag this Marker",
                    error_empty_field: "Couldn't find coordinates for this place",
                    error_no_results: "Couldn't find coordinates for this place"
                }
            };

            // VARIABLES USED BY THE FUNCTION (DON'T MODIFY THIS PART)
            _self.vars = {
                ID: null,
                LATLNG: null,
                map: null,
                marker: null,
                geocoder: null
            };

            // PRIVATE FUNCTIONS FOR MANIPULATING DATA
            var setPosition = function (position) {
                _self.vars.marker.setPosition(position);
                _self.vars.map.panTo(position);
                jQuery(_self.vars.cssID + ".gllpZoom").val(_self.vars.map.getZoom());
                jQuery(_self.vars.cssID + ".gllpLongitude").val(position.lng());
                jQuery(_self.vars.cssID + ".gllpLatitude").val(position.lat());
                jQuery(_self.vars.cssID).trigger("location_changed", jQuery(_self.vars.cssID));
                if (_self.params.queryLocationNameWhenLatLngChanges) {
                    getLocationName(position);
                }
                if (_self.params.queryElevationWhenLatLngChanges) {
                    getElevation(position);
                }
            };
            // for reverse geocoding
            var getLocationName = function (position) {
                var latlng = new google.maps.LatLng(position.lat(), position.lng());
                _self.vars.geocoder.geocode({'latLng': latlng}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK && results[1]) {
                        jQuery(_self.vars.cssID + ".gllpLocationName").val(results[1].formatted_address);
                    } else {
                        jQuery(_self.vars.cssID + ".gllpLocationName").val("");
                    }
                    jQuery(_self.vars.cssID).trigger("location_name_changed", jQuery(_self.vars.cssID));

                });
            };

            // for getting the elevation value for a position
            var getElevation = function (position) {
                var latlng = new google.maps.LatLng(position.lat(), position.lng());
                var locations = [latlng];
                var positionalRequest = {'locations': locations};
                _self.vars.elevator.getElevationForLocations(positionalRequest, function (results, status) {
                    if (status == google.maps.ElevationStatus.OK) {
                        if (results[0]) {
                            jQuery(_self.vars.cssID + ".gllpElevation").val(results[0].elevation.toFixed(3));
                        } else {
                            jQuery(_self.vars.cssID + ".gllpElevation").val("");
                        }
                    } else {
                        jQuery(_self.vars.cssID + ".gllpElevation").val("");
                    }
                    jQuery(_self.vars.cssID).trigger("elevation_changed", jQuery(_self.vars.cssID));

                });
            };
            // search function
            var performSearch = function (string, silent) {
                if (string == "") {
                    if (!silent) {
                        displayError(_self.params.strings.error_empty_field);
                    }
                    return;
                }
                _self.vars.geocoder.geocode(
                        {"address": string},
                        function (results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                jQuery(_self.vars.cssID + ".gllpZoom").val(11);
                                _self.vars.map.setZoom(parseInt(jQuery(_self.vars.cssID + ".gllpZoom").val()));
                                setPosition(results[0].geometry.location);
                            } else {
                                if (!silent) {
                                    displayError(_self.params.strings.error_no_results);
                                }
                            }
                        }
                );
            };
            // error function
            var displayError = function (message) {
                alert("Error: " + message);
            };

            // PUBLIC FUNCTIONS
            var publicfunc = {
                // INITIALIZE MAP ON DIV
                init: function (object) {

                    if (!jQuery(object).attr("id")) {
                        if (jQuery(object).attr("name")) {
                            jQuery(object).attr("id", jQuery(object).attr("name"));
                        } else {
                            jQuery(object).attr("id", "_MAP_" + Math.ceil(Math.random() * 10000));
                        }
                    }

                    _self.vars.ID = jQuery(object).attr("id");
                    _self.vars.cssID = "#" + _self.vars.ID + " ";
                    _self.params.defLat = jQuery(_self.vars.cssID + ".gllpLatitude").val() ? jQuery(_self.vars.cssID + ".gllpLatitude").val() : _self.params.defLat;
                    _self.params.defLng = jQuery(_self.vars.cssID + ".gllpLongitude").val() ? jQuery(_self.vars.cssID + ".gllpLongitude").val() : _self.params.defLng;
                    // alert("longit ----" + jQuery(_self.vars.cssID + ".gllpLongitude").val());
                    _self.params.defZoom = jQuery(_self.vars.cssID + ".gllpZoom").val() ? parseInt(jQuery(_self.vars.cssID + ".gllpZoom").val()) : _self.params.defZoom;
                    _self.vars.LATLNG = new google.maps.LatLng(_self.params.defLat, _self.params.defLng);
                    _self.vars.MAPOPTIONS = _self.params.mapOptions;
                    _self.vars.MAPOPTIONS.zoom = _self.params.defZoom;
                    _self.vars.MAPOPTIONS.center = _self.vars.LATLNG;
                    _self.vars.map = new google.maps.Map(jQuery(_self.vars.cssID + ".gllpMap").get(0), _self.vars.MAPOPTIONS);

                    _self.vars.geocoder = new google.maps.Geocoder();
                    _self.vars.elevator = new google.maps.ElevationService();
                    _self.vars.marker = new google.maps.Marker({
                        position: _self.vars.LATLNG,
                        map: _self.vars.map,
                        title: _self.params.strings.markerText,
                        draggable: true
                    });
                    // Set position on doubleclick
                    google.maps.event.addListener(_self.vars.map, 'dblclick', function (event) {
                        setPosition(event.latLng);
                    });
                    // Set position on marker move
                    google.maps.event.addListener(_self.vars.marker, 'dragend', function (event) {
                        setPosition(_self.vars.marker.position);
                    });
                    // Set zoom feld's value when user changes zoom on the map
                    google.maps.event.addListener(_self.vars.map, 'zoom_changed', function (event) {
                        jQuery(_self.vars.cssID + ".gllpZoom").val(_self.vars.map.getZoom());
                        jQuery(_self.vars.cssID).trigger("location_changed", jQuery(_self.vars.cssID));
                    });
                    // Update location and zoom values based on input field's value 
                    jQuery(_self.vars.cssID + ".gllpUpdateButton").bind("click", function () {
                        var lat = jQuery(_self.vars.cssID + ".gllpLatitude").val();
                        var lng = jQuery(_self.vars.cssID + ".gllpLongitude").val();
                        var latlng = new google.maps.LatLng(lat, lng);
                        _self.vars.map.setZoom(parseInt(jQuery(_self.vars.cssID + ".gllpZoom").val()));
                        setPosition(latlng);
                    });
                    // Search function by search button
                    jQuery(_self.vars.cssID + ".gllpSearchButton").bind("click", function () {
                        automobile_fe_search_map(jQuery('#loc_address').val());
                        performSearch(jQuery(_self.vars.cssID + ".directory-search-locationa").val(), false);
                        //alert(jQuery(_self.vars.cssID + ".directory-search-locationa").val());
                        //alert(_self.vars.cssID + ".gllpSearchField_fe");
                    });
                    // Search function by gllp_perform_search listener
                    jQuery(document).bind("gllp_perform_search", function (event, object) {
                        performSearch(jQuery(object).attr('string'), true);
                    });
                    // Zoom function triggered by gllp_perform_zoom listener
                    jQuery(document).bind("gllp_update_fields", function (event) {
                        var lat = jQuery(_self.vars.cssID + ".gllpLatitude").val();
                        var lng = jQuery(_self.vars.cssID + ".gllpLongitude").val();
                        var latlng = new google.maps.LatLng(lat, lng);
                        _self.vars.map.setZoom(parseInt(jQuery(_self.vars.cssID + ".gllpZoom").val()));
                        setPosition(latlng);
                    });

                    // resize map after load
                    google.maps.event.addListenerOnce(_self.vars.map, 'idle', function () {
                        var center = _self.vars.map.getCenter();
                        google.maps.event.trigger(_self.vars.map, 'resize');
                        _self.vars.map.setCenter(center);
                    });

                }

            }
            return publicfunc;
        });
        jQuery(document).ready(function () {
            jQuery("#fe_map" + field_postfix).each(function () {
                (new GMapsLatLonPicker()).init(jQuery(this));
            });
        });
        jQuery(document).bind("location_changed", function (event, object) {
            console.log("changed: " + jQuery(object).attr('id'));
        });
    }(jQuery));
}





// Search Map
function automobile_search_map(location) {

    "use strict";
    jQuery('.gllpSearchField').val(location);
    setTimeout(function () {
        jQuery(".gllpSearchButton").trigger("click");
    }, 10);
}

/**
 * User Register Validation
 */
function automobile_registration_validation(admin_url, id) {
	jQuery('div#result_' + id).addClass('cs-spinner');
    jQuery('div#result_' + id).html('<i class="icon-spinner8 icon-spin"></i>');
    function newValues(id) {
        // jQuery('#user_profile').val();
        var serializedValues = jQuery("#wp_signup_form_" + id).serialize() + "&id=" + id;

        return serializedValues;
    }

    var serializedReturn = newValues(id);
    jQuery('div#result_' + id).removeClass('success error');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        dataType: 'json',
        data: serializedReturn,
        success: function (response) {
            if (response.type == 'error') {
                jQuery("div#result_" + id).removeClass('success').addClass("error");
				jQuery('div#result_' + id).removeClass('cs-spinner');
                jQuery('div#result_' + id).html(response.message);
                jQuery("div#result_" + id).show();
            } else if (response.type == 'success') {
                jQuery('div#result_' + id).html(response.message);
				jQuery('div#result_' + id).removeClass('cs-spinner');
                jQuery("div#result_" + id).show();
            }
        }
    });
}


function automobile_contact_validation(admin_url, id) {


    jQuery('div.dealer-contact-form_' + id).html('<i class="icon-spinner8 icon-spin"></i>').fadeIn();
    function newValues(id) {
        jQuery('.dealer-contact-form').val();
        var serializedValues = jQuery("#dealerid_contactus_" + id).serialize() + "&id=" + id;
        return serializedValues;
    }
    var serializedReturn = newValues(id);
    jQuery('div#result_' + id).removeClass('success error');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        dataType: 'json',
        data: serializedReturn,
        success: function (response) {
            if (response.type == 'error') {
                jQuery("div.dealer-contact-form" + id).removeClass('success').addClass("error");
                jQuery('div.dealer-contact-form' + id).html(response.message);
                jQuery("div.dealer-contact-form" + id).show();
            } else if (response.type == 'success') {
                jQuery('div.dealer-contact-form' + id).html(response.message);
                jQuery("div.dealer-contact-form" + id).show();
            }
        }
    });
}


/**
 * User Login Authentication
 */
function automobile_user_authentication(admin_url, id) {
    "use strict";
    jQuery('.login-form-id-' + id + ' .status-message').addClass('cs-spinner');
    jQuery('.login-form-id-' + id + ' .status-message').html('<i class="icon-spinner8 icon-spin"></i>');
    function newValues(id) {
        var serializedValues = jQuery("#ControlForm_" + id).serialize();
        return serializedValues;
    }
    var serializedReturn = newValues(id);
    jQuery('.login-form-id-' + id + ' .status-message').removeClass('success error');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        dataType: 'json',
        data: serializedReturn,
        success: function (data) {
            jQuery('.login-form-id-' + id + ' .status-message').html(data.message);
            jQuery('.fa-spin').remove();
            if (data.loggedin == false) {
                jQuery('.login-form-id-' + id + ' .status-message').removeClass('success').addClass("error");
                jQuery('.login-form-id-' + id + ' .status-message').removeClass('cs-spinner');
                jQuery('.login-form-id-' + id + ' .status-message').html(data.message);
                jQuery('.login-form-id-' + id + ' .status-message').show();
            } else if (data.loggedin == true) {
                jQuery('.login-form-id-' + id + ' .status-message').removeClass('error').addClass("success");
                jQuery('.login-form-id-' + id + ' .status-message').removeClass('cs-spinner');
                jQuery('.login-form-id-' + id + ' .status-message').html(data.message);
                jQuery('.login-form-id-' + id + ' .status-message').show();
                document.location.href = data.redirecturl;
            }
        }
    });
}


/**
 * removed applied inventorys
 */
function automobile_ajax_remove_appliedinventorys(admin_url, plugin_url, user_id) {
    "use strict";
    var dataString = 'automobile_uid=' + user_id + '&action=automobile_ajax_remove_appliedinventorys';
    jQuery('#cs-applied-inventorys .cs-loader').html('<i class="icon-spinner8 icon-spin"></i>');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {
            jQuery('.cs-favorite-inventorys .scetion-title span').html(response);
            jQuery(".feature-inventorys li.cs-expired").fadeTo(2000, 500).slideUp(500);
        }
    });
    return false;
}


/**
 * set session
 */
function automobile_set_session(admin_url, post_type) {
    "use strict";
    var dataString = 'post_type=' + post_type + '&action=automobile_ajax_set_session';
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {
        }
    });
    return false;
}
/**
 * sort filter
 */
function automobile_set_sort_filter(admin_url, field_name) {
    "use strict";
    var field_name_value = jQuery("#" + field_name).val();
    jQuery("#" + field_name + '_div').html('<i class="icon-spinner8 icon-spin"></i>');
    jQuery(".cs-inventories-listing-loader").html('<i class="icon-spinner icon-spin"></i>');
    jQuery('.cs-inventories-listing-loader').show();
    var dataString = 'field_name=' + field_name + '&field_name_value=' + field_name_value + '&action=automobile_set_sort_filter';
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {
            if (response == 'success') {
                window.location = window.location.href;
            }
        }
    });
    return false;
}





/**
 * sort filter dealer
 */
function automobile_dealer_sort_filter(admin_url, field_name) {
    "use strict";
    var field_name_value = jQuery("#" + field_name).val();
    jQuery("#" + field_name + '_div').html('<i class="icon-spinner8 icon-spin"></i>');
    jQuery(".cs-inventories-listing-loader").html('<i class="icon-spinner icon-spin"></i>');
    jQuery('.cs-inventories-listing-loader').show();
    var dataString = 'field_name=' + field_name + '&field_name_value=' + field_name_value + '&action=automobile_dealer_sort_filter';
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {
            if (response == 'success') {
                window.location = window.location.href;
            }
        }
    });
    return false;
}
/**
 * avatar upload
 */
function automobile_user_avatar_upload(ajaxurl) {
    "use strict";
    var fd = new FormData();
    var file_data = fd.append('user_avatar', jQuery('input[type=file]')[0].files[0]);
    var other_data = jQuery('#candidate').serializeArray();
    jQuery.each(other_data, function (key, input) {
        fd.append(input.name, input.value);
    });
    jQuery.ajax({
        url: ajaxurl,
        data: fd,
        contentType: false,
        processData: false,
        dataType: "json",
        type: 'POST',
        success: function (response) {
            jQuery('#cs-user-avatar-ajax-display').html(response.list_icon);
            jQuery(".page-sidebar .info-thumb").html(response.menu_icon);
        }
    });
}
/**
 * check comma string before submit
 */





function comma_string_before_submit_form(frm, get_field, str_field) {
    "use strict";

    var ids = '';

    var counter = 0, // counter for checked checkboxes
            i = 0, // loop variable
            url = jQuery('#' + str_field).val();    // final url string

    input_obj = document.getElementsByName(get_field);

    for (i = 0; i < input_obj.length; i++) {

        if (input_obj[i].checked === true) {

            counter++;
            url = url + ',' + input_obj[i].value;
        }
    }

    if (counter > 0) {

    }

    jQuery('#' + str_field).val(url);
    jQuery("#" + frm).submit();
}

/**
 * submit specialism form
 */


function submit_specialism_form(frm, str_field) {
    "use strict";
    var $checkboxes = '';
    var ids = '';
    if (typeof $(".specialism_list input[type=checkbox]") != "undefined") {
        $checkboxes = $(".specialism_list input[type=checkbox]");
        var ids = $checkboxes.filter(':checked').map(function () {
            return this.value;
        }).get().join(',');
    }

    jQuery('#' + str_field).val(ids);
    jQuery("#" + frm).submit();
}
/**
 * fixed header inner
 */
function automobile_mk_sticky() {
    "use strict";
    if (jQuery('#sticker').length != '') {
        jQuery("#sticker").sticky({topSpacing: 0, center: true, className: "candidate-list"});
    }
}
/**
 * scroll sticky menu
 */
function automobile_scroll_menu() {
    "use strict";
    jQuery(function () {
        if (jQuery('#sidemenu').length != '') {
            jQuery('#sidemenu').visualNav({
                scrollOnInit: false, // disable auto scroll when come first time
                useHash: false, // if true, the location hash will be updated
                initialized: function () {
                    console.log('init');
                    var XposNav = jQuery("#sidemenu").offset().top;
                    jQuery(window).scroll(function () {
                        var scrollPos = jQuery(window).scrollTop();
                        if (scrollPos >= XposNav) {
                            jQuery("#sidemenu").addClass('fixed');
                        } else if (scrollPos < XposNav) {
                            jQuery("#sidemenu").removeClass('fixed');
                        }
                    });
                }
            });
        }
    });
}





/**
 * Add candidate CV to selected list Function
 */
function automobile_add_cv_selected_list(admin_url, post_id, obj) {
    "use strict";
    var dataString = 'post_id=' + post_id + '&action=automobile_add_cv_selected_list_usermeta';
    jQuery(obj).parents('.candidate-detail').find('.cv-ad-to-list').html('<i class="icon-spinner8 icon-spin"></i>');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {
            jQuery(obj).parents('.candidate-detail').find('.cv-ad-to-list').html(response);
            //jQuery("a"+atr_id).attr("class", "heartactive");
            jQuery(obj).parents('.candidate-detail').find('.cv-ad-to-list').attr("onclick", "automobile_remove_cv_selected_list('" + admin_url + "','" + post_id + "',this)");
            jQuery(".outerwrapp-layer" + post_id).fadeTo(2000, 500).slideUp(500);
        }
    });
    return false;
}


/**
 * Remove Wishlist Function
 */
function automobile_remove_cv_selected_list(admin_url, post_id, obj) {
    "use strict";
    var dataString = 'post_id=' + post_id + '&action=automobile_remove_cv_selected_list_usermeta';
    jQuery(obj).parents('.candidate-detail').find('.cv-ad-to-list').html('<i class="icon-spinner8 icon-spin"></i>');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {
            jQuery(obj).parents('.candidate-detail').find('.cv-ad-to-list').html(response);
            jQuery(obj).parents('.candidate-detail').find('.cv-ad-to-list').attr("onclick", "automobile_add_cv_selected_list('" + admin_url + "','" + post_id + "',this)");
            jQuery(".outerwrapp-layer" + post_id).fadeTo(2000, 500).slideUp(500);
        }
    });
    return false;
}/*
 * Delete Media Functions
 */
function del_media(id) {
    "use strict";
    var $ = jQuery;
    //  jQuery('+id+').remove();
    //jQuery('input[name="'+id+'"]').value('');
    jQuery('#' + id + '_box').remove();
    jQuery('#' + id).val('');
    // jQuery('#' + id).next().show();
}
/*
 * End Delete Media Functions
 */
/**
 * del media
 */
function automobile_del_media(id) {
    "use strict";
    //  jQuery('+id+').remove();
    jQuery('#' + id + '_box').remove();
    jQuery('#' + id).val('');
    // jQuery('#' + id).next().show();
}
/**
 * del cover letter
 */
function automobile_del_cover_letter(id) {
    "use strict";
    jQuery('#' + id + '_box').hide();
    jQuery('#' + id).val('');
}
/**
 * trigger function
 */
function trigger_func(btnid) {
    "use strict";
    jQuery(btnid).trigger('click');
}
/**
 * Numeric only control handler
 */
function isNumberKey(evt)
{
    "use strict";
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31
            && (charCode < 48 || charCode > 57))
        return false;

    return true;
}
/**
 * content hide at listing pages loading 
 */
function automobile_listing_content_load() {
    automobile_data_loader_load('.main-cs-loader');
}
/**
 * dashboard tab load
 */
function automobile_dashboard_tab_load(tabid, type, admin_url, uid, pkg_array, page_id_all) {
    "use strict";
    pkg_array = pkg_array || '';
    page_id_all = page_id_all || '';
    "use strict";
    var current_url = location.protocol + "//" + location.host + location.pathname;//window.location.href;

    if (type == 'dealer') {

        automobile_data_loader_load('#dealer-dashboard .main-cs-loader');

        if (tabid == 'user-genral-setting') {
            if (typeof (ajaxRequest) != 'undefined') {
                ajaxRequest.abort();
            }
            var dataString = 'automobile_uid=' + uid + '&action=automobile_dealer_ajax_profile';
            ajaxRequest = jQuery.ajax({
                type: "POST",
                url: admin_url,
                data: dataString,
                success: function (response) {
                    jQuery('#user-genral-setting').html(response);

                    jQuery('#dealer_left_listing_link').removeClass('active');
                    jQuery('#dealer_left_inventorys_link').removeClass('active');
                    jQuery('#dealer_left_transactions_link').removeClass('active');
                    jQuery('#dealer_left_resumes_link').removeClass('active');
                    jQuery('#dealer_left_packages_link').removeClass('active');
                    jQuery('#dealer_left_postinventorys_link').removeClass('active');
                    jQuery('#cs-act-tab,#dealer_left_list_link, #dealer_left_post_link, #dealer_left_shortlist_link, #dealer_left_transaction_link, #dealer_left_packages_link').removeClass('active');
                    jQuery('#dealer_left_profile_link').addClass('active');
                    jQuery('#user-car-listing').hide();
                    jQuery('#dashboard').hide();
                    jQuery('#user-car-listing').hide();
                    jQuery('#transactions').hide();
                    jQuery('#user-car-shortlist').hide();
                    jQuery('#packages').hide();
                    jQuery('#user-post-vehicle').hide();
                    jQuery('#user-genral-setting').show();
                    jQuery('#dealer-dashboard .main-cs-loader').html('');
                    window.history.pushState(null, null, current_url + "?profile_tab=user-genral-setting");
                }
            });
        } else if (tabid == 'user-car-listing') {

            if (typeof (ajaxRequest) != 'undefined') {
                ajaxRequest.abort();
            }
            var dataString = 'automobile_uid=' + uid + '&action=automobile_ajax_manage_inventory' + '&page_id_all=' + page_id_all;

            ajaxRequest = jQuery.ajax({
                type: "POST",
                url: admin_url,
                data: dataString,
                success: function (response) {
                    jQuery('#user-car-listing').html(response);

                    jQuery('#dealer_left_dashboard_link').removeClass('active');
                    jQuery('#dealer_left_profile_link').removeClass('active');
                    jQuery('#dealer_left_transactions_link').removeClass('active');
                    jQuery('#dealer_left_resumes_link').removeClass('active');
                    jQuery('#dealer_left_packages_link').removeClass('active');
                    jQuery('#dealer_left_postinventorys_link').removeClass('active');
                    jQuery('#cs-act-tab, #dealer_left_profile_link, #dealer_left_list_link, #dealer_left_post_link, #dealer_left_shortlist_link, #dealer_left_transaction_link, #dealer_left_packages_link').removeClass('active');
                    jQuery('#dealer_left_list_link').addClass('active');
                    jQuery('#cs-act-tab').hide();
                    jQuery('#dashboard').hide();
                    jQuery('#user-genral-setting').hide();
                    jQuery('#transactions').hide();
                    jQuery('#user-car-shortlist').hide();
                    jQuery('#packages').hide();
                    jQuery('#user-post-vehicle').hide();
                    jQuery('#user-car-listing').show();
                    jQuery('#dealer-dashboard .main-cs-loader').html('');
                    window.history.pushState(null, null, current_url + "?profile_tab=user-car-listing");
                }
            });
        } else if (tabid == 'transactions') {
            if (typeof (ajaxRequest) != 'undefined') {
                ajaxRequest.abort();
            }

            var dataString = 'automobile_uid=' + uid + '&action=automobile_ajax_trans_history';
            ajaxRequest = jQuery.ajax({
                type: "POST",
                url: admin_url,
                data: dataString,
                success: function (response) {

                    jQuery("#transactions").html(response);
                    jQuery('#dealer_left_dashboard_link').removeClass('active');
                    jQuery('#dealer_left_profile_link').removeClass('active');
                    jQuery('#dealer_left_inventorys_link').removeClass('active');
                    jQuery('#dealer_left_resumes_link').removeClass('active');
                    jQuery('#dealer_left_packages_link').removeClass('active');
                    jQuery('#dealer_left_postinventorys_link').removeClass('active');
                    jQuery('#cs-act-tab, #dealer_left_profile_link, #dealer_left_list_link, #dealer_left_post_link, #dealer_left_shortlist_link, #dealer_left_transaction_link, #dealer_left_packages_link').removeClass('active');

                    jQuery('#dealer_left_transaction_link').addClass('active');
                    jQuery('#ser-post-vehicle').hide();
                    jQuery('#dashboard').hide();
                    jQuery('#user-genral-setting').hide();
                    jQuery('#user-car-listing').hide();
                    jQuery('#user-car-shortlist').hide();
                    jQuery('#packages').hide();
                    jQuery('#user-post-vehicle').hide();
                    jQuery('#transactions').show();
                    jQuery('#dealer-dashboard .main-cs-loader').html('');
                    window.history.pushState(null, null, current_url + "?profile_tab=transactions");
                }
            });

        } else if (tabid == 'user-car-shortlist') {

            var dataString = 'automobile_uid=' + uid + '&action=automobile_ajax_shortlisted_vehicles' + '&page_id_all=' + page_id_all;
            if (typeof (ajaxRequest) != 'undefined') {
                ajaxRequest.abort();
            }
            ajaxRequest = jQuery.ajax({
                type: "POST",
                url: admin_url,
                data: dataString,
                success: function (response) {
                    jQuery('#user-car-shortlist').html(response);

                    jQuery('#dealer_left_dashboard_link').removeClass('active');
                    jQuery('#dealer_left_profile_link').removeClass('active');
                    jQuery('#dealer_left_inventorys_link').removeClass('active');
                    jQuery('#dealer_left_transactions_link').removeClass('active');
                    jQuery('#dealer_left_packages_link').removeClass('active');
                    jQuery('#dealer_left_postinventorys_link').removeClass('active');
                    jQuery('#cs-act-tab, #dealer_left_profile_link, #dealer_left_list_link, #dealer_left_post_link, #dealer_left_shortlist_link, #dealer_left_transaction_link, #dealer_left_packages_link').removeClass('active');
                    jQuery('#dealer_left_shortlist_link').addClass('active');
                    jQuery('#cs-act-tab').hide();
                    jQuery('#dashboard').hide();
                    jQuery('#user-genral-setting').hide();
                    jQuery('#user-car-listing').hide();
                    jQuery('#transactions').hide();
                    jQuery('#packages').hide();
                    jQuery('#user-post-vehicle').hide();
                    jQuery('#user-car-shortlist').show();
                    jQuery('#dealer-dashboard .main-cs-loader').html('');
                    window.history.pushState(null, null, current_url + "?profile_tab=user-car-shortlist");
                }
            });

        } else if (tabid == 'packages') {

            var dataString = 'automobile_uid=' + uid + '&action=automobile_ajax_inventory_packages';
            if (typeof (ajaxRequest) != 'undefined') {
                ajaxRequest.abort();
            }
            ajaxRequest = jQuery.ajax({
                type: "POST",
                url: admin_url,
                data: dataString,
                success: function (response) {
                    jQuery('#packages').html(response);
                    jQuery('#dealer_left_dashboard_link').removeClass('active');
                    jQuery('#dealer_left_profile_link').removeClass('active');
                    jQuery('#dealer_left_inventorys_link').removeClass('active');
                    jQuery('#dealer_left_transactions_link').removeClass('active');
                    jQuery('#dealer_left_resumes_link').removeClass('active');
                    jQuery('#dealer_left_postinventorys_link').removeClass('active');
                    jQuery('#cs-act-tab, #dealer_left_profile_link, #dealer_left_list_link, #dealer_left_post_link, #dealer_left_shortlist_link, #dealer_left_transaction_link, #dealer_left_packages_link').removeClass('active');
                    jQuery('#dealer_left_packages_link').addClass('active');
                    jQuery('#cs-act-tab').hide();
                    jQuery('#dashboard').hide();
                    jQuery('#user-genral-setting').hide();
                    jQuery('#user-car-listing').hide();
                    jQuery('#transactions').hide();
                    jQuery('#user-car-shortlist').hide();
                    jQuery('#user-post-vehicle').hide();
                    jQuery('#packages').show();
                    jQuery('#dealer-dashboard .main-cs-loader').html('');
                    window.history.pushState(null, null, current_url + "?profile_tab=packages");
                }
            });

        } else if (tabid == 'packages') {

            var dataString = 'automobile_uid=' + uid + '&action=automobile_ajax_inventory_packages';
            if (typeof (ajaxRequest) != 'undefined') {
                ajaxRequest.abort();
            }
            ajaxRequest = jQuery.ajax({
                type: "POST",
                url: admin_url,
                data: dataString,
                success: function (response) {
                    jQuery('#packages').html(response);
                    jQuery('#dealer_left_dashboard_link').removeClass('active');
                    jQuery('#dealer_left_profile_link').removeClass('active');
                    jQuery('#dealer_left_inventorys_link').removeClass('active');
                    jQuery('#dealer_left_transactions_link').removeClass('active');
                    jQuery('#dealer_left_resumes_link').removeClass('active');
                    jQuery('#dealer_left_postinventorys_link').removeClass('active');
                    jQuery('#cs-act-tab, #dealer_left_profile_link, #dealer_left_list_link, #dealer_left_post_link, #dealer_left_shortlist_link, #dealer_left_transaction_link, #dealer_left_packages_link').removeClass('active');
                    jQuery('#dealer_left_packages_link').addClass('active');
                    jQuery('#cs-act-tab').hide();
                    jQuery('#dashboard').hide();
                    jQuery('#user-genral-setting').hide();
                    jQuery('#user-car-listing').hide();
                    jQuery('#transactions').hide();
                    jQuery('#user-car-shortlist').hide();
                    jQuery('#user-post-vehicle').hide();
                    jQuery('#packages').show();
                    jQuery('#dealer-dashboard .main-cs-loader').html('');
                    window.history.pushState(null, null, current_url + "?profile_tab=packages");
                }
            });

        } else if (tabid == 'user-post-vehicle') {

            var dataString = 'automobile_uid=' + uid + '&action=automobile_dealer_post_inventory';
            if (typeof (ajaxRequest) != 'undefined') {
                ajaxRequest.abort();
            }

            ajaxRequest = jQuery.ajax({
                type: "POST",
                url: admin_url,
                data: dataString,
                success: function (response) {
                    jQuery('#user-post-vehicle').html(response);
                    jQuery('#dealer_left_dashboard_link').removeClass('active');
                    jQuery('#dealer_left_profile_link').removeClass('active');
                    jQuery('#dealer_left_inventorys_link').removeClass('active');
                    jQuery('#dealer_left_transactions_link').removeClass('active');
                    jQuery('#dealer_left_resumes_link').removeClass('active');
                    jQuery('#dealer_left_packages_link').removeClass('active');
                    jQuery('#cs-act-tab,#dealer_left_profile_link, #dealer_left_list_link, #dealer_left_post_link, #dealer_left_shortlist_link, #dealer_left_transaction_link, #dealer_left_packages_link').removeClass('active');
                    jQuery('#dealer_left_post_link').addClass('active');

                    jQuery('#user-car-shortlist').hide();
                    jQuery('#dashboard').hide();
                    jQuery('#user-genral-setting').hide();
                    jQuery('#user-car-listing').hide();
                    jQuery('#transactions').hide();
                    jQuery('#resumes').hide();
                    jQuery('#packages').hide();
                    // empty all div's
                    jQuery('#cs-act-tab').html('');
                    jQuery('#dashboard').html('');
                    jQuery('#user-genral-setting').html('');
                    jQuery('#user-car-listing').html('');
                    jQuery('#transactions').html('');
                    jQuery('#user-car-shortlist').html('');
                    jQuery('#packages').html('');
                    jQuery('#user-post-vehicle').html(response);
                    //cs_inventory_post_tabs();
                    jQuery('#user-post-vehicle').show();
                    jQuery('#dealer-dashboard .main-cs-loader').html('');
                    window.history.pushState(null, null, current_url + "?profile_tab=user-post-vehicle");


                }
            });

        }
    }
}
/*
 * Profile Delete Function
 */
function cs_remove_profile(admin_url, u_id, template) {
    "use strict";
    //document.getElementById('id_confrmdiv').style.display = "block"; //this is the replace of this line
   // document.getElementById('id_truebtn').onclick = function () {
        var dataString;
        dataString = 'u_id=' + u_id + '&action=cs_remove_profile';
		console.log(dataString);
        if (template == 'cand') {
            automobile_data_loader_load('#dealer-dashboard .main-cs-loader');
        } else {
            automobile_data_loader_load('#dealer-dashboard .main-cs-loader');
        }
        jQuery.ajax({
            type: "POST",
            url: admin_url,
            data: dataString,
            dataType: "json",
            success: function (response) {
                if (response.status == 'success') {
                    document.location.href = response.redirecturl;
                } else {
                    alert(response.message);
                }
            }
        });
        document.getElementById('id_confrmdiv').style.display = "none";
        return false;
    //};

    document.getElementById('id_falsebtn').onclick = function () {
        document.getElementById('id_confrmdiv').style.display = "none";
        return false;
    };
}
function automobile_inventory_edit_tab() {
    "use strict";
    jQuery('#user-genral-setting').removeClass('active');
    jQuery('#user-genral-setting').hide();
}
/**
 * inventory status update
 */
function automobile_inventory_status_update(admin_url, automobile_inventoryid, automobile_status) {
    "use strict";
    var dataString = 'automobile_inventoryid=' + automobile_inventoryid + '&automobile_status=' + automobile_status + '&action=automobile_inventory_status_update';
    automobile_data_loader_load('#dealer-dashboard .main-cs-loader');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        dataType: "HTML",
        success: function (response) {
            var total_count_active_inventory = jQuery('#automobile_user_total_active_inventory').html();
            if (total_count_active_inventory == '') {
                total_count_active_inventory = 0;
            }
            var data = JSON.parse(response);
            console.log(data);
            if (data.error == 0) {
                if (automobile_status == 'active') {
                    jQuery('#automobile_inventory_status_html' + automobile_inventoryid + '').html('');
                    jQuery('#automobile_invenotry_link' + automobile_inventoryid + '').attr("onclick", "");
                    jQuery('#automobile_invenotry_link' + automobile_inventoryid + '').attr("data-original-title", "");
                    jQuery('#automobile_inventory_status_html' + automobile_inventoryid + '').html('Active');
                    jQuery('#automobile_invenotry_link' + automobile_inventoryid + '').attr("onclick", "automobile_inventory_status_update('" + admin_url + "', '" + automobile_inventoryid + "', 'inactive')");
                    jQuery('#automobile_invenotry_link' + automobile_inventoryid + '').attr("data-original-title", "Inactive");
                    total_count_active_inventory = (parseInt(total_count_active_inventory) + parseInt(1));
                } else if (automobile_status == 'inactive') {
                    jQuery('#automobile_inventory_status_html' + automobile_inventoryid + '').html('');
                    jQuery('#automobile_invenotry_link' + automobile_inventoryid + '').attr("onclick", "");
                    jQuery('#automobile_invenotry_link' + automobile_inventoryid + '').attr("data-original-title", "");
                    jQuery('#automobile_inventory_status_html' + automobile_inventoryid + '').html('Inactive');
                    jQuery('#automobile_invenotry_link' + automobile_inventoryid + '').attr("onclick", "automobile_inventory_status_update('" + admin_url + "', '" + automobile_inventoryid + "', 'active')");
                    jQuery('#automobile_invenotry_link' + automobile_inventoryid + '').attr("data-original-title", "Active");
                    total_count_active_inventory = (parseInt(total_count_active_inventory) - parseInt(1));
                }
                jQuery('#automobile_user_total_active_inventory').html(total_count_active_inventory);
                jQuery("#automobile_inventory_link" + automobile_inventoryid).html(data.icon);
            }
            jQuery('#dealer-dashboard .main-cs-loader').html('');
            show_alert_msg(data.message);
        }
    });
    return false;
}
/**
 * inventory shortlist
 */
function automobile_inventory_shortlist_load(admin_url) {
    "use strict";
    jQuery('#top-wishlist-content').html('<i class="icon-spinner8 icon-spin"></i>');
    var dataString = 'action=automobile_inventory_shortlist_load';
    automobile_data_loader_load('#dealer-dashboard .main-cs-loader');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        dataType: "HTML",
        success: function (response) {
            jQuery('#top-wishlist-content').html('');
            jQuery('#top-wishlist-content').html(response);
        }
    });
    return false;
}
/**
 * show alert message
 */
function show_alert_msg(msg) {
    "use strict";
    jQuery('#dealer-dashboard .main-cs-loader').html('');
    jQuery('.automobile_alerts').html('<div class="cs-remove-msg"><i class="icon-check-circle"></i>' + msg + '</div>');
    var classes = jQuery('.automobile_alerts').attr('class');
    classes = classes + " active";
    jQuery('.automobile_alerts').addClass(classes);
    setTimeout(function () {
        jQuery('.automobile_alerts').removeClass("active");
    }, 4000);
}
/*
 * chosen selection box
 */
/**
 * show loader before load data
 */
function automobile_data_loader_load(loader_element) {
    jQuery(loader_element).html('<div class="main-thecube"><div class="sk-circle"><div class="sk-circle1 sk-child"></div><div class="sk-circle2 sk-child"></div><div class="sk-circle3 sk-child"></div><div class="sk-circle4 sk-child"></div><div class="sk-circle5 sk-child"></div><div class="sk-circle6 sk-child"></div><div class="sk-circle7 sk-child"></div><div class="sk-circle8 sk-child"></div><div class="sk-circle9 sk-child"></div><div class="sk-circle10 sk-child"></div><div class="sk-circle11 sk-child"></div><div class="sk-circle12 sk-child"></div></div></div>');

}
/**
 * end show loader before load data
 */
function automobile_data_loader_remove(loader_element) {
    jQuery(loader_element).html('');
}

function chosen_selectionbox() {
    "use strict";
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

/*
 * End chosen selection box
 */
/**
 * load resize map
 */

function resizeMap() {
    google.maps.event.trigger(map, 'resize');
    map.setZoom(map.getZoom());
}
function automobile_show_form_row(field_val) {
    if (field_val == 'box') {
        jQuery('automobile_box_row').show();
    } else {
        jQuery('automobile_box_row').hide();
    }
}



var ppp = 3; // Post per page
var pageNumber = 1;
function load_posts() {
    pageNumber++;
    var str = '&cat=' + cat + '&pageNumber=' + pageNumber + '&ppp=' + ppp + '&action=more_post_ajax';
    $.ajax({
        type: "POST",
        dataType: "html",
        url: ajax_posts.ajaxurl,
        data: str,
        success: function (data) {
            var $data = $(data);
            if ($data.length) {
                $("#ajax-posts").append($data);
                $("#more_posts").attr("disabled", false);
            } else {
                $("#more_posts").attr("disabled", true);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $loader.html(jqXHR + " :: " + textStatus + " :: " + errorThrown);
        }

    });
    return false;
}
/*
 $("#     ").on("click", function () { // When btn is pressed.
 $("#more_posts").attr("disabled", true); // Disable the button, temp.
 load_posts();
 });
 */




jQuery(document).ready(function ($) {
    jQuery(".sub-menu").parent("li").addClass("parentIcon");
    jQuery(document).on('click', 'a.nav-button', function (event) {
        $(".admin-navigtion").toggleClass("navigation-small");
    });
    jQuery(document).on('click', 'a.nav-button', function (event) {
        $(".inner").toggleClass("shortnav");
    });

    jQuery(document).on('click', '#plugin-options .admin-navigtion > ul > li > a', function (event) {
        var a = $(this).next('ul')
        $(".admin-navigtion > ul > li > a").not($(this)).removeClass("changeicon")
        $(".admin-navigtion > ul > li ul").not(a).slideUp();
        $(this).next('.sub-menu').slideToggle();
        $(this).toggleClass('changeicon');
    });

});

function show_hide(id) {
    var link = id.replace('#', '');
    jQuery('.horizontal_tab').fadeOut(0);
    jQuery('#' + link).fadeIn(400);
}

function toggleDiv(id) {
    jQuery('.col2').children().hide();
    jQuery(id).show();
    location.hash = id + "-show";
    var link = id.replace('#', '');
    jQuery('.categoryitems li').removeClass('active');
    jQuery(".menuheader.expandable").removeClass('openheader');
    jQuery(".categoryitems").hide();
    jQuery("." + link).addClass('active');
    jQuery("." + link).parent("ul").show().prev().addClass("openheader");
}


jQuery(document).ready(function () {
    jQuery(".categoryitems").hide();
    jQuery(".categoryitems:first").show();
    jQuery(".menuheader:first").addClass("openheader");
    jQuery(".menuheader").on('click', function (event) {
        if (jQuery(this).hasClass('openheader')) {
            jQuery(".menuheader").removeClass("openheader");
            jQuery(this).next().slideUp(200);
            return false;
        }
        jQuery(".menuheader").removeClass("openheader");
        jQuery(this).addClass("openheader");
        jQuery(".categoryitems").slideUp(200);
        jQuery(this).next().slideDown(200);
        return false;
    });

    var hash = window.location.hash.substring(1);
    var id = hash.split("-show")[0];
    if (id) {
        jQuery('.col2').children().hide();
        jQuery("#" + id).show();
        jQuery('.categoryitems li').removeClass('active');
        jQuery(".menuheader.expandable").removeClass('openheader');
        jQuery(".categoryitems").hide();
        jQuery("#" + id).find('.main_tab').show();
        jQuery("." + id).addClass('active');
        jQuery("." + id).parent("ul").slideDown(300).prev().addClass("openheader");
    }
});

function social_icon_del(id) {
    jQuery("#del_" + id).remove();
    jQuery("#" + id).remove();
}

function automobile_var_google_font_att(admin_url, att_id, id) {

    var $ = jQuery;
    if (att_id != "") {
        jQuery('#' + id).parent().next().remove(0);
        jQuery('#' + id).parent().parent().append('<i style="font-size:20px;color:#ff6363;" class="icon-spinner icon-spin"></i>');
        jQuery('#' + id).parent().parent().css('text-align', 'center');
        jQuery('#' + id).parent().hide(0);
        var dataString = 'index=' + att_id + '&id=' + id +
                '&action=automobile_var_get_google_font_attributes';
        jQuery.ajax({
            type: "POST",
            url: admin_url,
            data: dataString,
            success: function (response) {
                jQuery('#' + id).parent().show(0);
                jQuery('#' + id).parent().html(response);
                jQuery('#' + id).parent().next().remove(0);

            }
        });
        //return false;
    }
}

var counter_social_network = 0;
function automobile_var_add_social_icon(admin_url) {
    counter_social_network++;
    var social_net_icon_path = jQuery("#automobile_var_social_icon_input").val();
    var social_net_awesome = jQuery(".selected-icon i").attr("class");
    var social_net_url = jQuery("#social_net_url_input").val();
    var social_net_tooltip = jQuery("#social_net_tooltip_input").val();
    var social_font_awesome_color = jQuery("#social_font_awesome_color").val();
    if (social_net_url != "" && (social_net_icon_path != "" || social_net_awesome != "")) {
        var dataString = 'social_net_icon_path=' + social_net_icon_path +
                '&social_net_awesome=' + social_net_awesome +
                '&social_net_url=' + social_net_url +
                '&social_net_tooltip=' + social_net_tooltip +
                '&counter_social_network=' + counter_social_network +
                '&social_font_awesome_color=' + social_font_awesome_color +
                '&action=automobile_var_add_social_icon';
        jQuery.ajax({
            type: "POST",
            url: admin_url,
            data: dataString,
            success: function (response) {
                jQuery("#social_network_area").append(response);
                jQuery(".social-area").show(200);
                jQuery("#automobile_var_social_icon_input,#social_net_awesome_input,#social_net_url_input,#social_net_tooltip_input").val("");
                jQuery("#social_font_awesome_color").val("");
            }
        });
        //return false;
    }
}
function select_bg(layout, value, theme_url, admin_url) {
    var $ = jQuery;
    jQuery('input[name="' + layout + '"]').on('click', function () {
        jQuery(this).parent().parent().find(".check-list").removeClass("check-list");
        jQuery(this).siblings("label").children("#check-list").addClass("check-list");
        jQuery(this).addClass('selected').siblings().removeClass('selected');
    });
    if (value == 'boxed' && layout == 'automobile_var_layout') {
        jQuery('.horizontal_tabs,.main_tab').show();
    } else if (value == 'full_width' && layout == 'automobile_var_layout') {
        jQuery('.horizontal_tabs,.main_tab').hide();
    }

    jQuery('input[name="' + layout + '"]').on('click', function () {
        jQuery(this).parent().parent().find(".check-list").removeClass("check-list");
        jQuery(this).siblings("label").children("#check-list").addClass("check-list");
        jQuery(this).addClass('selected').siblings().removeClass('selected');
    });
    if (value == 'boxed' && layout == 'automobile_layout') {
        jQuery('.horizontal_tabs,.main_tab').show();
    } else if (value == 'full_width' && layout == 'automobile_layout') {
        jQuery('.horizontal_tabs,.main_tab').hide();
        jQuery('#automobile_bg_color').hide();

    }


}

function automobile_var_div_remove(id) {
    "use strict";
    jQuery("#" + id).remove();
}

var counter_sidebar = 0;
function add_sidebar() {
    counter_sidebar++;
    var sidebar_input = jQuery("#sidebar_input").val();
    if (sidebar_input != "") {
        jQuery("#sidebar_area").append('<tr id="' + counter_sidebar + '"> \
                            <td><input type="hidden" name="automobile_var_sidebar[]" value="' + sidebar_input + '" />' + sidebar_input + '</td> \
                            <td class="centr"> <a class="remove-btn" onclick="javascript:return confirm(\'Are you sure! You want to delete this\')" href="javascript:automobile_var_div_remove(' + counter_sidebar + ')"><i class="icon-times"></i></a> </td> \
                        </tr>');
        jQuery("#sidebar_input").val("");
        jQuery(".sidebar-area").slideDown();
    }
}


var counter_footer_sidebar = 0;

function add_footer_sidebar() {
    "use strict";
    counter_footer_sidebar++;
    var footer_sidebar_input = jQuery("#footer_sidebar_input").val();
    var footer_sidebar_width = jQuery("#footer_sidebar_width").val();

    if (footer_sidebar_input != "" || footer_sidebar_width != "") {
        jQuery("#footer_sidebar_area").append('<tr id="' + counter_footer_sidebar + '"> \
									<td><input type="hidden" name="automobile_var_footer_sidebar[]" value="' + footer_sidebar_input + '" />' + footer_sidebar_input + '</td> \
									<td><input type="hidden" name="automobile_var_footer_width[]" value="' + footer_sidebar_width + '" />' + footer_sidebar_width + '</td> \
									<td class="centr"> <a class="remove-btn" onclick="javascript:return confirm(\'Are you sure! You want to delete this\')" href="javascript:automobile_div_remove(' + counter_footer_sidebar + ')"><i class="icon-times"></i></a> </td> \
								</tr>');
        jQuery("#footer_sidebar_input").val("");
        jQuery(".footer_sidebar-area").slideDown();
    }
}

// set header bg options

function automobile_var_set_headerbg(value) {

    if (value == 'absolute') {

        jQuery('#automobile_var_headerbg_options_header,#automobile_var_headerbg_image_upload,#automobile_var_headerbg_color_color,#automobile_var_headerbg_slider_1,#automobile_var_headerbg_image_box').show();
        if (jQuery('#automobile_var_headerbg_options').val() == 'automobile_var_rev_slider') {
            jQuery('#automobile_var_headerbg_slider_1').show();
            jQuery('#automobile_var_headerbg_image_upload,#automobile_var_headerbg_color_color,#tab-header-options #automobile_var_headerbg_image_box').hide();
        } else if (jQuery('#automobile_var_headerbg_options').val() == 'automobile_var_bg_image_color') {
            jQuery('#automobile_var_headerbg_slider_1').hide();
            jQuery('#automobile_var_headerbg_image_upload,#automobile_var_headerbg_color_color,#tab-header-options #automobile_var_headerbg_image_box').show();
        } else {
            jQuery('#automobile_var_headerbg_slider_1').hide();
            jQuery('#automobile_var_headerbg_image_upload,#automobile_var_headerbg_color_color,#tab-header-options #automobile_var_headerbg_image_box,#automobile_var_headerbg_slider_1').hide();
        }

    } else if (value == 'relative') {

        jQuery('#automobile_var_headerbg_options_header,#automobile_var_headerbg_image_upload,#automobile_var_headerbg_color_color,#automobile_var_headerbg_slider_1,#tab-header-options #automobile_var_headerbg_image_box').hide();

    } else if (value == 'automobile_var_rev_slider') {

        jQuery('#automobile_var_headerbg_slider_1').show();

        jQuery('#automobile_var_headerbg_image_upload,#automobile_var_headerbg_color_color,#tab-header-options #automobile_var_headerbg_image_box').hide();

    } else if (value == 'automobile_var_bg_image_color') {

        jQuery('#automobile_var_headerbg_slider_1').hide();

        jQuery('#automobile_var_headerbg_image_upload,#automobile_var_headerbg_color_color,#tab-header-options #automobile_var_headerbg_image_box').show();

    } else if (value == 'none') {

        jQuery('#automobile_var_headerbg_slider_1').hide();

        jQuery('#automobile_var_headerbg_image_upload,#automobile_var_headerbg_color_color,#tab-header-options #automobile_var_headerbg_image_box,#automobile_var_headerbg_slider_1').hide();

    }

}

function automobile_var_banner_type_toggle(type, id) {
    if (type == 'image') {
        jQuery("#automobile_var_banner_image_field_" + id).show();
        jQuery("#automobile_var_banner_image_value_" + id).show();
        jQuery("#automobile_var_banner_code_field_" + id).hide();
        jQuery("#automobile_var_banner_code_value_" + id).hide();
    } else if (type == 'code') {
        jQuery("#automobile_var_banner_image_field_" + id).hide();
        jQuery("#automobile_var_banner_image_value_" + id).hide();
        jQuery("#automobile_var_banner_code_field_" + id).show();
        jQuery("#automobile_var_banner_code_value_" + id).show();
    }
}

function captcha_reload(admin_url, captcha_id) {
    "use strict";
    var dataString = '&action=captcha_reload&captcha_id=' + captcha_id;
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        dataType: 'html',
        success: function (data) {
            jQuery("#" + captcha_id + "_div").html(data);

        }
    });
}


function automobile_var_addinventory_to_wish(admin_url, post_id, obj, view) {
    "use strict";
    var dataString = 'post_id=' + post_id + '&view='+ view +'&action=automobile_var_addinventory_to_user';
    var value            = jQuery(obj).attr('value');
    var shortlist        = jQuery(obj).attr('shortlist');
    var shortlisted      = jQuery(obj).attr('shortlisted');
    var add_shortlist    = jQuery(obj).attr('add_shortlist');
    var remove_shortlist = jQuery(obj).attr('remove_shortlist');
    if( view == 'dealer' ){
        if( value == '0' ) {
            jQuery(obj).html('<span><i class="icon-spinner8 icon-spin"></i></span>'+ shortlist +'');
        }else if( value == '1' ){
            jQuery(obj).html('<span><i class="icon-spinner8 icon-spin"></i></span>'+ shortlisted +'');
        }
    } else if( view == 'view1' || view == 'view2' || view == 'view3' || view == 'inv_cats' ){
        if( value == '0' ) {
            jQuery(obj).html('<i class="icon-spinner8"></i>'+ shortlist +'');
        }else if( value == '1' ){
            jQuery(obj).html('<i class="icon-spinner8"></i>'+ shortlisted +'');
        }
    }else{
        jQuery(obj).html('<i class="icon-spinner8 icon-spin"></i>');
    }
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {
            jQuery(obj).html(response);
            jQuery(obj).attr("onclick", "automobile_var_removeinventory_to('" + admin_url + "','" + post_id + "',this, '','"+ view +"')");
            if( value == '0' ) {
                jQuery(obj).attr("value", "1");
                jQuery(obj).attr("data-original-title", remove_shortlist);
            }else if( value == '1' ){
                jQuery(obj).attr("value", "0");
                jQuery(obj).attr("data-original-title", add_shortlist);
            }
            // automobile_job_shortlist_load(admin_url);
        }
    });
    return false;
}

/**
 * Remove Wishlist Function
 */
function automobile_var_removeinventory_to(admin_url, post_id, obj, removed_div_class, view) {
    "use strict";
    removed_div_class = removed_div_class || '';
    var dataString = 'post_id=' + post_id + '&view='+ view +'&action=automobile_var_removeinventory_to_user';
    var value            = jQuery(obj).attr('value');
    var shortlist        = jQuery(obj).attr('shortlist');
    var shortlisted      = jQuery(obj).attr('shortlisted');
    var add_shortlist    = jQuery(obj).attr('add_shortlist');
    var remove_shortlist = jQuery(obj).attr('remove_shortlist');
    if( view == 'dealer' ){
        if( value == '0' ) {
            jQuery(obj).html('<span><i class="icon-spinner8 icon-spin"></i></span>'+ shortlist +'');
        }else if( value == '1' ){
            jQuery(obj).html('<span><i class="icon-spinner8 icon-spin"></i></span>'+ shortlisted +'');
        }
    } else if( view == 'view1' || view == 'view2' || view == 'view3' || view == 'inv_cats' ){
        if( value == '0' ) {
            jQuery(obj).html('<i class="icon-spinner8"></i>'+ shortlist +'');
        }else if( value == '1' ){
            jQuery(obj).html('<i class="icon-spinner8"></i>'+ shortlisted +'');
        }
    }else{
        jQuery(obj).html('<i class="icon-spinner8 icon-spin"></i>');
    }
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {
            if (removed_div_class != '') {  // only use in dashboard and remove row for this class
                jQuery(removed_div_class).remove();
            } else {
                jQuery(obj).html(response);
                jQuery(obj).attr("onclick", "automobile_var_addinventory_to_wish('" + admin_url + "','" + post_id + "',this,'" + view + "')");
                if( value == '0' ) {
                    jQuery(obj).attr("value", "1");
                    jQuery(obj).attr("data-original-title", remove_shortlist);
                }else if( value == '1' ){
                    jQuery(obj).attr("value", "0");
                    jQuery(obj).attr("data-original-title", add_shortlist);
                }
            }
            // automobile_job_shortlist_load(admin_url);
        }
    });
    return false;
}

/*
 * 
 * inventory contact us
 */
"use strict";
$('#inventory_contactus').click(function (event) {
    event.preventDefault();
    jQuery('.cs-inventory-contact-detail #main-cs-loader').html('<i class="icon-spinner8 icon-spin"></i>');
    // automobile_data_loader_load('.cs-inventory-contact-detail #main-cs-loader');

    var ajaxurl = jQuery(".cs-inventory-contact-detail").data('adminurl');
    var inventoryid = jQuery(".profile-contact-btn").data('inventoryid');

    var captcha_id = jQuery(".cs-inventory-contact-detail").data('cap');

    jQuery.ajax({
        type: "POST",
        url: ajaxurl,
        dataType: "html",
        data: $('#ajaxcontactform').serialize() + "&inventoryid=" + inventoryid + "&action=ajaxcontact_send_mail",
        success: function (response) {
            var response_data = response.split("|");
            jQuery("#ajaxcontactemail").removeClass('has_error');
            jQuery("#ajaxcontactname").removeClass('has_error');
            jQuery("#ajaxcontactcontents").removeClass("has_error");

            var pattern = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
            if (jQuery("#ajaxcontactname").val() == '') {
                jQuery("#ajaxcontactname").addClass('has_error');
            } else
            if (!pattern.test(jQuery("#ajaxcontactemail").val())) {
                jQuery("#ajaxcontactemail").addClass('has_error');
            } else
            if (jQuery("#ajaxcontactcontents").val().length < 35) {
                jQuery("#ajaxcontactcontents").addClass('has_error');
            }
            var error_container = '';
            if (response_data[1] == 1) {
                error_container = '<div class="alert alert-danger"><button aria-hidden="true" data-dismiss="alert" type="button" class="close">&times;</button><p><i class="icon-warning4"></i>' + response_data[0] + '</p></div>';
                jQuery("#ajaxcontact-response").html(error_container);
            } else {
                error_container = '<div class="alert alert-success"><button aria-hidden="true" data-dismiss="alert" type="button" class="close">&times;</button><p>' + response_data[0] + '</p></div>';
                jQuery("#ajaxcontact-response").html(error_container);

            }

            jQuery('.cs-inventory-contact-detail #main-cs-loader').html('');

        }
    });
    return false;
});


/*
 * 
 * inquiry info contact us
 */
"use strict";
$('#info_contactus').click(function (event) {
    event.preventDefault();
    jQuery('.cs-info-contact-detail .status-message').addClass('cs-spinner');
    jQuery('.cs-info-contact-detail .status-message').html('<i class="icon-spinner8 icon-spin"></i>');
    // automobile_data_loader_load('.cs-info-contact-detail #main-info-loader');

    var ajaxurl = jQuery(".cs-info-contact-detail").data('adminurl');
    var infoid = jQuery(".profile-contact-btn").data('inventoryid');

    var captcha_id = jQuery(".cs-info-contact-detail").data('cap');
    jQuery.ajax({
        type: "POST",
        url: ajaxurl,
        dataType: "html",
        data: $('#ajaxinfoform').serialize() + "&infoid=" + infoid + "&action=ajaxinfo_send_mail",
        success: function (response) {
	    jQuery('.cs-info-contact-detail .status-message').removeClass('cs-spinner');
            var response_data = response.split("|");
            jQuery("#ajaxinfoemail").removeClass('has_error');
            jQuery("#ajaxinfophone").removeClass('has_error');
            jQuery("#ajaxinfoname").removeClass('has_error');
            jQuery("#ajaxinfocontents").removeClass("has_error");

            var pattern = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
            if (jQuery("#ajaxinfoname").val() == '') {
                jQuery("#ajaxinfoname").addClass('has_error');
            } else
            if (!pattern.test(jQuery("#ajaxinfoemail").val())) {
                jQuery("#ajaxinfoemail").addClass('has_error');
            } else
            if (jQuery("#ajaxinfocontents").val().length < 35) {
                jQuery("#ajaxinfocontents").addClass('has_error');
            } else
            if (jQuery("#ajaxinfophone").val().length < 35) {
                jQuery("#ajaxinfophone").addClass('has_error');
            }
            var error_container = '';
            if (response_data[1] == 1) {
                error_container = '<div class="alert alert-danger"><button aria-hidden="true" data-dismiss="alert" type="button" class="close">&times;</button><p><i class="icon-warning4"></i>' + response_data[0] + '</p></div>';
                jQuery("#ajaxinfo-response").html(error_container);
            } else {
                error_container = '<div class="alert alert-success"><button aria-hidden="true" data-dismiss="alert" type="button" class="close">&times;</button><p></i>' + response_data[0] + '</p></div>';
                jQuery("#ajaxinfo-response").html(error_container);
                captcha_reload(ajaxurl, captcha_id);
            }

            jQuery('.cs-info-contact-detail #main-info-loader').html('');


        }
    });
    return false;
});


/*
 * 
 * Test drive contact us
 */
"use strict";
$('#test_drive').click(function (event) {
    //alert('test atest');
    event.preventDefault();
    //jQuery('.cs-test-detail #main-test-loader').html('<i class="icon-spinner8 icon-spin"></i>');
	jQuery('.cs-test-detail .status-message').addClass('cs-spinner');
    jQuery('.cs-test-detail .status-message').html('<i class="icon-spinner8 icon-spin"></i>');
    // automobile_data_loader_load('.cs-test-detail #main-test-loader');

    var ajaxurl = jQuery(".cs-test-detail ").data('adminurl');
    var testid = jQuery(".profile-contact-btn").data('inventoryid');

    var captcha_id = jQuery(".cs-test-detail ").data('cap');

    jQuery.ajax({
        type: "POST",
        url: ajaxurl,
        dataType: "html",
        data: $('#ajaxtestform').serialize() + "&testid=" + testid + "&action=ajax_send_mail",
        success: function (response) {
			jQuery('.cs-test-detail .status-message').removeClass('cs-spinner');
            var response_data = response.split("|");
            jQuery("#ajaxemail").removeClass('has_error');
            jQuery("#ajaxname").removeClass('has_error');
            jQuery("#ajaxcontents").removeClass("has_error");
            jQuery("#ajaxtime").removeClass("has_error");

            var pattern = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
            if (jQuery("#ajaxname").val() == '') {
                jQuery("#ajaxname").addClass('has_error');
            } else
            if (!pattern.test(jQuery("#ajaxemail").val())) {
                jQuery("#ajaxemail").addClass('has_error');
            } else
            if (jQuery("#ajaxcontents").val().length < 35) {
                jQuery("#ajaxcontents").addClass('has_error');
            } else
            if (jQuery("#ajaxtime").val().length < 35) {
                jQuery("#ajaxtime").addClass('has_error');
            }
            var error_container = '';
            if (response_data[1] == 1) {
                error_container = '<div class="alert alert-danger"><button aria-hidden="true" data-dismiss="alert" type="button" class="close">&times;</button><p><i class="icon-warning4"></i>' + response_data[0] + '</p></div>';
                jQuery("#ajaxtest-response").html(error_container);
            } else {
                error_container = '<div class="alert alert-success"><button aria-hidden="true" data-dismiss="alert" type="button" class="close">&times;</button><p><i class="icon-warning4"></i>' + response_data[0] + '</p></div>';
                jQuery("#ajaxtest-response").html(error_container);
                captcha_reload(ajaxurl, captcha_id);
            }

            jQuery('.cs-test-detail  #main-test-loader').html('');

        }
    });
    return false;
});

/*
 * 
 * offer drive contact us
 */
"use strict";
$('#offerform').click(function (event) {
    //alert('test atest');
    event.preventDefault();
    //jQuery('.cs-offer-detail #main-offer-loader').html('<i class="icon-spinner8 icon-spin"></i>');
	jQuery('.cs-offer-detail .status-message').addClass('cs-spinner');
    jQuery('.cs-offer-detail .status-message').html('<i class="icon-spinner8 icon-spin"></i>');
    // automobile_data_loader_load('.cs-offer-detail #main-offer-loader');

    var ajaxurl = jQuery(".cs-offer-detail ").data('adminurl');
    var offerid = jQuery(".profile-contact-btn").data('inventoryid');

    var captcha_id = jQuery(".cs-offer-detail ").data('cap');

    jQuery.ajax({
        type: "POST",
        url: ajaxurl,
        dataType: "html",
        data: $('#ajaxofferform').serialize() + "&offerid=" + offerid + "&action=ajaxoffer_send_mail",
        success: function (response) {
			jQuery('.cs-offer-detail .status-message').removeClass('cs-spinner');
            var response_data = response.split("|");
            jQuery("#ajaxofferemail").removeClass('has_error');
            jQuery("#ajaxofferphone").removeClass('has_error');
            jQuery("#ajaxoffername").removeClass('has_error');
            jQuery("#ajaxoffercontents").removeClass("has_error");
            jQuery("#ajaxofferprice").removeClass("has_error");
            jQuery("#ajaxofferfinancing").removeClass("has_error");

            var pattern = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
            if (jQuery("#ajaxoffername").val() == '') {
                jQuery("#ajaxoffername").addClass('has_error');
            } else
            if (!pattern.test(jQuery("#ajaxofferemail").val())) {
                jQuery("#ajaxofferemail").addClass('has_error');
            } else
            if (jQuery("#ajaxoffercontents").val().length < 35) {
                jQuery("#ajaxoffercontents").addClass('has_error');
            } else
            if (jQuery("#ajaxofferprice").val().length < 35) {
                jQuery("#ajaxofferprice").addClass('has_error');
            } else
            if (jQuery("#ajaxofferfinancing").val().length < 35) {
                jQuery("#ajaxofferfinancing").addClass('has_error');
            } else
            if (jQuery("#ajaxofferphone").val().length < 35) {
                jQuery("#ajaxofferphone").addClass('has_error');
            }
            var error_container = '';
            if (response_data[1] == 1) {
                error_container = '<div class="alert alert-danger"><button aria-hidden="true" data-dismiss="alert" type="button" class="close">&times;</button><p><i class="icon-warning4"></i>' + response_data[0] + '</p></div>';
                jQuery("#ajaxoffer-response").html(error_container);
            } else {
                error_container = '<div class="alert alert-success"><button aria-hidden="true" data-dismiss="alert" type="button" class="close">&times;</button><p><i class="icon-warning4"></i>' + response_data[0] + '</p></div>';
                jQuery("#ajaxoffer-response").html(error_container);
                captcha_reload(ajaxurl, captcha_id);
            }

            jQuery('.cs-offer-detail  #main-offer-loader').html('');

        }
    });
    return false;
});

/*
 * 
 * mail a friend drive contact us
 */
"use strict";
$('#mailfriend').click(function (event) {
    //alert('test atest');
    event.preventDefault();
    //jQuery('.cs-mail-detail #main-friend-loader').html('<i class="icon-spinner8 icon-spin"></i>');
	jQuery('.cs-mail-detail .status-message').addClass('cs-spinner');
    jQuery('.cs-mail-detail .status-message').html('<i class="icon-spinner8 icon-spin"></i>');
    // automobile_data_loader_load('.cs-mail-detail #main-friend-loader');

    var ajaxurl = jQuery(".cs-mail-detail ").data('adminurl');
    var mailid = jQuery(".profile-contact-btn").data('inventoryid');

    var captcha_id = jQuery(".cs-mail-detail ").data('cap');

    jQuery.ajax({
        type: "POST",
        url: ajaxurl,
        dataType: "html",
        data: $('#ajaxfriendform').serialize() + "&mailid=" + mailid + "&action=ajaxfriend_send_mail",
        success: function (response) {
			jQuery('.cs-mail-detail .status-message').removeClass('cs-spinner');
            var response_data = response.split("|");
            jQuery("#ajaxmail").removeClass('has_error');
            jQuery("#ajaxmailname").removeClass('has_error');
            jQuery("#ajaxmailcontents").removeClass("has_error");
            jQuery("#ajaxfriendmail").removeClass("has_error");
            jQuery("#ajaxmailphone").removeClass("has_error");

            var pattern = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
            if (jQuery("#ajaxmailname").val() == '') {
                jQuery("#ajaxmailname").addClass('has_error');
            } else
            if (!pattern.test(jQuery("#ajaxmail").val())) {
                jQuery("#ajaxmail").addClass('has_error');
            } else
            if (jQuery("#ajaxmailcontents").val().length < 35) {
                jQuery("#ajaxmailcontents").addClass('has_error');
            } else
            if (jQuery("#ajaxfriendmail").val().length < 35) {
                jQuery("#ajaxfriendmail").addClass('has_error');
            } else
            if (jQuery("#ajaxmailphone").val().length < 35) {
                jQuery("#ajaxmailphone").addClass('has_error');
            }
            var error_container = '';
            if (response_data[1] == 1) {
                error_container = '<div class="alert alert-danger"><button aria-hidden="true" data-dismiss="alert" type="button" class="close">&times;</button><p><i class="icon-warning4"></i>' + response_data[0] + '</p></div>';
                jQuery("#ajaxmail-response").html(error_container);
            } else {
                error_container = '<div class="alert alert-success"><button aria-hidden="true" data-dismiss="alert" type="button" class="close">&times;</button><p><i class="icon-warning4"></i>' + response_data[0] + '</p></div>';
                jQuery("#ajaxmail-response").html(error_container);
                captcha_reload(ajaxurl, captcha_id);
            }

            jQuery('.cs-mail-detail  #main-friend-loader').html('');

        }
    });
    return false;
});


jQuery(document).ready(function() {
    jQuery("#vehicle_price, #interest_rate, #down_payment, #ajaxofferprice").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter, decimal point, period, comma, $ and £
        if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190, 188, 52, 86]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
});
jQuery(document).ready(function() {
    jQuery("#ajaxcontactphone, #ajaxinfophone, #ajaxphone, #ajaxofferphone, #ajaxmailphone, #ajaxdealerphone, .register_phone").keydown(function (e) {
        // Allow: delete, backspace, tab, escape, enter, (, ), +, space and -
        if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13, 57, 48, 61, 32, 173]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
});