jQuery.noConflict();

jQuery(window).on("load", function () {
    var showMeridian = true;
    if (jQuery('#b2sLang').val() == 'de') {
        showMeridian = false;
    }
    jQuery('.b2s-settings-sched-item-input-time').timepicker({
        minuteStep: 30,
        appendWidgetTo: 'body',
        showSeconds: false,
        showMeridian: showMeridian,
        defaultTime: 'current'
    });
});
jQuery(document).on('click', '.b2s-save-settings-pro-info', function () {
    return false;
});


jQuery('#b2sSaveUserSettingsSchedTime').validate({
    ignore: "",
    errorPlacement: function () {
        return false;
    },
    submitHandler: function (form) {
        jQuery('.b2s-settings-user-success').hide();
        jQuery('.b2s-settings-user-error').hide();
        jQuery(".b2s-loading-area").show();
        jQuery(".b2s-user-settings-area").hide();
        jQuery('.b2s-server-connection-fail').hide();
        jQuery.ajax({
            processData: false,
            url: ajaxurl,
            type: "POST",
            dataType: "json",
            cache: false,
            data: jQuery(form).serialize(),
            error: function () {
                jQuery('.b2s-server-connection-fail').show();
                return false;
            },
            success: function (data) {
                jQuery(".b2s-loading-area").hide();
                jQuery(".b2s-user-settings-area").show();
                if (data.result == true) {
                    jQuery('.b2s-settings-user-success').show();
                } else {
                    jQuery('.b2s-settings-user-error').show();
                }
            }
        });
        return false;
    }
});


jQuery(document).on('click', '#b2s-user-network-settings-short-url', function () {
    jQuery('.b2s-settings-user-success').hide();
    jQuery('.b2s-settings-user-error').hide();
    jQuery(".b2s-loading-area").show();
    jQuery(".b2s-user-settings-area").hide();
    jQuery('.b2s-server-connection-fail').hide();
    jQuery.ajax({
        url: ajaxurl,
        type: "POST",
        dataType: "json",
        cache: false,
        data: {
            'action': 'b2s_user_network_settings',
            'short_url': jQuery('#b2s-user-network-settings-short-url').val(),
        },
        error: function () {
            jQuery('.b2s-server-connection-fail').show();
            return false;
        },
        success: function (data) {
            jQuery(".b2s-loading-area").hide();
            jQuery(".b2s-user-settings-area").show();
            if (data.result == true) {
                jQuery('.b2s-settings-user-success').show();
                jQuery('#b2s-user-network-settings-short-url').val(data.content);
                if (jQuery("#b2s-user-network-settings-short-url").is(":checked")) {
                    jQuery('#b2s-user-network-settings-short-url').prop('checked', false);
                } else {
                    jQuery('#b2s-user-network-settings-short-url').prop('checked', true);
                }
            } else {
                jQuery('.b2s-settings-user-error').show();
            }
        }
    });
    return false;
});

jQuery(document).on('click', '#b2s-user-network-settings-auto-share', function () {
    if (jQuery(this).attr('data-user-version') == 0) {
        jQuery('#b2sInfoAutoShareModal').modal('show');
    } else {
        jQuery('.b2s-settings-user-success').hide();
        jQuery('.b2s-settings-user-error').hide();
        jQuery(".b2s-loading-area").show();
        jQuery(".b2s-user-settings-area").hide();
        jQuery('.b2s-server-connection-fail').hide();
        jQuery.ajax({
            url: ajaxurl,
            type: "POST",
            dataType: "json",
            cache: false,
            data: {
                'action': 'b2s_user_network_settings',
                'auto_share': jQuery('#b2s-user-network-settings-auto-share').val(),
            },
            error: function () {
                jQuery('.b2s-server-connection-fail').show();
                return false;
            },
            success: function (data) {
                jQuery(".b2s-loading-area").hide();
                jQuery(".b2s-user-settings-area").show();
                if (data.result == true) {
                    jQuery('.b2s-settings-user-success').show();
                    jQuery('#b2s-user-network-settings-auto-share').val(data.content);
                    if (jQuery("#b2s-user-network-settings-auto-share").is(":checked")) {
                        jQuery('#b2s-user-network-settings-auto-share').prop('checked', false);
                    } else {
                        jQuery('#b2s-user-network-settings-auto-share').prop('checked', true);
                    }
                } else {
                    jQuery('.b2s-settings-user-error').show();
                }
            }
        });
    }
    return false;
});


jQuery(document).on('change', '.b2s-user-network-settings-post-format', function () {
    jQuery('.b2s-settings-user-success').hide();
    jQuery('.b2s-settings-user-error').hide();
    jQuery('.b2s-server-connection-fail').hide();
    jQuery(".b2s-loading-area").show();
    jQuery(".b2s-user-settings-area").hide();
    jQuery.ajax({
        url: ajaxurl,
        type: "POST",
        dataType: "json",
        cache: false,
        data: {
            'action': 'b2s_user_network_settings',
            'post_format': jQuery(this).val(),
            'network_id': jQuery(this).attr("data-network-id")
        },
        error: function () {
            jQuery('.b2s-server-connection-fail').show();
            return false;
        },
        success: function (data) {
            jQuery(".b2s-loading-area").hide();
            jQuery(".b2s-user-settings-area").show();
            if (data.result == true) {
                jQuery('.b2s-settings-user-success').show();
            } else {
                jQuery('.b2s-settings-user-error').show();
            }
        }
    });
    return false;

});


jQuery(document).on('click', '.b2s-get-settings-sched-time-default', function () {
    jQuery('.b2s-server-connection-fail').hide();
    jQuery.ajax({
        url: ajaxurl,
        type: "POST",
        dataType: "json",
        cache: false,
        data: {
            'action': 'b2s_get_settings_sched_time_default',
        },
        error: function () {
            jQuery('.b2s-server-connection-fail').show();
            return false;
        },
        success: function (data) {
            if (data.result == true) {
                jQuery.each(data.times, function (network_id, time) {
                    time.forEach(function (network_type_time, count) {
                        if (network_type_time != "") {
                            jQuery('.b2s-settings-sched-item-input-time[data-network-id="' + network_id + '"][data-network-type="' + count + '"]').val(network_type_time);
                            count++;
                        }
                    });
                });
            }
        }
    });
    return false;
});