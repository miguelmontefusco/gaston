jQuery(window).on("load", function () {
    if (typeof wp.heartbeat == "undefined") {
        jQuery('.b2s-heartbeat-fail').show();
    } else {
        jQuery('.b2s-heartbeat-fail').hide();
    }
});

jQuery(document).on('click', '.b2s-show-feedback-modal', function () {
    jQuery('#b2sTrailFeedbackModal').modal('show');
});

jQuery(document).on('click', '.b2s-send-trail-feedback', function () {
    jQuery('.b2s-network-auth-info').hide();
    if (jQuery('#b2s-trial_message').val() == "") {
        jQuery('.b2s-feedback-success').fail();
        return false;
    }
    jQuery('#b2sTrailFeedbackModal').modal('hide');
    jQuery('.b2s-server-connection-fail').hide();
    jQuery.ajax({
        url: ajaxurl,
        type: "POST",
        dataType: "json",
        cache: false,
        data: {
            'action': 'b2s_send_trail_feedback',
            'feedback': jQuery('#b2s-trial_message').val()
        },
        error: function () {
            jQuery('.b2s-server-connection-fail').show();
            return false;
        },
        success: function (data) {
            if (data.result == true) {
                jQuery('.b2s-feedback-success').show();
            }
        }
    });
});
jQuery(document).on('click', '.b2s-key-area-btn-submit', function () {
    jQuery('.b2s-key-area-success').hide();
    jQuery('.b2s-key-area-fail').hide();
    jQuery('.b2s-key-area-fail-max-use').hide();

    if (jQuery('.b2s-key-area-input').val() == "") {
        jQuery('.b2s-key-area-input').addClass('error');
    } else {
        jQuery('.b2s-key-area-btn-submit').prop('disabled', true);
        jQuery('.b2s-key-area-input').removeClass('error');
        jQuery('.b2s-server-connection-fail').hide();
        jQuery.ajax({
            url: ajaxurl,
            type: "POST",
            dataType: "json",
            cache: false,
            data: {
                'action': 'b2s_update_user_version',
                'key': jQuery('.b2s-key-area-input').val(),
            },
            error: function () {
                jQuery('.b2s-server-connection-fail').show();
                return false;
            },
            success: function (data) {
                jQuery('.b2s-key-area-btn-submit').prop('disabled', false);
                if (data.result == true) {
                    jQuery('.b2s-key-area-success').show();
                    jQuery('.b2s-key-area-key-name').html(data.lizenzName);
                    jQuery('.b2s-key-name').html(data.lizenzName);
                } else {
                    if (data.reason != null && data.reason == 1) {
                        jQuery('.b2s-key-area-fail-max-use').show();
                    } else {
                        jQuery('.b2s-key-area-fail').show();
                    }

                }
            }
        });
        return false;
    }
});

jQuery(document).on('click', '.b2s-trail-show', function () {
    jQuery('#b2sProFeatureModal').modal('hide');
    jQuery('#b2s-trial-modal').modal('show');
});

jQuery(document).on('click', '.b2s-trail-btn-start', function () {
    var checkFail = false;

    if (jQuery('#trial_vorname').val() == "") {
        checkFail = true;
        jQuery('#trial_vorname').addClass('error');
    } else {
        jQuery('#trial_vorname').removeClass('error');
    }

    if (jQuery('#trial_nachname').val() == "") {
        checkFail = true;
        jQuery('#trial_nachname').addClass('error');
    } else {
        jQuery('#trial_nachname').removeClass('error');
    }

    if (!isEmail(jQuery('#trial_email').val())) {
        checkFail = true;
        jQuery('#trial_email').addClass('error');
    } else {
        jQuery('#trial_email').removeClass('error');
    }

    if (checkFail == false) {
        jQuery('.b2s-trail-btn-start').prop('disabled', true);
        jQuery('.b2s-server-connection-fail').hide();
        jQuery.ajax({
            url: ajaxurl,
            type: "POST",
            dataType: "json",
            cache: false,
            data: {
                'action': 'b2s_create_trail',
                'vorname': jQuery('#trial_vorname').val(),
                'nachname': jQuery('#trial_nachname').val(),
                'email': jQuery('#trial_email').val(),
                'url': jQuery('#trial_url').val()
            },
            error: function () {
                jQuery('.b2s-server-connection-fail').show();
                return false;
            },
            success: function (data) {
                jQuery('.b2s-trail-btn-start').prop('disabled', false);
                if (data.result == true) {
                    jQuery('#b2s-trial-modal').modal('hide');
                    jQuery('.b2s-key-area-success').show();
                    jQuery('.b2s-key-area-key-name').html(data.lizenzName);
                    jQuery('.b2s-key-name').html(data.lizenzName);
                    jQuery('.b2s-trail-premium-info-area').hide();
                } else {
                    jQuery('.b2s-trail-modal-fail').show();
                }

            }
        });
    }
});
jQuery('#b2sProFeatureModal').on('show.bs.modal', function (e) {
    jQuery(this).find('.modal-title').html(jQuery(e.relatedTarget).attr('data-title'));
});

jQuery(document).on('heartbeat-send', function (e, data) {
    data['client'] = 'b2s';
});

jQuery(document).on('click', '.b2s-modal-close', function () {
    jQuery(jQuery(this).attr('data-modal-name')).modal('hide');
    jQuery(jQuery(this).attr('data-modal-name')).hide();
    jQuery('body').removeClass('modal-open');
    jQuery('body').removeAttr('style');
    return false;
});

function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}
