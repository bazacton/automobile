function theme_option_save(admin_url, theme_url) {
    jQuery(".outerwrapp-layer,.loading_div").fadeIn(100);
    function newValues() {
        var serializedValues = jQuery("#frm input,#frm select,#frm textarea[name!=automobile_var_export_theme_options]").serialize();
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
            jQuery(".outerwrapp-layer").delay(100).fadeOut(100)
            window.location.reload(true);
            slideout();
        }
    });
    //return false;
}

jQuery(document).ready(function ($) {
    $('.bg_color').wpColorPicker();
    $('[data-toggle="popover"]').popover();
});

function automobile_var_rest_all_options(admin_url) {
    "use strict";

    var var_confirm = confirm("You current theme options will be replaced with the default theme activation options.");
    if (var_confirm == true) {
        var dataString = 'action=theme_option_rest_all';
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
    //return false;
}

function automobile_var_set_filename(file_value, file_path) {
    "use strict";
    jQuery(".backup_action_btns").find('input[type="button"]').attr('data-file', file_value);
    jQuery(".backup_action_btns").find('> a').attr('href', file_path + file_value);
    jQuery(".backup_action_btns").find('> a').attr('download', file_value);
}

function automobile_var_backup_generate(admin_url) {
    "use strict";
    jQuery(".outerwrapp-layer,.loading_div").fadeIn(100);

    var dataString = 'action=automobile_var_settings_backup_generate';
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

jQuery('.backup_generates_area').on('click', '#cs-backup-delte', function () {

    var var_confirm = confirm("This action will delete your selected Backup File. Are you want to continue?");
    if (var_confirm == true) {
        jQuery(".outerwrapp-layer,.loading_div").fadeIn(100);

        var admin_url = jQuery('.backup_generates_area').data('ajaxurl');
        var file_name = jQuery(this).data('file');

        var dataString = 'file_name=' + file_name + '&action=automobile_var_backup_file_delete';
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

jQuery('.backup_generates_area').on('click', '#cs-backup-restore, #cs-backup-url-restore', function () {

    jQuery(".outerwrapp-layer,.loading_div").fadeIn(100);

    var admin_url = jQuery('.backup_generates_area').data('ajaxurl');
    var file_name = jQuery(this).data('file');

    var dataString = 'file_name=' + file_name + '&action=automobile_var_backup_file_restore';

    if (typeof (file_name) === 'undefined') {

        var file_name = jQuery('#bkup_import_url').val();

        var dataString = 'file_name=' + file_name + '&file_path=yes&action=automobile_var_backup_file_restore';
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
    //return false;
});

function automobile_var_remove_image(id) {
    var $ = jQuery;
    $('#' + id).val('');
    $('#' + id + '_img_div').hide();
}

jQuery(document).ready(function ($) {
    jQuery(".sub-menu").parent("li").addClass("parentIcon");
    jQuery(document).on('click', 'a.nav-button', function (event) {
        $(".admin-navigtion").toggleClass("navigation-small");
    });
    jQuery(document).on('click', 'a.nav-button', function (event) {
        $(".inner").toggleClass("shortnav");
    });
    jQuery(document).on('click', '#frm .admin-navigtion > ul > li > a', function (event) {
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
    if (link == 'custom_image_tab') {
        jQuery('#custom_image_position').fadeIn(400);
    }

}

function toggleDiv(id) {
    jQuery('.col2').children().hide();
    jQuery(id).show();
    jQuery(id + " .main_tab").show();
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
    jQuery(document).on("click", ".menuheader", function (event) {
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

function ads_del(id) {
    jQuery("#del_" + id).remove();
    jQuery("#" + id).remove();
}

function automobile_var_banner_type_toggle(type, id) {
    if (type == 'image') {
        jQuery("#ads_image" + id).show();
        jQuery("#ads_code" + id).hide();
    } else if (type == 'code') {
        jQuery("#ads_image" + id).hide();
        jQuery("#ads_code" + id).show();
    }
}
function banner_widget_toggle(view, id) {
    if (view == "random") {
        jQuery(".banner_style_field_" + id).show();
        jQuery(".banner_code_field_" + id).hide();
    } else if (view == "single") {
        jQuery(".banner_style_field_" + id).hide();
        jQuery(".banner_code_field_" + id).show();
    }
}

function automobile_var_google_font_att(admin_url, att_id, id) {

    var $ = jQuery;
    if (att_id != "") {
        jQuery('#' + id).parent().next().remove(0);
        jQuery('#' + id).parent().parent().append('<i style="font-size:20px;color:#ff6363;" class="icon-spinner icon-spin"></i>');
        //jQuery('#' + id).parent().parent().css('text-align', 'center');
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


var counter_banner = 0;
function  automobile_var_add_banner(admin_url) {
    counter_banner++;
    var image_path = jQuery('#automobile_var_banner_field_image').val();

    var banner_title_input = jQuery("#banner_title_input").val();
    var banner_style_input = jQuery("#banner_style_input").val();
    var banner_type_input = jQuery("#banner_type_input").val();
    var banner_field_url_input = jQuery("#banner_field_url_input").val();
    var banner_target_input = jQuery("#banner_target_input").val();
    var adsense_code_input = jQuery("#adsense_code_input").val();

    if (banner_style_input != "") {
        var dataString = 'image_path=' + image_path +
                '&banner_title_input=' + banner_title_input +
                '&banner_style_input=' + banner_style_input +
                '&banner_type_input=' + banner_type_input +
                '&banner_field_url_input=' + banner_field_url_input +
                '&banner_target_input=' + banner_target_input +
                '&counter_banner=' + counter_banner +
                '&adsense_code_input=' + adsense_code_input +
                '&action=automobile_var_ads_banner';
        jQuery.ajax({
            type: "POST",
            url: admin_url,
            data: dataString,
            success: function (response) {
                jQuery("#banner_area").append(response);
                jQuery(".social-area").show(200);
                jQuery("#automobile_var_banner_field_image,#banner_title_input,#banner_field_url_input,#adsense_code_input").val("");
                jQuery("#banner_style_input").val("image");
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
    jQuery(document).on('click', 'input[name="' + layout + '"]', function () {
        jQuery(this).parent().parent().find(".check-list").removeClass("check-list");
        jQuery(this).siblings("label").children("#check-list").addClass("check-list");
        jQuery(this).addClass('selected').siblings().removeClass('selected');
    });
    if (value == 'boxed' && layout == 'automobile_var_layout') {
        jQuery('.horizontal_tabs,.main_tab').show();
        jQuery('.main_tab #background_tab').show();
        jQuery('.main_tab #custom_favicon').show();
    } else if (value == 'full_width' && layout == 'automobile_var_layout') {
        jQuery('.horizontal_tabs,.main_tab').hide();
        jQuery('.main_tab #background_tab').hide();
        jQuery('.main_tab #custom_favicon').hide();
    }
    
    jQuery(document).on('click', 'input[name="' + layout + '"]', function () {
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


function popup_over() {
    jQuery('[data-toggle="popover"]').popover({trigger: "hover", placement: "right"});
}
	