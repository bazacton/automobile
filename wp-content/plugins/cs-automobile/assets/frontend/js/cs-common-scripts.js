(function ($) {
    jQuery(document).ajaxComplete(function () {
        set_inventory_layout();
    });
    jQuery(document).ready(function ($) {

        set_inventory_layout();

        if (jQuery('.cs-detail-slider').length != '') {
            jQuery('.cs-detail-slider').slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
            });
        }
    });

    jQuery(document).on('click', '.cs-inv-grid-view', function () {

        var automobile_counter = jQuery(this).parents('.cs-inventories-main-box').data('counter');

        jQuery(".cs-inventories-listing-loader").html('<div class="sk-circle"><div class="sk-circle1 sk-child"></div><div class="sk-circle2 sk-child"></div><div class="sk-circle3 sk-child"></div><div class="sk-circle4 sk-child"></div><div class="sk-circle5 sk-child"></div><div class="sk-circle6 sk-child"></div><div class="sk-circle7 sk-child"></div><div class="sk-circle8 sk-child"></div><div class="sk-circle9 sk-child"></div><div class="sk-circle10 sk-child"></div><div class="sk-circle11 sk-child"></div><div class="sk-circle12 sk-child"></div></div>');
        jQuery('.cs-inventories-listing-loader').show();
        var search_side = jQuery(this).data('search');
        var grid_class = 'col-md-3 col-lg-3';
        if (search_side == 'on') {
            grid_class = 'col-md-4 col-lg-4';
        }

        window.setTimeout(function () {
            if (!jQuery('.auto-listing').hasClass('auto-grid')) {
                if (jQuery('.auto-listing').parent('div').hasClass('col-md-12')) {
                    jQuery('.auto-listing').parent('div').removeClass('col-md-12');
                    jQuery('.auto-listing').parent('div').removeClass('col-lg-12');
                    jQuery('.auto-listing').parent('div').addClass(grid_class);
                }
                jQuery('.auto-listing').addClass('auto-grid');
                $.removeCookie('automobile_inventory_view_' + automobile_counter);
                $.cookie('automobile_inventory_view_' + automobile_counter, 'grid', {expires: 7});
            }
            jQuery(".cs-inventories-listing-loader").html('');
            jQuery('.cs-inventories-listing-loader').hide();
            jQuery('.cs-inv-classic-view').removeClass('active');
            jQuery('.cs-inv-grid-view').addClass('cs-inv-grid-view active');

        }, 1000);

        var automobile_ajaxurl = jQuery('.cs-inventories-main-box').data('ajaxurl');
        var dataString = 'automobile_inventory_view=grid&automobile_counter=' + automobile_counter + '&action=automobile_set_inventory_view';
        jQuery.ajax({
            type: "POST",
            url: automobile_ajaxurl,
            data: dataString,
            dataType: 'json',
            success: function (response) {

            }
        });
    });

    jQuery(document).on('click', '.cs-inv-classic-view', function () {

        var automobile_counter = jQuery(this).parents('.cs-inventories-main-box').data('counter');

        jQuery(".cs-inventories-listing-loader").html('<div class="sk-circle"><div class="sk-circle1 sk-child"></div><div class="sk-circle2 sk-child"></div><div class="sk-circle3 sk-child"></div><div class="sk-circle4 sk-child"></div><div class="sk-circle5 sk-child"></div><div class="sk-circle6 sk-child"></div><div class="sk-circle7 sk-child"></div><div class="sk-circle8 sk-child"></div><div class="sk-circle9 sk-child"></div><div class="sk-circle10 sk-child"></div><div class="sk-circle11 sk-child"></div><div class="sk-circle12 sk-child"></div></div>');
        jQuery('.cs-inventories-listing-loader').show();
        var search_side = jQuery(this).data('search');
        var grid_class_one = 'col-md-3';
        var grid_class = 'col-md-3 col-lg-3';
        if (search_side == 'on') {
            grid_class = 'col-md-4 col-lg-4';
            grid_class_one = 'col-md-4';
        }
        window.setTimeout(function () {

            if (jQuery('.auto-listing').hasClass('auto-grid')) {
                if (jQuery('.auto-listing').parent('div').hasClass(grid_class_one)) {
                    jQuery('.auto-listing').parent('div').removeClass(grid_class);
                    jQuery('.auto-listing').parent('div').addClass('col-md-12 col-lg-12');
                }
                jQuery('.auto-listing').removeClass('auto-grid');
                $.removeCookie('automobile_inventory_view_' + automobile_counter);
                $.cookie('automobile_inventory_view_' + automobile_counter, 'list', {expires: 7});
            }
            jQuery(".cs-inventories-listing-loader").html('');
            jQuery('.cs-inventories-listing-loader').hide();
            jQuery('.cs-inv-grid-view').removeClass('active');
            jQuery('.cs-inv-classic-view').addClass('cs-inv-classic-view active');
        }, 1000);

        var automobile_ajaxurl = jQuery('.cs-inventories-main-box').data('ajaxurl');
        var dataString = 'automobile_inventory_view=classic&automobile_counter=' + automobile_counter + '&action=automobile_set_inventory_view';
        jQuery.ajax({
            type: "POST",
            url: automobile_ajaxurl,
            data: dataString,
            dataType: 'json',
            success: function (response) {

            }
        });
    });

    $(document).on('click', '.automobile_compare_check_add, .cs-btn-compare', function () {
        var _this = $(this);
        var this_id = _this.data('id');
        var this_rand = _this.data('random');
        var automobile_ajaxurl = $('.cs-inventories-main-box').data('ajaxurl');
        var this_ajaxurl = _this.data('ajaxurl');

        var _action = 'check';
        if (_this.hasClass('automobile_compare_check_add')) {
            if (_this.is(":checked")) {
                _action = 'check';
            } else {
                _action = 'uncheck';
            }
        } else {
            _action = _this.attr("data-check");
        }

        var dataString = 'automobile_inventory_id=' + this_id + '&_action=' + _action + '&action=automobile_var_compare_add';
        if (_this.hasClass('automobile_compare_check_add')) {
            $('#cs-compare-msg-box-' + this_rand).html('<div class="cs-compare-loader"><i class="icon-spinner icon-spin"></i></div>');
            //$("#check-list" + this_rand).parent('.cs-checkbox').hide();
        } else {
            _this.find('span').append('<span><i class="icon-spinner icon-spin"></i></span>');
        }

        $.ajax({
            type: "POST",
            url: this_ajaxurl,
            data: dataString,
            dataType: 'json',
            success: function (response) {

                if (response.mark !== 'undefined') {

                    if (_this.hasClass('automobile_compare_check_add')) {
                        $("#check-list" + this_rand).parent('.cs-checkbox').show();
                        //jQuery('#cs-compare-msg-box-' + this_rand).html(response.mark);
                        jQuery('#cs-compare-msg-box-' + this_rand).html('');
                        jQuery('.cs-msg-comparebox').append('<p class="compare-alert" id="cs-msg-p-' + this_rand + '">' + response.mark + '</p>');

                        $('.cs-msg-comparebox').css("right", "10px");
                        setTimeout(function () {
                            $('.cs-msg-comparebox #cs-msg-p-' + this_rand).remove();
                        }, 10000);
                    } else {
                        $('#compare_msg').css("right", "10px");
                        $('#compare_msg').css("display", "block");

                        setTimeout(function () {
                            $('#compare_msg').css("right", "-100%");
                        }, 10000);
                        $('#compare_msg').find('span').html(response.mark);
                        _this.find('span').html(response.compare);
                        var check_val = _this.attr("data-check");

                        if (check_val == 'uncheck') {
                            check_val = 'check';
                        } else {
                            check_val = 'uncheck';
                        }
                        _this.attr('data-check', check_val);

                        //_this.removeAttr('data-check');
                        //_this.removeClass('cs-btn-compare');
                    }
                } else {
                    if (_this.hasClass('automobile_compare_check_add')) {
                        $("#check-list" + this_rand).parent('.cs-checkbox').show();
                        jQuery('#cs-compare-msg-box-' + this_rand).html('Error');
                    } else {
                        _this.find('span').html('Error');
                        _this.removeAttr('data-check');
                        _this.removeClass('cs-btn-compare');
                    }
                }
            }
        });
    });

    $(document).on('click', '.btn-compare-remove', function () {
        $('#compare_msg').css("right", "-100%");
        $('#compare_msg').css("display", "block");
    });
    $(document).on('click', '.btn-compare-remove', function () {
        $(this).parentElement.css("right", "-100%");

    });


    $(document).on('click', '.cs-remove-compare-item', function () {
        var this_id = $(this).data('id');
        var this_type_id = $(this).data('type-id');
        var automobile_ajaxurl = $('.cs-compare').data('ajaxurl');
        var automobile_inv_ids = $('.cs-compare').data('ids');
        var automobile_page_id = $('.cs-compare').data('id');
        var dataString = 'inventory_id=' + this_id + '&type_id=' + this_type_id + '&inv_ids=' + automobile_inv_ids + '&page_id=' + automobile_page_id + '&action=automobile_var_removing_compare';
        $(this).html('<i class="icon-spinner icon-spin"></i>');
        $.ajax({
            type: "POST",
            url: automobile_ajaxurl,
            data: dataString,
            dataType: 'json',
            success: function (response) {
                if (response.url !== 'undefined' && response.url != '') {
                    $('.dev-rem-' + this_id).remove();
                    window.location.href = response.url;
                }
            }
        });
    });

    $(document).on('click', '.cs-listing-filters form input[type="checkbox"]', function () {
        if (typeof ($(this).attr('name')) !== 'undefined') {
            var fieldname = $(this).attr('name');
            var fieldvalue = $(this).attr('value');
            
            //$('.searchform input[name="' + fieldname + '"]').remove();
            if (typeof ($(this).attr('multiselectable')) == 'undefined') {
                $('.searchform input[name="' + fieldname + '"]').remove();
            } else {
                $('.searchform input[value="' + fieldvalue + '"]').remove();
            }
            if ($(this).val() != '') {
                if ($(this).is(':checked')) {
                //if (typeof($(this).attr('checked')) !== 'undefined') {
                    var input = $("<input>")
                            .attr("type", "hidden")
                            .attr("name", $(this).attr('name'))
                            .val($(this).val());
                    $('.searchform').append($(input));
                }
                $(this).parents('form').submit();
            }
        }
    });


    $(document).on('focusout', '.automobile_search_location_field', function () {
        $(".search_keyword").val($(this).val());
        $(".search_keyword").click();
    });

    $(document).on('click', '.search_keyword', function () {
        if (typeof ($(this).attr('name')) !== 'undefined') {
            var fieldname = $(this).attr('name');
            //$('.searchform input[name="' + fieldname + '"]').remove();
            if ($(this).val() != '') {
                var input = $("<input>")
                        .attr("type", "hidden")
                        .attr("name", $(this).attr('name'))
                        .val($(this).val());
                $('.searchform').append($(input));
                //$(this).parents('form').submit();
            }
        } else {
            var fieldname = 'location';
            //$('.searchform input[name="' + fieldname + '"]').remove();
            if ($(this).val() != '') {
                var input = $("<input>")
                        .attr("type", "hidden")
                        .attr("name", 'location')
                        .val($(this).val());
                $('.searchform').append($(input));
                //$(this).parents('form').submit();
            }
        }
    });





    $(document).on('click', '.clear-filters', function () {
        var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname;
        window.location.href = newurl;
    });




    $(document).on('change', '.cs-listing-filters form input[type="hidden"], .cs-listing-filters form input[type="text"], .cs-listing-filters form input[type="search"], .cs-listing-filters form select', function () {
        if ($(this).attr('class').search('slider-slide-range') == -1 || ($(this).attr('class').search('slider-slide-range') != -1 && $(this).attr('class').search('updated-slide-slider') != -1)) {
            if ($(this).attr('class') != 'automobile_search_location_field') {
                if (typeof ($(this).attr('name')) !== 'undefined') {
                    if ($(this).attr('name') == 'inventory_type') {
                        //$('.searchform').html('');
                        $('.cs-select-model').html('');
                        $(".cs-automobile-inv-makes").html('');
                        var input = $("<input>")
                                .attr("type", "hidden")
                                .attr("name", $(this).attr('name'))
                                .val($(this).val());
                        $('.searchform').append($(input));

                        $(this).parents('form').submit();
                    }
                    var fieldname = $(this).attr('name');
                    $('.searchform input[name="' + fieldname + '"]').remove();
                    if ($(this).val() != '') {
                        var input = $("<input>")
                                .attr("type", "hidden")
                                .attr("name", $(this).attr('name'))
                                .val($(this).val());
                        $('.searchform').append($(input));

                        $(this).parents('form').submit();
                    }
                }
            }
        }
    });

})(jQuery);

function on_select_field_change(field_ID) {

    if (typeof ($("#" + field_ID).attr('name')) !== 'undefined') {
        var fieldname = $("#" + field_ID).attr('name');
        $('.searchform input[name="' + fieldname + '"]').remove();
        if ($("#" + field_ID).val() != '') {
            var input = $("<input>")
                    .attr("type", "hidden")
                    .attr("name", $("#" + field_ID).attr('name'))
                    .val($("#" + field_ID).val());
            $('.searchform').append($(input));
            $("#" + field_ID).parents('form').submit();
        }
    }

}

function automobile_var_filter_form_submit(type, view) {
    var automobile_counter = jQuery(this).parents('.cs-inventories-main-box').data('counter');
    var automobile_view = $.cookie('automobile_inventory_view_' + automobile_counter);
    if (automobile_view == 'list') {
        automobile_view = 'classic';
    }
    var automobile_ajaxurl = jQuery('.cs-inventories-main-box').data('ajaxurl');
    if (view == 'fancy') {
        var for_fancy = 'inventory_type=' + type + '';
        var form_data = for_fancy;
    } else {
        var form_data = jQuery(".searchform").serialize();
        console.log(jQuery(".searchform").html());
        console.log(form_data);
    }
    
    var automobile_inv_elem_atts = jQuery('.cs-inventories-elem-data').data('inv-atts');
    var page_url = jQuery('.page_url').val();
    var dataString = form_data + '&automobile_inv_elem_atts=' + eval(automobile_inv_elem_atts) + '&page_url=' + page_url + '&action=automobile_inventories_elem_view';
    jQuery(".cs-inventories-listing-loader").html('<div class="sk-circle"><div class="sk-circle1 sk-child"></div><div class="sk-circle2 sk-child"></div><div class="sk-circle3 sk-child"></div><div class="sk-circle4 sk-child"></div><div class="sk-circle5 sk-child"></div><div class="sk-circle6 sk-child"></div><div class="sk-circle7 sk-child"></div><div class="sk-circle8 sk-child"></div><div class="sk-circle9 sk-child"></div><div class="sk-circle10 sk-child"></div><div class="sk-circle11 sk-child"></div><div class="sk-circle12 sk-child"></div></div>');
    jQuery('.cs-inventories-listing-loader').show();
    

    jQuery.ajax({
        type: "POST",
        url: automobile_ajaxurl,
        data: dataString,
        dataType: 'json',
        success: function (response) {
            if (jQuery('input.automobile_search_location_field').length != '') {
                //jQuery('input.automobile_search_location_field').cityAutocomplete();
            }

            if (response.mark) {
                var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + form_data;
                window.history.pushState({path: newurl}, '', newurl);
                jQuery('.cs-inventories-elem-data').html(response.mark);

                if (jQuery('input.automobile_search_location_field').length != '') {
                    //jQuery('input.automobile_search_location_field').cityAutocomplete();
                }
            }
            jQuery('.cs-inventories-listing-loader').html('');
            jQuery('.cs-inventories-listing-loader').hide();
        },
        error: function () {
            jQuery('.cs-inventories-listing-loader').html('');
            jQuery('.cs-inventories-listing-loader').hide();
        },
    });
    return false;
}
/*
 function automobile_ajax_pagination(page_number){
 automobile_remove_url_parameter(window.location.href,'page_inventory');
 var current_url	= automobile_remove_url_parameter(window.location.href,'page_inventory');
 var page_field	= '&page_inventory';
 if(!automobile_remove_url_parameter(window.location.search,'page_inventory')){
 var page_field	= '?page_inventory';
 } 
 var newurl = current_url + page_field +'='+page_number;	
 window.history.pushState({path:newurl},'',newurl);
 window.location.reload(true);
 }*/

function automobile_ajax_pagination(page_number) {
    console.log('testing2');
    var automobile_ajaxurl = jQuery('.cs-inventories-main-box').data('ajaxurl');
    var form_data = jQuery("#pagination_form_val").serialize() + '&page_inventory=' + page_number;
    var automobile_inv_elem_atts = jQuery('.cs-inventories-elem-data').data('inv-atts');
    var dataString = form_data + '&automobile_inv_elem_atts=' + eval(automobile_inv_elem_atts) + '&action=automobile_inventories_elem_view';
    jQuery(".cs-inventories-listing-loader").html('<div class="sk-circle"><div class="sk-circle1 sk-child"></div><div class="sk-circle2 sk-child"></div><div class="sk-circle3 sk-child"></div><div class="sk-circle4 sk-child"></div><div class="sk-circle5 sk-child"></div><div class="sk-circle6 sk-child"></div><div class="sk-circle7 sk-child"></div><div class="sk-circle8 sk-child"></div><div class="sk-circle9 sk-child"></div><div class="sk-circle10 sk-child"></div><div class="sk-circle11 sk-child"></div><div class="sk-circle12 sk-child"></div></div>');
    jQuery('.cs-inventories-listing-loader').show();

    jQuery.ajax({
        type: "POST",
        url: automobile_ajaxurl,
        data: dataString,
        dataType: 'json',
        success: function (response) {
            if (response.mark) {
                var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + form_data;
                window.history.pushState({path: newurl}, '', newurl);
                jQuery('.cs-inventories-elem-data').html(response.mark);
            }
            jQuery('.cs-inventories-listing-loader').html('');
            jQuery('.cs-inventories-listing-loader').hide();
        },
        error: function () {
            jQuery('.cs-inventories-listing-loader').html('');
            jQuery('.cs-inventories-listing-loader').hide();
        },
    });
    return false;

}

function automobile_remove_url_parameter(url, parameter) {
    var urlparts = url.split('?');
    if (urlparts.length >= 2) {

        var prefix = encodeURIComponent(parameter) + '=';
        var pars = urlparts[1].split(/[&;]/g);

        for (var i = pars.length; i-- > 0; ) {
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {
                pars.splice(i, 1);
            }
        }

        url = urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : "");
        return url;
    } else {
        return url;
    }
}
function automobile_inventory_make_change(make) {
    "use strict";

    var automobile_ajaxurl = jQuery('#cs-automobile-inv-filters').data('ajax-url');
    var automobile_models_data_var = jQuery('.cs-automobile-inv-models').data('model-var');
    var dataString = 'automobile_inventory_make=' + make + '&automobile_models_data=' + eval(automobile_models_data_var) + '&action=automobile_var_filter_models';

    jQuery('.cs-inv-make-change-loader').html('<div class="cs-filters-loader"><i class="icon-spinner icon-spin"></i></div>');
    jQuery.ajax({
        type: "POST",
        url: automobile_ajaxurl,
        data: dataString,
        dataType: 'json',
        success: function (response) {
            if (response.mark !== 'undefined') {
                jQuery('.cs-automobile-inv-models').html(response.mark);
            } else {
                jQuery('.cs-automobile-inv-models').html('Error');
            }
            jQuery('.cs-inv-make-change-loader').html('');
        }
    });
}

function automobile_inv_filter_type_makes(type) {
    "use strict";

    var automobile_ajaxurl = jQuery('#cs-automobile-inv-filters').data('ajax-url');
    var automobile_makes_data_var = jQuery('.cs-automobile-inv-makes').data('makes-var');
    var dataString = 'automobile_filter_makes_data=' + eval(automobile_makes_data_var) + '&automobile_inv_type=' + type + '&action=automobile_inventory_filters_makes';
    jQuery.ajax({
        type: "POST",
        url: automobile_ajaxurl,
        data: dataString,
        dataType: 'json',
        success: function (response) {
            if (response.makes_mark !== 'undefined') {
                jQuery('.cs-automobile-inv-makes').html(response.makes_mark);
            }
        }
    });
}

function automobile_inventory_type_change(type, view) {
    "use strict";
    automobile_inv_filter_type_makes(type);
    var automobile_ajaxurl = jQuery('#cs-automobile-inv-filters').data('ajax-url');
    var automobile_types_data_var = jQuery('.cs-automobile-inv-cus-types').data('type-var');
    var automobile_types_data_var = '';
    var dataString = 'inventory_type_slug=' + type + '&automobile_filter_fields_data=' + automobile_types_data_var + '&action=automobile_var_filter_custom_fields';
    if (view == 'fancy') {

        automobile_var_filter_form_submit(type, view);
//        $(document.body).click(function (evt) {
//            var clicked = evt.target;
//            var currentID = '#' + clicked.id || "No ID!";
//            alert(currentID);
//            $(currentID).addClass('nameOfClass');
//        });
    }
    jQuery('.cs-inv-type-change-loader').html('<div class="cs-filters-loader"><i class="icon-spinner icon-spin"></i></div>');
    jQuery.ajax({
        type: "POST",
        url: automobile_ajaxurl,
        data: dataString,
        dataType: 'json',
        success: function (response) {
            if (typeof response.mark !== 'undefined') {

                jQuery('.cs-automobile-inv-cus-types').html(response.mark);
            } else {
                jQuery('.cs-automobile-inv-cus-types').html('Error');
            }
            jQuery('.cs-inv-type-change-loader').html('');
        }
    });
}

function automobile_inventory_search_box_makes(type, num) {
    "use strict";

    var automobile_ajaxurl = jQuery('.frm_inventories_filtration').data('ajax-url');
    var dataString = 'inventory_type_slug=' + type + '&action=automobile_inventory_search_box_makes';

    jQuery('.type-makes-' + num).html('<div class="cs-filters-loader"><i class="icon-spinner icon-spin"></i></div>');
    jQuery.ajax({
        type: "POST",
        url: automobile_ajaxurl,
        data: dataString,
        dataType: 'json',
        success: function (response) {
            if (typeof response.mark !== 'undefined') {
                jQuery('.type-makes-' + num).html(response.mark);
            } else {
                jQuery('.type-makes-' + num).html('Error');
            }
        }
    });
}

function set_inventory_layout() {
    var automobile_counter = jQuery(this).parents('.cs-inventories-main-box').data('counter');
    var automobile_inventory_view = jQuery.cookie('automobile_inventory_view_' + automobile_counter);
    if (automobile_inventory_view == 'list') {
        var search_side = jQuery('.cs-inv-classic-view').data('search');
        var grid_class_one = 'col-md-3';
        var grid_class = 'col-md-3 col-lg-3';
        if (search_side == 'on') {
            grid_class = 'col-md-4 col-lg-4';
            grid_class_one = 'col-md-4';
        }
        if (jQuery('.auto-listing').hasClass('auto-grid')) {
            if (jQuery('.auto-listing').parent('div').hasClass(grid_class_one)) {
                jQuery('.auto-listing').parent('div').removeClass(grid_class);
                jQuery('.auto-listing').parent('div').addClass('col-md-12 col-lg-12');
            }
            jQuery('.auto-listing').removeClass('auto-grid');
            jQuery.removeCookie('automobile_inventory_view_' + automobile_counter);
            jQuery.cookie('automobile_inventory_view_' + automobile_counter, 'list', {expires: 7});
        }
    } else if (automobile_inventory_view == 'grid') {
        var search_side = jQuery('.cs-inv-grid-view').data('search');
        var grid_class = 'col-md-3 col-lg-3';
        if (search_side == 'on') {
            grid_class = 'col-md-4 col-lg-4';
        }
        if (!jQuery('.auto-listing').hasClass('auto-grid')) {
            if (jQuery('.auto-listing').parent('div').hasClass('col-md-12')) {
                jQuery('.auto-listing').parent('div').removeClass('col-md-12');
                jQuery('.auto-listing').parent('div').removeClass('col-lg-12');
                jQuery('.auto-listing').parent('div').addClass(grid_class);
            }
            if (!jQuery('.auto-listing').parents('.cs-related-inventories').hasClass('cs-related-inventories')) {
                jQuery('.auto-listing').addClass('auto-grid');
            }
            jQuery.removeCookie('automobile_inventory_view_' + automobile_counter);
            jQuery.cookie('automobile_inventory_view_' + automobile_counter, 'grid', {expires: 7});
        }
    }
}

//
function automobile_load_make_models_frontend(make, post_id,admin_url) {
    "use strict";
    var automobile_ajaxurl = jQuery('#cs-automobile-inv-filters').data('ajax-url');
    
    var dataString = 'inventory_make=' + make + '&post_id=' + post_id + '&action=dyn_inventory_models_frontend';
      jQuery('.ajax-response-div').html('<div class="cs-fields-loader"><i class="icon-spinner icon-spin"></i></div>');
   // jQuery('#cs-inv-model-box').html('<div class="cs-fields-loader"><i class="icon-spinner icon-spin"></i></div>');
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        dataType: 'json',
        success: function (response) {
           console.log(response);
            if (response.models !== 'undefined') {
                jQuery('.ajax-response-div').html(response.models);
            } else {
                jQuery('#cs-inv-model-box').html('Error');
            }
        }
    });
}


jQuery(document).on('click', '.filters_search_btn', function () {
    jQuery(this).removeClass('filters_search_btn');
    jQuery(this).find('input[type="submit"]').click();
});