jQuery.noConflict();

jQuery(document).on('heartbeat-send', function (e, data) {
    data['b2s_heartbeat'] = 'b2s_listener';
});

jQuery.xhrPool = [];

jQuery(window).on("load", function () {
    init(true);
    imageSize();
    if (jQuery('.toggelbutton').is(':visible') && !jQuery("#b2s-wrapper").hasClass("toggled")) {
        jQuery('.btn-toggle-menu').trigger('click');
    }
});

jQuery(document).on('click', '.btn-toggle-menu', function () {
    if (jQuery('.toggelbutton').is(':visible')) {
        jQuery("#b2s-wrapper").toggleClass("toggled");
        if (jQuery("#b2s-wrapper").hasClass("toggled")) {
            jQuery(".sidebar-brand").hide();
            jQuery(".btn-toggle-glyphicon").removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-left');
        } else {
            jQuery(".sidebar-brand").show();
            jQuery(".btn-toggle-glyphicon").removeClass('glyphicon-chevron-left').addClass('glyphicon-chevron-right');
        }
    }
});

jQuery.sceditor.plugins.xhtml.allowedTags = ['h1', 'h2', 'p', 'br', 'i', 'b', 'a', 'img'];
jQuery.sceditor.command.set(
        "h1", {
            exec: function () {
                if (this.currentBlockNode() == undefined || this.currentBlockNode().nodeName != 'H1') {
                    this.wysiwygEditorInsertHtml('<h1>', '</h1>');
                } else {
                    jQuery(this.currentBlockNode()).replaceWith(this.currentBlockNode().innerText);
                }
            },
            txtExec: ["<h1>", "</h1>"],
            tooltip: "H1"
        });
jQuery.sceditor.command.set(
        "h2", {
            exec: function () {
                if (this.currentBlockNode() == undefined || this.currentBlockNode().nodeName != 'H2') {
                    this.wysiwygEditorInsertHtml('<h2>', '</h2>');
                } else {
                    jQuery(this.currentBlockNode()).replaceWith(this.currentBlockNode().innerText);
                }
            },
            txtExec: ["<h2>", "</h2>"], tooltip: "H2"});


jQuery(document).on('click', '.checkNetworkImage', function () {
    jQuery('.b2s-post-item-details-url-image[data-network-image-change="1"]').attr('src', jQuery(this).val());
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
                var tomorrow = new Date();
                if (jQuery('#b2sBlogPostSchedDate').length > 0) {
                    tomorrow.setTime(jQuery('#b2sBlogPostSchedDate').val());
                }
                tomorrow.setDate(tomorrow.getDate() + 1);
                var tomorrowMonth = ("0" + (tomorrow.getMonth() + 1)).slice(-2);
                var tomorrowDate = ("0" + tomorrow.getDate()).slice(-2);
                var dateTomorrow = tomorrow.getFullYear() + "-" + tomorrowMonth + "-" + tomorrowDate;
                var today = new Date();
                if (jQuery('#b2sBlogPostSchedDate').length > 0) {
                    today.setTime(jQuery('#b2sBlogPostSchedDate').val());
                }

                var todayMonth = ("0" + (today.getMonth() + 1)).slice(-2);
                var todayDate = ("0" + today.getDate()).slice(-2);
                var dateToday = today.getFullYear() + "-" + todayMonth + "-" + todayDate;

                var lang = jQuery('#b2sLang').val();
                if (lang == "de") {
                    dateTomorrow = tomorrowDate + "." + tomorrowMonth + "." + tomorrow.getFullYear();
                    dateToday = todayDate + "." + todayMonth + "." + today.getFullYear();
                }

                jQuery.each(data.times, function (network_id, time) {
                    if (jQuery('.b2s-post-item[data-network-id="' + network_id + '"]').is(":visible")) {
                        time.forEach(function (network_type_time, count) {
                            if (network_type_time != "") {
                                jQuery('.b2s-post-item-details-release-input-date-select[data-network-id="' + network_id + '"][data-network-type="' + count + '"]').val('1').trigger("change");
                                jQuery('.b2s-post-item-details-release-input-time[data-network-id="' + network_id + '"][data-network-type="' + count + '"][data-network-count="0"]').val(network_type_time);
                                var hours = network_type_time.substring(0, 2);
                                if (lang != 'de') {
                                    var timeparts = network_type_time.split(' ');
                                    hours = (timeparts[1] == 'AM') ? hours : (parseInt(hours) + 12);
                                }
                                if (hours < today.getHours()) {
                                    jQuery('.b2s-post-item-details-release-input-date[data-network-id="' + network_id + '"][data-network-type="' + count + '"][data-network-count="0"]').val(dateTomorrow);
                                } else {
                                    jQuery('.b2s-post-item-details-release-input-date[data-network-id="' + network_id + '"][data-network-type="' + count + '"][data-network-count="0"]').val(dateToday);
                                }
                                count++;
                            }
                        });
                    }
                });
            }
        }
    });
    return false;
});

jQuery(document).on('click', '.b2s-get-settings-sched-time-user', function () {
    jQuery('.b2s-server-connection-fail').hide();
    jQuery.ajax({
        url: ajaxurl,
        type: "POST",
        dataType: "json",
        cache: false,
        data: {
            'action': 'b2s_get_settings_sched_time_user',
        },
        error: function () {
            jQuery('.b2s-server-connection-fail').show();
            return false;
        },
        success: function (data) {
            if (data.result == true) {
                var tomorrow = new Date();
                if (jQuery('#b2sBlogPostSchedDate').length > 0) {
                    tomorrow.setTime(jQuery('#b2sBlogPostSchedDate').val());
                }

                tomorrow.setDate(tomorrow.getDate() + 1);
                var tomorrowMonth = ("0" + (tomorrow.getMonth() + 1)).slice(-2);
                var tomorrowDate = ("0" + tomorrow.getDate()).slice(-2);
                var dateTomorrow = tomorrow.getFullYear() + "-" + tomorrowMonth + "-" + tomorrowDate;
                var today = new Date();
                if (jQuery('#b2sBlogPostSchedDate').length > 0) {
                    today.setTime(jQuery('#b2sBlogPostSchedDate').val());
                }

                var todayMonth = ("0" + (today.getMonth() + 1)).slice(-2);
                var todayDate = ("0" + today.getDate()).slice(-2);
                var dateToday = today.getFullYear() + "-" + todayMonth + "-" + todayDate;

                var lang = jQuery('#b2sLang').val();
                if (lang == "de") {
                    dateTomorrow = tomorrowDate + "." + tomorrowMonth + "." + tomorrow.getFullYear();
                    dateToday = todayDate + "." + todayMonth + "." + today.getFullYear();
                }

                jQuery.each(data.times, function (network_id, time) {
                    if (jQuery('.b2s-post-item[data-network-id="' + network_id + '"]').is(":visible")) {
                        time.forEach(function (network_type_time, count) {
                            if (network_type_time != "") {
                                jQuery('.b2s-post-item-details-release-input-date-select[data-network-id="' + network_id + '"][data-network-type="' + count + '"]').val('1').trigger("change");
                                jQuery('.b2s-post-item-details-release-input-time[data-network-id="' + network_id + '"][data-network-type="' + count + '"][data-network-count="0"]').val(network_type_time);
                                var hours = network_type_time.substring(0, 2);
                                if (lang != 'de') {
                                    var timeparts = network_type_time.split(' ');
                                    hours = (timeparts[1] == 'AM') ? hours : (parseInt(hours) + 12);
                                }

                                if (hours < today.getHours()) {
                                    jQuery('.b2s-post-item-details-release-input-date[data-network-id="' + network_id + '"][data-network-type="' + count + '"][data-network-count="0"]').val(dateTomorrow);
                                } else {
                                    jQuery('.b2s-post-item-details-release-input-date[data-network-id="' + network_id + '"][data-network-type="' + count + '"][data-network-count="0"]').val(dateToday);
                                }
                                count++;
                            }
                        });
                    }
                });
            } else {
                jQuery('#b2s-network-no-sched-time-user').modal('show');
            }
        }
    });
    return false;
});

jQuery('#b2sProFeatureModal').on('show.bs.modal', function () {
    jQuery('.b2s-post-item-details-release-input-date-select-reset').val('0');
});

jQuery(document).on('click', '.b2s-network-list-add-btn-profeature', function () {
    jQuery('#b2s-network-list-modal').modal('hide');
});

jQuery(document).on('click', '.b2s-post-item-details-release-area-sched-for-all', function () {
    var dataNetworkAuthId = jQuery(this).attr('data-network-auth-id');
    var dataNetworkCount = 0;

    if (jQuery('.b2s-post-item-details-releas-area-details-row[data-network-auth-id="' + dataNetworkAuthId + '"][data-network-count="1"]').is(":visible")) {
        dataNetworkCount = 1;
    }
    if (jQuery('.b2s-post-item-details-releas-area-details-row[data-network-auth-id="' + dataNetworkAuthId + '"][data-network-count="2"]').is(":visible")) {
        dataNetworkCount = 2;
    }

    jQuery('.b2s-post-item-details-release-input-date-select').each(function () {
        if (jQuery(this).attr('data-network-auth-id') != dataNetworkAuthId && jQuery(this).has('option[value="' + jQuery('.b2s-post-item-details-release-input-date-select[data-network-auth-id="' + dataNetworkAuthId + '"]').val() + '"]').length > 0) {
            jQuery(this).val(jQuery('.b2s-post-item-details-release-input-date-select[data-network-auth-id="' + dataNetworkAuthId + '"]').val());
            releaseChoose(jQuery('.b2s-post-item-details-release-input-date-select[data-network-auth-id="' + dataNetworkAuthId + '"]').val(), jQuery(this).attr('data-network-auth-id'), dataNetworkCount);
        }
    });

    for (var i = 0; i <= dataNetworkCount; i++) {
        jQuery('.b2s-post-item-details-release-input-weeks[data-network-count="' + i + '"]').val(jQuery('.b2s-post-item-details-release-input-weeks[data-network-count="' + i + '"][data-network-auth-id="' + dataNetworkAuthId + '"]').val());
        jQuery('.b2s-post-item-details-release-input-time[data-network-count="' + i + '"]').val(jQuery('.b2s-post-item-details-release-input-time[data-network-count="' + i + '"][data-network-auth-id="' + dataNetworkAuthId + '"]').val());
        jQuery('.b2s-post-item-details-release-input-date[data-network-count="' + i + '"]').val(jQuery('.b2s-post-item-details-release-input-date[data-network-count="' + i + '"][data-network-auth-id="' + dataNetworkAuthId + '"]').val());

        jQuery('.b2s-post-item-details-release-input-lable-day-mo[data-network-count="' + i + '"]').prop('checked', jQuery('.b2s-post-item-details-release-input-lable-day-mo[data-network-count="' + i + '"][data-network-auth-id="' + dataNetworkAuthId + '"').prop('checked'));
        jQuery('.b2s-post-item-details-release-input-lable-day-di[data-network-count="' + i + '"]').prop('checked', jQuery('.b2s-post-item-details-release-input-lable-day-di[data-network-count="' + i + '"][data-network-auth-id="' + dataNetworkAuthId + '"').prop('checked'));
        jQuery('.b2s-post-item-details-release-input-lable-day-mi[data-network-count="' + i + '"]').prop('checked', jQuery('.b2s-post-item-details-release-input-lable-day-mi[data-network-count="' + i + '"][data-network-auth-id="' + dataNetworkAuthId + '"').prop('checked'));
        jQuery('.b2s-post-item-details-release-input-lable-day-do[data-network-count="' + i + '"]').prop('checked', jQuery('.b2s-post-item-details-release-input-lable-day-do[data-network-count="' + i + '"][data-network-auth-id="' + dataNetworkAuthId + '"').prop('checked'));
        jQuery('.b2s-post-item-details-release-input-lable-day-fr[data-network-count="' + i + '"]').prop('checked', jQuery('.b2s-post-item-details-release-input-lable-day-fr[data-network-count="' + i + '"][data-network-auth-id="' + dataNetworkAuthId + '"').prop('checked'));
        jQuery('.b2s-post-item-details-release-input-lable-day-sa[data-network-count="' + i + '"]').prop('checked', jQuery('.b2s-post-item-details-release-input-lable-day-sa[data-network-count="' + i + '"][data-network-auth-id="' + dataNetworkAuthId + '"').prop('checked'));
        jQuery('.b2s-post-item-details-release-input-lable-day-so[data-network-count="' + i + '"]').prop('checked', jQuery('.b2s-post-item-details-release-input-lable-day-so[data-network-count="' + i + '"][data-network-auth-id="' + dataNetworkAuthId + '"').prop('checked'));
    }

    if (jQuery('.b2s-post-item-details-release-input-date-select[data-network-auth-id="' + dataNetworkAuthId + '"]').val() == 2) {
        if (dataNetworkCount == 2) {
            jQuery('.b2s-post-item-details-release-input-add[data-network-count="0"]').hide();
            jQuery('.b2s-post-item-details-release-input-add[data-network-count="1"]').hide();
            jQuery('.b2s-post-item-details-release-input-hide[data-network-count="1"').hide();
            jQuery('.b2s-post-item-details-release-input-hide[data-network-count="2"').show();
        } else if (dataNetworkCount == 1) {
            jQuery('.b2s-post-item-details-release-input-add[data-network-count="0"]').hide();
            jQuery('.b2s-post-item-details-release-input-hide[data-network-count="1"').show();
        }
    }

    return false;
});


jQuery(document).on("click", ".b2s-post-ship-item-full-text", function () {
    jQuery('.b2s-server-connection-fail').hide();
    jQuery.ajax({
        url: ajaxurl,
        type: "POST",
        dataType: "json",
        cache: false,
        data: {
            'action': 'b2s_ship_item_full_text',
            'postId': jQuery('#b2sPostId').val(),
            'networkAuthId': jQuery(this).attr('data-network-auth-id'),
        },
        error: function () {
            jQuery('.b2s-server-connection-fail').show();
            return false;
        },
        success: function (data) {
            if (data.result == true) {
                jQuery('.b2s-post-item-details-item-message-input[data-network-auth-id="' + data.networkAuthId + '"').val(data.text);
                networkCount(data.networkAuthId);
            }
        }
    });
    return false;
});

jQuery(document).on("click", ".b2s-post-ship-item-message-delete", function () {
    var networkAuthId = jQuery(this).attr('data-network-auth-id');
    jQuery('.b2s-post-item-details-item-message-input[data-network-auth-id="' + networkAuthId + '"').val("");

    initSceditor(networkAuthId);

    networkCount(networkAuthId);
    return false;
});


jQuery(document).on("click", ".b2s-network-select-btn", function () {
    var networkAuthId = jQuery(this).attr('data-network-auth-id');
    //doppelklick Schutz
    if (!jQuery(this).hasClass('b2s-network-select-btn-deactivate')) {
//aktiv?
        if (!jQuery(this).children().hasClass('active')) {
//schon vorhanden?
            if (jQuery('.b2s-post-item[data-network-auth-id="' + networkAuthId + '"]').length > 0 && !jQuery('.b2s-post-item[data-network-auth-id="' + networkAuthId + '"]').hasClass('b2s-post-item-connection-fail-dummy')) {
                activatePortal(networkAuthId);
            } else {
                jQuery(this).addClass('b2s-network-select-btn-deactivate');
                jQuery('.b2s-network-status-img-loading[data-network-auth-id="' + networkAuthId + '"]').show();

                loadingDummyShow(networkAuthId, jQuery(this).attr('data-network-id'));
                jQuery('.b2s-server-connection-fail').hide();
                var networkId = jQuery(this).attr('data-network-id');
                jQuery.ajax({
                    url: ajaxurl,
                    type: "POST",
                    dataType: "json",
                    cache: false,
                    data: {
                        'action': 'b2s_ship_item',
                        'networkAuthId': networkAuthId,
                        'networkType': jQuery(this).attr('data-network-type'),
                        'networkId': jQuery(this).attr('data-network-id'),
                        'networkDisplayName': jQuery(this).attr('data-network-display-name'),
                        'postId': jQuery('#b2sPostId').val()
                    },
                    beforeSend: function (jqXHR) { // before jQuery send the request we will push it to our array
                        jQuery.xhrPool.push(jqXHR);
                    },
                    complete: function (jqXHR) { // when some of the requests completed it will splice from the array
                        var index = jQuery.xhrPool.indexOf(jqXHR);
                        if (index > -1) {
                            jQuery.xhrPool.splice(index, 1);
                        }
                    },
                    error: function (jqXHR) {
                        var index = jQuery.xhrPool.indexOf(jqXHR);
                        if (index > -1) {
                            jQuery.xhrPool.splice(index, 1);
                        }
                        loadingDummyConnectionFail(networkAuthId, networkId);
                        jQuery('.b2s-network-status-img-loading[data-network-auth-id="' + networkAuthId + '"]').hide();
                        jQuery('.b2s-network-select-btn[data-network-auth-id="' + networkAuthId + '"]').removeClass('b2s-network-select-btn-deactivate');
                        jQuery('.b2s-server-connection-fail').show();
                        return true;
                    },
                    success: function (data) {
                        if (data != undefined) {
                            jQuery('.b2s-network-status-img-loading[data-network-auth-id="' + data.networkAuthId + '"]').hide();
                            jQuery('.b2s-network-select-btn[data-network-auth-id="' + data.networkAuthId + '"]').removeClass('b2s-network-select-btn-deactivate');

                            if (data.result == true) {
                                jQuery('.b2s-post-item-loading-dummy[data-network-auth-id="' + data.networkAuthId + '"]').remove();
                                var order = jQuery.parseJSON(jQuery('.b2s-network-navbar-order').val());
                                var pos = order.indexOf(data.networkAuthId.toString());
                                var add = false;
                                for (var i = pos; i >= 0; i--) {
                                    if (jQuery('.b2s-post-item[data-network-auth-id="' + order[i] + '"]').length > 0) {
                                        jQuery('.b2s-post-item[data-network-auth-id="' + order[i] + '"]').after(data.content);
                                        i = -1;
                                        add = true;
                                    }
                                }
                                if (add == false) {
                                    jQuery('.b2s-post-list').prepend(data.content);
                                }

                                activatePortal(data.networkAuthId);

                                var dateFormat = "yyyy-mm-dd";
                                var language = "en";
                                var showMeridian = true;
                                if (jQuery('#b2sLang').val() == "de") {
                                    dateFormat = "dd.mm.yyyy";
                                    language = "de";
                                    showMeridian = false;
                                }
                                var today = new Date();
                                if (jQuery('#b2sBlogPostSchedDate').length > 0) {
                                    today.setTime(jQuery('#b2sBlogPostSchedDate').val());
                                }
                                jQuery(".b2s-post-item-details-release-input-date").datepicker({
                                    format: dateFormat,
                                    language: language,
                                    maxViewMode: 2,
                                    todayHighlight: true,
                                    startDate: today,
                                    calendarWeeks: true,
                                    autoclose: true
                                });
                                jQuery('.b2s-post-item-details-release-input-time').timepicker({
                                    minuteStep: 30,
                                    appendWidgetTo: 'body',
                                    showSeconds: false,
                                    showMeridian: showMeridian,
                                    defaultTime: 'current',
                                    snapToStep: true
                                });

                                jQuery(".b2s-post-item-details-release-input-date").datepicker().on('changeDate', function (e) {
                                    var element = '.b2s-post-item-details-release-input-time[data-network-auth-id="' + jQuery(this).attr('data-network-auth-id') + '"]';
                                    var dateStr = jQuery(this).val();
                                    var minStr = jQuery(element).val();
                                    if (jQuery('#b2sLang').val() == 'de') {
                                        dateStr = dateStr.substring(6, 10) + '-' + dateStr.substring(3, 5) + '-' + dateStr.substring(0, 2);
                                    }
                                    var dateObj = new Date();
                                    if (jQuery('#b2sBlogPostSchedDate').length > 0) {
                                        dateObj.setTime(jQuery('#b2sBlogPostSchedDate').val());
                                    }

                                    if (Date.parse(dateStr + ' ' + minStr + ':00') <= Date.parse(dateObj.getFullYear() + '-' + (dateObj.getMonth() + 1) + '-' + dateObj.getDate() + ' ' + dateObj.getHours() + ':' + dateObj.getMinutes() + ':00')) {
                                        //date in past                                        
                                        if (dateObj.getMinutes() >= 30) {
                                            jQuery(element).timepicker('setTime', (dateObj.getHours() + 1) + ':00');
                                        } else {
                                            jQuery(element).timepicker('setTime', (dateObj.getHours()) + ':30');
                                        }
                                    }
                                });

                                jQuery('.b2s-post-item-details-release-input-time').timepicker().on('changeTime.timepicker', function (e) {
                                    var dataNetworkAuthId = jQuery(this).attr('data-network-auth-id');
                                    if (jQuery('.b2s-post-item-details-release-input-date-select[data-network-auth-id="' + dataNetworkAuthId + '"]').val() == "1") {
                                        var dateStr = jQuery('.b2s-post-item-details-release-input-date[data-network-auth-id="' + jQuery(this).attr('data-network-auth-id') + '"]').val();
                                        var minStr = jQuery(this).val();
                                        if (jQuery('#b2sLang').val() == 'de') {
                                            dateStr = dateStr.substring(6, 10) + '-' + dateStr.substring(3, 5) + '-' + dateStr.substring(0, 2);
                                        } else {
                                            var minParts = minStr.split(' ');
                                            var minParts2 = minParts[0].split(':');
                                            if (minParts[1] == 'PM') {
                                                minParts2[0] = parseInt(minParts2[0]) + 12;
                                            }
                                            minStr = minParts2[0] + ':' + minParts2[1];
                                        }
                                        var dateObj = new Date();
                                        if (jQuery('#b2sBlogPostSchedDate').length > 0) {
                                            dateObj.setTime(jQuery('#b2sBlogPostSchedDate').val());
                                        }
                                        if (Date.parse(dateStr + ' ' + minStr + ':00') <= Date.parse(dateObj.getFullYear() + '-' + (dateObj.getMonth() + 1) + '-' + dateObj.getDate() + ' ' + dateObj.getHours() + ':' + dateObj.getMinutes() + ':00')) {
                                            //date in past                                        
                                            if (dateObj.getMinutes() >= 30) {
                                                jQuery(this).timepicker('setTime', (dateObj.getHours() + 1) + ':00');
                                            } else {
                                                jQuery(this).timepicker('setTime', (dateObj.getHours()) + ':30');
                                            }
                                        }
                                    }
                                });


                                if (jQuery(".selectNoNetworkImage").length == 0 || jQuery(".selectNoNetworkImage").is(":checked")) {
                                    jQuery('.b2s-post-item-details-item-image-input').removeAttr("checked");
                                    jQuery('.b2s-post-item-details-item-image-input').attr("disabled", "disabled");
                                }

                                //Check Text Limit
                                var textLimit = jQuery('.b2s-post-item-details-item-message-input[data-network-auth-id="' + data.networkAuthId + '"]').attr('data-network-text-limit');
                                if (textLimit != "0") {
                                    networkLimitAll(data.networkAuthId, data.networkId, textLimit);
                                } else {
                                    networkCount(data.networkAuthId);
                                }

                                jQuery('.checkNetworkImage:checked').trigger('click');

                                initSceditor(data.networkAuthId);
                            }
                        }
                    }
                });
            }
        } else {
            deactivatePortal(networkAuthId);
        }
    } else {
        if (jQuery('.b2s-network-status-no-img[data-network-auth-id="' + networkAuthId + '"]').is(":visible")) {
            if (jQuery('#no_image_url').length > 0) {
                jQuery('.b2s-network-reset-image').show();
            } else {
                jQuery('.b2s-network-reset-image').hide();
            }
            jQuery('#b2s-network-no-image-modal').modal('show');
            jQuery('.b2s-network-no-image-modal-datanetworkauthid').val(networkAuthId);
        }
        return false;
    }
    return false;
});

jQuery(document).on('click', '.b2s-network-reset-image', function () {
    jQuery('#no_image_url').trigger('click');
    jQuery('.b2s-network-select-btn[data-network-auth-id="' + jQuery('.b2s-network-no-image-modal-datanetworkauthid').val() + '"]').trigger('click');
    jQuery('#b2s-network-no-image-modal').modal('hide');

    jQuery('html, body').animate({
        scrollTop: jQuery(".b2s-image-area").offset().top
    }, 50);

});

jQuery(document).on('click', '.b2s-submit-btn-scroll', function () {
    jQuery('.b2s-submit-btn').trigger('click');
});

jQuery(document).on('click', '.b2s-post-item-details-release-input-days', function () {
    jQuery('.b2s-post-item-details-release-input-days[data-network-auth-id="' + jQuery(this).attr('data-network-auth-id') + '"]').removeClass('error');
});

jQuery(document).on('change', '.b2s-post-item-details-release-input-time', function () {
    jQuery('.b2s-post-item-details-release-input-time[data-network-auth-id="' + jQuery(this).attr('data-network-auth-id') + '"]').removeClass('error');
});

jQuery(document).on('change', '.b2s-post-item-details-release-input-date', function () {
    jQuery('.b2s-post-item-details-release-input-date[data-network-auth-id="' + jQuery(this).attr('data-network-auth-id') + '"]').removeClass('error');
});
jQuery('.b2s-network-details-mandant-select').change(function () {
    hideDuplicateAuths();
    chooseMandant();
});
//Versandzeitpunkt auswahl
jQuery(document).on('change', '.b2s-post-item-details-release-input-date-select', function () {
    var dataNetworkCount = 0;
    if (jQuery(this).val() == 2) {
        if (jQuery(this).attr('data-user-version') == 0) {
            jQuery('.b2s-get-settings-sched-time-open-modal').trigger('click');
        } else {
            for (var i = 1; i <= 2; i++) {
                jQuery('.b2s-post-item-details-release-input-days[data-network-auth-id="' + jQuery(this).attr('data-network-auth-id') + '"][data-network-count="' + i + '"]').each(function () {
                    if (jQuery(this).prop('checked')) {
                        dataNetworkCount = 1;
                    }
                });
            }
            if (dataNetworkCount == 2) {
                jQuery('.b2s-post-item-details-release-input-add[data-network-auth-id="' + jQuery(this).attr('data-network-auth-id') + '"][data-network-count="0"]').hide();
                jQuery('.b2s-post-item-details-release-input-add[data-network-auth-id="' + jQuery(this).attr('data-network-auth-id') + '"][data-network-count="1"]').hide();
                jQuery('.b2s-post-item-details-release-input-hide[data-network-auth-id="' + jQuery(this).attr('data-network-auth-id') + '"][data-network-count="1"').hide();
                jQuery('.b2s-post-item-details-release-input-hide[data-network-auth-id="' + jQuery(this).attr('data-network-auth-id') + '"][data-network-count="2"').show();
            } else if (dataNetworkCount == 1) {
                jQuery('.b2s-post-item-details-release-input-add[data-network-auth-id="' + jQuery(this).attr('data-network-auth-id') + '"][data-network-count="0"]').hide();
                jQuery('.b2s-post-item-details-release-input-hide[data-network-auth-id="' + jQuery(this).attr('data-network-auth-id') + '"][data-network-count="1"').show();
            }
        }
    }
    if (jQuery(this).val() == 1) {
        if (jQuery(this).attr('data-user-version') == 0) {
            jQuery('.b2s-get-settings-sched-time-open-modal').trigger('click');
        } else {
            //Überprüfen ob Zeit in der Vergangenheit
            var dateStr = jQuery('.b2s-post-item-details-release-input-date[data-network-auth-id="' + jQuery(this).attr('data-network-auth-id') + '"]').val();
            var minStr = jQuery('.b2s-post-item-details-release-input-time[data-network-auth-id="' + jQuery(this).attr('data-network-auth-id') + '"]').val();
            if (dateStr !== undefined && minStr !== undefined) {
                if (jQuery('#b2sLang').val() == 'de') {
                    dateStr = dateStr.substring(6, 10) + '-' + dateStr.substring(3, 5) + '-' + dateStr.substring(0, 2);
                } else {
                    var minParts = minStr.split(' ');
                    var minParts2 = minParts[0].split(':');
                    if (minParts[1] == 'PM') {
                        minParts2[0] = parseInt(minParts2[0]) + 12;
                    }
                    minStr = minParts2[0] + ':' + minParts2[1];
                }
                var dateObj = new Date();
                if (jQuery('#b2sBlogPostSchedDate').length > 0) {
                    dateObj.setTime(jQuery('#b2sBlogPostSchedDate').val());
                }
                if (Date.parse(dateStr + ' ' + minStr + ':00') <= Date.parse(dateObj.getFullYear() + '-' + (dateObj.getMonth() + 1) + '-' + dateObj.getDate() + ' ' + dateObj.getHours() + ':' + dateObj.getMinutes() + ':00')) {
                    //date in past                                        
                    if (dateObj.getMinutes() >= 30) {
                        jQuery('.b2s-post-item-details-release-input-time[data-network-auth-id="' + jQuery(this).attr('data-network-auth-id') + '"]').timepicker('setTime', (dateObj.getHours() + 1) + ':00');
                    } else {
                        jQuery('.b2s-post-item-details-release-input-time[data-network-auth-id="' + jQuery(this).attr('data-network-auth-id') + '"]').timepicker('setTime', (dateObj.getHours()) + ':30');
                    }
                }
            }
        }
    }
    releaseChoose(jQuery(this).val(), jQuery(this).attr('data-network-auth-id'), dataNetworkCount);
});


jQuery(document).on('click', '.b2s-re-share-btn', function () {
    jQuery(".b2s-settings-user-sched-time-area").show();
    jQuery('#b2s-sidebar-wrapper').show();
    jQuery('.b2s-post-item-info-area').show();
    jQuery('.b2s-post-item-details-message-info').show();
    jQuery('.b2s-post-item-details-edit-area').show();
    jQuery('.b2s-post-item-details-message-result').hide();
    jQuery('.b2s-post-item-details-message-result').html("");
    jQuery(".b2s-post-area").show();
    jQuery('.b2s-image-area').show();
    jQuery('.b2s-publish-area').show();
    jQuery('.b2s-footer-menu').show();
    window.scrollTo(0, 0);
    jQuery('.b2s-reporting-btn-area').hide();
    return false;
});


jQuery(document).on('click', '.b2s-post-item-details-release-input-add', function () {
    var networkAuthId = jQuery(this).attr('data-network-auth-id');
    var netCount = jQuery(this).attr('data-network-count');
    var netCountNext = parseInt(netCount) + 1;
    jQuery(this).hide();
    jQuery('.b2s-post-item-details-release-input-hide[data-network-auth-id="' + networkAuthId + '"][data-network-count="' + netCount + '"]').hide();
    jQuery('.b2s-post-item-details-release-input-hide[data-network-auth-id="' + networkAuthId + '"][data-network-count="' + netCountNext + '"]').show();
    jQuery('.b2s-post-item-details-releas-area-details-row[data-network-auth-id="' + networkAuthId + '"][data-network-count="' + netCountNext + '"]').show();
    jQuery('.b2s-post-item-details-release-input-weeks[data-network-auth-id="' + networkAuthId + '"][data-network-count="' + netCountNext + '"]').show();
    jQuery('.b2s-post-item-details-release-input-weeks[data-network-auth-id="' + networkAuthId + '"][data-network-count="' + netCountNext + '"]').removeAttr('disabled');
    jQuery('.b2s-post-item-details-release-input-weeks[data-network-auth-id="' + networkAuthId + '"][data-network-count="' + netCountNext + '"]').val('1');
    jQuery('.b2s-post-item-details-release-input-time[data-network-auth-id="' + networkAuthId + '"][data-network-count="' + netCountNext + '"]').show();
    jQuery('.b2s-post-item-details-release-input-time[data-network-auth-id="' + networkAuthId + '"][data-network-count="' + netCountNext + '"]').removeAttr('disabled');
    jQuery('.b2s-post-item-details-release-input-days[data-network-auth-id="' + networkAuthId + '"][data-network-count="' + netCountNext + '"]').removeAttr('disabled');
    jQuery('.b2s-post-item-details-release-input-date[data-network-auth-id="' + networkAuthId + '"][data-network-count="' + netCountNext + '"]').removeAttr('disabled');

    return false;
});

jQuery(document).on('click', '.b2s-post-item-details-release-input-hide', function () {
    var networkAuthId = jQuery(this).attr('data-network-auth-id');
    var netCount = jQuery(this).attr('data-network-count');
    var netCountBevor = parseInt(netCount) - 1;
    var selectorInput = '[data-network-auth-id="' + networkAuthId + '"][data-network-count="' + netCount + '"]'
    jQuery('.b2s-post-item-details-releas-area-details-row' + selectorInput).hide();
    jQuery('.b2s-post-item-details-release-input-hide[data-network-auth-id="' + networkAuthId + '"][data-network-count="' + netCountBevor + '"]').show();
    jQuery('.b2s-post-item-details-release-input-add[data-network-auth-id="' + networkAuthId + '"][data-network-count="' + netCountBevor + '"]').show();
    //felder leeren
    jQuery('.b2s-post-item-details-release-input-date' + selectorInput).prop('disabled', true);
    jQuery('.b2s-post-item-details-release-input-time' + selectorInput).prop('disabled', true);
    jQuery('.b2s-post-item-details-release-input-weeks' + selectorInput).val('');
    jQuery('.b2s-post-item-details-release-input-weeks' + selectorInput).prop('disabled', true);
    jQuery('.b2s-post-item-details-release-input-days' + selectorInput).prop('checked', false);
    jQuery('.b2s-post-item-details-release-input-days' + selectorInput).prop('disabled', true);
    return false;
});

jQuery(document).on("keyup", ".complete_network_url", function () {
    var url = jQuery(this).val();
    jQuery(this).removeClass("error");
    if (url.length != "0") {
        if (url.indexOf("http://") == -1 && url.indexOf("https://") == -1) {
            url = "http://" + url;
            jQuery(this).val(url);
        }
    } else if (jQuery(this).hasClass("required_network_url")) {
        url = jQuery("#b2sDefault_url").val();
        jQuery(this).val(url);
    }
});

jQuery(document).on('click', '.selectNoNetworkImage', function () {
    imageCheck();
});

jQuery(document).on('click', '.scroll-to-top', function () {
    window.scrollTo(0, 0);
    return false;
});

jQuery(document).on('click', '.scroll-to-bottom', function () {
    window.scrollTo(0, document.body.scrollHeight);
    return false;
});

jQuery(document).on('click', '.b2s-post-item-details-preview-url-reload', function () {
    var re = new RegExp(/^(https?:\/\/)?[a-zA-Z0-9]+([\-\.]{1}[a-zA-Z0-9]+)*\.[a-zA-Z]{2,10}(:[0-9]{1,5})?(\/.*)?$/);
    var networkAuthId = jQuery(this).attr('data-network-auth-id');
    var url = jQuery('.b2s-post-item-details-item-url-input[data-network-auth-id="' + networkAuthId + '"]').val();
    if (re.test(url)) {
        jQuery('.b2s-post-item-details-item-url-input[data-network-auth-id="' + networkAuthId + '"]').removeClass('error');
        jQuery(this).addClass('glyphicon-refresh-animate');
        jQuery('.b2s-server-connection-fail').hide();
        jQuery.ajax({
            url: ajaxurl,
            type: "POST",
            dataType: "json",
            cache: false,
            data: {
                'action': 'b2s_ship_item_reload_url',
                'networkId': jQuery(this).attr('data-network-id'),
                'networkAuthId': networkAuthId,
                'postId': jQuery('#b2sPostId').val(),
                'defaultUrl': jQuery('#b2sDefault_url').val(),
                'url': url
            },
            error: function () {
                jQuery('.b2s-server-connection-fail').show();
                return false;
            },
            success: function (data) {
                jQuery('.b2s-post-item-details-preview-url-reload[data-network-auth-id="' + data.networkAuthId + '"]').removeClass('glyphicon-refresh-animate');
                if (data.result == true) {
                    jQuery('.b2s-post-item-details-preview-title[data-network-auth-id="' + data.networkAuthId + '"]').html(data.title);
                    jQuery('.b2s-post-item-details-preview-desc[data-network-auth-id="' + data.networkAuthId + '"]').html(data.description);
                    if (jQuery('.b2s-post-item-details-url-image[data-network-auth-id="' + data.networkAuthId + '"]').attr('data-network-image-change') == '0') {
                        jQuery('.b2s-post-item-details-url-image[data-network-auth-id="' + data.networkAuthId + '"]').attr('src', data.image);
                    }

                    if (jQuery('.b2s-post-item-details-url-image[data-network-auth-id="' + data.networkAuthId + '"]').attr('data-network-image-change') == '1' && jQuery('.selectNoNetworkImage').is(':checked')) {
                        if (data.image != "") {
                            jQuery('.b2s-post-item-details-url-image[data-network-auth-id="' + data.networkAuthId + '"]').attr('src', data.image);
                        } else {
                            jQuery('.b2s-post-item-details-url-image[data-network-auth-id="' + data.networkAuthId + '"]').attr('src', jQuery('#b2sDefaultNoImage').val());
                        }
                    }
                }
            }

        });
    } else {
        jQuery('.b2s-post-item-details-item-url-input[data-network-auth-id="' + networkAuthId + '"]').addClass('error');
    }
});


jQuery("#b2sNetworkSent").keypress(function (e) {
    if (e.keyCode == 13 && e.target.tagName == "INPUT")
        return false;
});

jQuery.validator.addMethod("checkUrl", function (value, element, regexp) {
    var re = new RegExp(regexp);
    return this.optional(element) || re.test(value);
}, "Invalid Url");

jQuery.validator.addClassRules("b2s-post-item-details-item-url-input", {
    checkUrl: /^(https?:\/\/)?[a-zA-Z0-9]+([\-\.]{1}[a-zA-Z0-9]+)*\.[a-zA-Z]{2,10}(:[0-9]{1,5})?(\/.*)?$/
});

jQuery.validator.addMethod("checkTags", function (value, element, test) {
    var allowed_tags = ['p', 'h1', 'h2', 'br', 'i', 'b', 'a', 'img'];

    var tags = value.match(/(<([^>]+)>)/ig);
    if (tags !== null && tags.length > 0) {
        if (jQuery(element).hasClass('b2s-post-item-details-item-message-input-allow-html')) {
            for (var i = 0; i < tags.length; i++) {
                var allowed_count = 0;
                for (var e = 0; e < allowed_tags.length; e++) {
                    var regex = new RegExp("<\s*(\/)?" + allowed_tags[e] + "(( [^>]*>)|[>])");
                    if (tags[i].match(regex) != null) {
                        allowed_count = 1;
                    }
                }
                if (allowed_count == 0) {
                    return false;
                }
            }
        } else {
            return false;
        }
    }
    return true;
});

jQuery.validator.addClassRules('b2s-post-item-details-item-message-input', {'checkTags': true});

jQuery.validator.addClassRules('b2s-post-item-details-release-input-date-select', {'checkSched': true});

jQuery.validator.addClassRules('b2s-post-item-details-item-title-input', {required: true});


jQuery.validator.addMethod('checkSched', function (value, element, rest) {
    if (jQuery(element).is(':not(:disabled)') && jQuery(element).val() != 0) {
        var networkAuthId = jQuery(element).attr('data-network-auth-id');
        if (jQuery('.b2s-post-item-details-release-input-time[data-network-auth-id="' + networkAuthId + '"]').val() == "") {
            jQuery('.b2s-post-item-details-release-input-time[data-network-auth-id="' + networkAuthId + '"]').addClass('error');
            return false;
        } else {
            jQuery('.b2s-post-item-details-release-input-time[data-network-auth-id="' + networkAuthId + '"]').removeClass('error');
        }
        if (jQuery(element).val() == 1) {
            if (jQuery('.b2s-post-item-details-release-input-date[data-network-auth-id="' + networkAuthId + '"]').val() == "") {
                jQuery('.b2s-post-item-details-release-input-date[data-network-auth-id="' + networkAuthId + '"]').addClass('error');
                return false;
            } else {
                jQuery('.b2s-post-item-details-release-input-date[data-network-auth-id="' + networkAuthId + '"]').removeClass('error');
            }

        } else {
            var maxCount = jQuery('.b2s-post-item-details-release-input-daySelect[data-network-auth-id="' + networkAuthId + '"]').length;
            jQuery('.b2s-post-item-details-release-input-days[data-network-auth-id="' + networkAuthId + '"]').removeClass('error');
            var daySelect = false;
            var daySelectErrorCount = 0;
            for (var count = 0; count < maxCount; count++) {
                if (jQuery('.b2s-post-item-details-release-input-lable-day-mo[data-network-auth-id="' + networkAuthId + '"][data-network-count="' + count + '"]').is(':not(:disabled)')) {
                    daySelect = false;
                    jQuery('.b2s-post-item-details-release-input-days[data-network-auth-id="' + networkAuthId + '"][data-network-count="' + count + '"]').each(function () {
                        if (jQuery(this).is(':checked')) {
                            daySelect = true;
                        }
                    });
                    if (daySelect === false) {
                        daySelectErrorCount += 1;
                        jQuery('.b2s-post-item-details-release-input-days[data-network-auth-id="' + networkAuthId + '"][data-network-count="' + count + '"]').addClass('error');
                    }
                }
            }
            if (daySelectErrorCount != 0) {
                return false;
            }
        }
    }
    return true;
});

jQuery("#b2sNetworkSent").validate({
    ignore: "",
    errorPlacement: function () {
        return false;
    },
    submitHandler: function (form) {
        if (checkNetworkSelected() == false) {
            return false;
        }

        var userDate = new Date();
        jQuery("#user_timezone").val((userDate.getTimezoneOffset() / 60) * -1);
        var pubDate = userDate.getFullYear() + "-" + padDate(userDate.getMonth() + 1) + "-" + padDate(userDate.getDate()) + " " + padDate(userDate.getHours()) + ":" + padDate(userDate.getMinutes()) + ":" + padDate(userDate.getSeconds());
        jQuery('#publish_date').val(pubDate);
        jQuery(".b2s-loading-area").show();
        jQuery(".b2s-post-area").hide();
        jQuery(".b2s-settings-user-sched-time-area").hide();
        jQuery('#b2s-sidebar-wrapper').hide();
        jQuery('.b2s-post-item-info-area').hide();
        jQuery.xhrPool.abortAll();
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
                var content = data.content;
                jQuery(".b2s-loading-area").hide();
                for (var i = 0; i < content.length; i++) {
                    jQuery('.b2s-post-item-details-message-info[data-network-auth-id="' + content[i]['networkAuthId'] + '"]').hide();
                    jQuery('.b2s-post-item-details-edit-area[data-network-auth-id="' + content[i]['networkAuthId'] + '"]').hide();
                    jQuery('.b2s-post-item-details-message-result[data-network-auth-id="' + content[i]['networkAuthId'] + '"]').show();
                    jQuery('.b2s-post-item-details-message-result[data-network-auth-id="' + content[i]['networkAuthId'] + '"]').html(content[i]['html']);
                }
                jQuery(".b2s-post-area").show();
                jQuery('.b2s-image-area').hide();
                jQuery('.b2s-publish-area').hide();
                jQuery('.b2s-footer-menu').hide();
                window.scrollTo(0, 0);
                jQuery('.b2s-empty-area').hide();
                jQuery('.b2s-reporting-btn-area').show();
                wp.heartbeat.connectNow();
            }
        });
        return false;
    }
});
jQuery('#b2s-network-list-modal').on('show.bs.modal', function (e) {
    jQuery('.b2s-network-list-modal-mandant').html(jQuery(".b2s-network-details-mandant-select option:selected").text());
});

jQuery(document).on('click', '.b2s-loading-area-save-profile-change', function () {
    var selectedAuth = new Array();
    jQuery('.b2s-network-list.active').each(function () {
        selectedAuth.push(jQuery(this).parents('.b2s-network-select-btn').attr('data-network-auth-id'));
    });
    jQuery('.b2s-server-connection-fail').hide();
    jQuery.ajax({
        url: ajaxurl,
        type: "POST",
        dataType: "json",
        cache: false,
        data: {
            'action': 'b2s_ship_navbar_save_settings',
            'mandantId': jQuery('.b2s-network-details-mandant-select').val(),
            'selectedAuth': selectedAuth
        },
        error: function () {
            jQuery('.b2s-server-connection-fail').show();
            return false;
        },
        success: function (data) {
            if (data.result == true) {
                jQuery('.b2s-ship-settings-save').show();
                window.scrollTo(0, 0);
                var mandantId = jQuery('.b2s-network-details-mandant-select').val();

                jQuery('.b2s-network-list').each(function () {
                    var jsonMandantIds = jQuery(this).parents('.b2s-sidbar-wrapper-nav-li').attr('data-mandant-id');
                    if (jsonMandantIds !== undefined) {
                        var jsonMandantIds = jQuery.parseJSON(jsonMandantIds);
                        if (jsonMandantIds.indexOf(mandantId) !== -1 && !jQuery(this).hasClass('active')) {
                            //remove
                            var newMandant = new Array();
                            jQuery(jsonMandantIds).each(function (index, item) {
                                if (item !== mandantId) {
                                    newMandant.push(item);
                                }
                            });
                            jQuery(this).parents('.b2s-sidbar-wrapper-nav-li').attr('data-mandant-id', JSON.stringify(newMandant));

                        } else if (jsonMandantIds.indexOf(mandantId) == -1 && jQuery(this).hasClass('active')) {
                            //add
                            jsonMandantIds.push(mandantId);
                            jQuery(this).parents('.b2s-sidbar-wrapper-nav-li').attr('data-mandant-id', JSON.stringify(jsonMandantIds));
                        }
                    }
                });
            }
        }
    });
});

window.addEventListener('message', function (e) {
    if (e.origin == jQuery('#b2sServerUrl').val()) {
        var data = JSON.parse(e.data);
        loginSuccess(data.networkId, data.networkType, data.displayName, data.networkAuthId, data.mandandId);
    }
});

jQuery.xhrPool.abortAll = function () { // our abort function
    jQuery(this).each(function (idx, jqXHR) {
        jqXHR.abort();
    });
    jQuery.xhrPool.length = 0
};

function loadingDummyShow(networkAuthId, networkId) {
    jQuery('.b2s-post-item-connection-fail-dummy[data-network-auth-id="' + networkAuthId + '"]').remove();
    var html = '<div class="b2s-post-item b2s-post-item-loading-dummy" data-network-auth-id="' + networkAuthId + '">'
            + '<div class="panel panel-group">'
            + '<div class="panel-body">'
            + '<div class="b2s-post-item-area">'
            + '<div class="b2s-post-item-details">'
            + '<div class="b2s-loader-impulse b2s-loader-impulse-md b2s-post-item-loading-impulse-area">'
            + '<img class="img-responsive" src="' + jQuery('#b2sPortalImagePath').val() + networkId + '_flat.png" alt="">'
            + '</div>'
            + '<div class="clearfix"></div>'
            + '<div class="text-center"><small>'
            + jQuery('#b2sJsTextLoading').val()
            + '</small></div>'
            + '</div>'
            + '</div>'
            + '</div>'
            + '</div>';
    var order = jQuery.parseJSON(jQuery('.b2s-network-navbar-order').val());
    var pos = order.indexOf(networkAuthId.toString());
    var add = false;
    for (var i = pos; i >= 0; i--) {
        if (jQuery('.b2s-post-item[data-network-auth-id="' + order[i] + '"]').length > 0) {
            jQuery('.b2s-post-item[data-network-auth-id="' + order[i] + '"]').after(html);
            i = -1;
            add = true;
        }
    }
    if (add == false) {
        jQuery('.b2s-post-list').prepend(html);
    }
}

function loadingDummyConnectionFail(networkAuthId, networkId) {
    var html = '<div class="b2s-post-item b2s-post-item-connection-fail-dummy" data-network-auth-id="' + networkAuthId + '">'
            + '<div class="panel panel-group">'
            + '<div class="panel-body">'
            + '<div class="b2s-post-item-area">'
            + '<div class="b2s-post-item-details">'
            + '<div class="b2s-post-item-details-portal-img-area">'
            + '<img class="img-responsive" src="' + jQuery('#b2sPortalImagePath').val() + networkId + '_flat.png" alt="">'
            + '</div>'
            + '<div class="clearfix"></div>'
            + '<div class="text-center"><small>'
            + jQuery('#b2sJsTextConnectionFail').val()
            + '</small></div>'
            + '</div>'
            + '</div>'
            + '</div>'
            + '</div>';

    jQuery('.b2s-post-item-loading-dummy[data-network-auth-id="' + networkAuthId + '"]').replaceWith(html);
}

function init(firstrun) {
    var dateFormat = "yyyy-mm-dd";
    var language = "en";
    var showMeridian = true;
    if (jQuery('#b2sLang').val() == "de") {
        dateFormat = "dd.mm.yyyy";
        language = "de";
        showMeridian = false;
    }
    var today = new Date();
    if (jQuery('#b2sBlogPostSchedDate').length > 0) {
        today.setTime(jQuery('#b2sBlogPostSchedDate').val());
    }
    jQuery(".b2s-post-item-details-release-input-date").datepicker({
        format: dateFormat,
        language: language,
        maxViewMode: 2,
        todayHighlight: true,
        startDate: today,
        calendarWeeks: true,
        autoclose: true
    });
    jQuery('.b2s-post-item-details-release-input-time').timepicker({
        minuteStep: 30,
        appendWidgetTo: 'body',
        showSeconds: false,
        showMeridian: showMeridian,
        defaultTime: 'current',
        snapToStep: true
    });
    checkNetworkSelected();
    imageCheck();
    if (firstrun == true) {
        jQuery(window).scroll(function () {
            submitArea();
        });
        jQuery('.b2s-post-item-details-release-input-date-select').each(function () {
            releaseChoose(jQuery(this).val(), jQuery(this).attr('data-network-auth-id'), 0);
        });
        hideDuplicateAuths();
        chooseMandant();
        jQuery('.checkNetworkImage:first').trigger('click');
    }
}

function initSceditor(networkAuthId) {
    var sceditor = jQuery('.b2s-post-item-details-item-message-input-allow-html[data-network-auth-id="' + networkAuthId + '"]').sceditor('instance');

    if (typeof sceditor !== 'undefined' && typeof sceditor.destroy == 'function') {
        sceditor.destroy();
    }

    jQuery('.b2s-post-item-details-item-message-input-allow-html[data-network-auth-id="' + networkAuthId + '"]').sceditor({
        plugins: 'xhtml',
        toolbar: "h1,h2,bold,italic,link,unlink,image|source",
        autoUpdate: true,
        emoticonsEnabled: false
    });

    var sceditor = jQuery('.b2s-post-item-details-item-message-input-allow-html[data-network-auth-id="' + networkAuthId + '"]').sceditor('instance');

    if (typeof sceditor !== 'undefined' && typeof sceditor.destroy == 'function') {
        sceditor.keyUp(function () {
            jQuery(this).parents('.b2s-post-item-details').find('.b2s-post-item-countChar').html(jQuery(this).prev('.b2s-post-item-details-item-message-input').sceditor('instance').getBody().text().length);
        });
        jQuery('.b2s-post-item-details-item-message-input-allow-html[data-network-auth-id="' + networkAuthId + '"]').next('.sceditor-container').find('textarea').on('keyup', function () {
            var tmp = document.createElement("DIV");
            tmp.innerHTML = jQuery(this).val();
            jQuery(this).parents('.b2s-post-item-details').find('.b2s-post-item-countChar').html(tmp.innerText.length);
        });
    }


}

function submitArea() {
    if (jQuery(window).scrollTop() + jQuery(window.top).height() >= jQuery('.b2s-publish-area').offset().top) {
        jQuery(".b2s-footer-menu").hide();
    } else {
        jQuery(".b2s-footer-menu").show();
    }
}

function imageSize() {
    jQuery('.networkImage').each(function () {
        var width = this.naturalWidth;
        var height = this.naturalHeight;
        jQuery(this).parents('.b2s-image-item').find('.b2s-image-item-caption-resolution').html(width + 'x' + height);
    });
}

function imageCheck() {
    if (jQuery(".selectNoNetworkImage").length == 0 || jQuery(".selectNoNetworkImage").is(":checked")) {
        jQuery(".checkNetworkImage").removeAttr("checked");
        jQuery(".checkNetworkImage").attr("disabled", "disabled");
        jQuery("#blog_image").val("0");
        jQuery('.b2sOnlyWithImage').each(function () {
            deactivatePortal(jQuery(this).attr('data-network-auth-id'));
        });
        jQuery('.b2s-post-item-details-item-image-input').removeAttr("checked");
        jQuery('.b2s-post-item-details-item-image-input').attr("disabled", "disabled");
        navbarDeactivatePortal('image');
        jQuery('.b2s-post-item-details-url-image[data-network-image-change="1"]').attr('src', jQuery('#b2sDefaultNoImage').val());
        jQuery('.b2s-image-warning-no-image').show();
        jQuery('.b2s-post-item-details-url-image[data-network-image-change="1"').each(function () {
            jQuery('.b2s-post-item-details-preview-url-reload[data-network-auth-id="' + jQuery(this).attr('data-network-auth-id') + '"]').trigger('click');
        });

    } else {
        jQuery("#blog_image").val("1");
        jQuery(".checkNetworkImage").removeAttr("disabled");
        jQuery('.b2s-post-item-details-item-image-input').removeAttr("disabled");
        jQuery(".checkNetworkImage:first").prop("checked", true);
        jQuery('.b2s-image-warning-no-image').hide();
        jQuery('.b2s-post-item-details-url-image[data-network-image-change="1"]').attr('src', jQuery('.checkNetworkImage:checked').val());
        navbarActivatePortal('image');
    }

//Twitter neuberechnen
    jQuery(".b2s-post-item[data-network-id='2']").each(function () {
        networkLimitAll(jQuery(this).attr('data-network-auth-id'), 2, "140");
    });
}

function navbarDeactivatePortal(reason) {
    if (reason == "image") {
        var portale = Array(6, 7, 12);
        for (var i = 0; i <= portale.length; i++) {
            jQuery('.b2s-network-select-btn[data-network-id="' + portale[i] + '"]').addClass('b2s-network-select-btn-deactivate');
            jQuery('.b2s-network-status-no-img[data-network-id="' + portale[i] + '"]').show();
        }
    }
}

function navbarActivatePortal(reason) {
    if (reason == "image") {
        var portale = Array(6, 7, 12);
        for (var i = 0; i <= portale.length; i++) {
            jQuery('.b2s-network-select-btn[data-network-id="' + portale[i] + '"]').removeClass('b2s-network-select-btn-deactivate');
            jQuery('.b2s-network-status-no-img[data-network-id="' + portale[i] + '"]').hide();
        }
    }
}

function deactivatePortal(networkAuthId) {
    var selector = '.b2s-post-item[data-network-auth-id="' + networkAuthId + '"]';
    jQuery(selector).hide();
    jQuery(selector).find('.form-control').each(function () {
        jQuery(this).attr("disabled", "disabled");
    });
    jQuery('.b2s-network-select-btn[data-network-auth-id="' + networkAuthId + '"]').children().removeClass('active').find('.b2s-network-status-img').addClass('b2s-network-hide');
    checkNetworkSelected();
    submitArea();
    return true;
}

function activatePortal(networkAuthId, check) {
    var selector = '.b2s-post-item[data-network-auth-id="' + networkAuthId + '"]'
    //jQuery(selector).prependTo(".b2s-post-list");
    jQuery(selector).show();
    jQuery(selector).find('.form-control').each(function () {
        if ((!jQuery(this).hasClass('b2s-post-item-details-release-input-weeks')) &&
                (!jQuery(this).hasClass('b2s-post-item-details-release-input-date')) &&
                (!jQuery(this).hasClass('b2s-post-item-details-release-input-time')) &&
                (!jQuery(this).hasClass('b2s-post-item-details-release-input-days'))) {
            jQuery(this).removeAttr("disabled", "disabled");
        }
    });
    jQuery('.b2s-network-select-btn[data-network-auth-id="' + networkAuthId + '"]').children().addClass('active').find('.b2s-network-hide').removeClass('b2s-network-hide');
    checkNetworkSelected();
    submitArea();
}

function checkNetworkSelected() {
//überprüfen ob mindestens ein PostItem vorhanden und sichtbar ist
    var visible = false;
    jQuery('.b2s-post-list').find('.b2s-post-item').each(function () {
        if (jQuery(this).is(":visible")) {
            visible = true;
        }
    });
    if (jQuery('.b2s-post-list').text().trim() == "" || visible == false) {
        jQuery('.b2s-image-area').hide();
        jQuery('.b2s-publish-area').hide();
        jQuery('.b2s-footer-menu').hide();
        jQuery('.b2s-empty-area').show();
        return false;
    } else {
        jQuery('.b2s-image-area').show();
        jQuery('.b2s-publish-area').show();
        if (jQuery(window).scrollTop() + jQuery(window.top).height() < jQuery('.b2s-publish-area').offset().top) {
            jQuery('.b2s-footer-menu').show();
        }
        jQuery('.b2s-empty-area').hide();
        return true;
    }
}

function releaseChoose(choose, dataNetworkAuthId, dataNetworkCount) {
    var selectorInput = '[data-network-auth-id="' + dataNetworkAuthId + '"]';
    jQuery('.b2s-post-item-details-releas-area-details-row' + selectorInput).hide();
    if (choose == 0) {
        jQuery('.b2s-post-item-details-release-input-date' + selectorInput).prop('disabled', true);
        jQuery('.b2s-post-item-details-release-input-date' + selectorInput).hide();
        jQuery('.b2s-post-item-details-release-input-time' + selectorInput).hide();
        jQuery('.b2s-post-item-details-release-input-time' + selectorInput).prop('disabled', true);
        jQuery('.b2s-post-item-details-release-input-weeks' + selectorInput).hide();
        jQuery('.b2s-post-item-details-release-input-weeks' + selectorInput).prop('disabled', true);
        jQuery('.b2s-post-item-details-release-input-days' + selectorInput).prop('disabled');
        jQuery('.b2s-post-item-details-release-input-daySelect' + selectorInput).hide();
        jQuery('.b2s-post-item-details-release-input-add' + selectorInput).hide();
        jQuery('.2s-post-item-details-release-area-details-ul' + selectorInput).hide();
        jQuery('.b2s-post-item-details-release-save-settings' + selectorInput).prop('disabled', true);
        jQuery('.b2s-post-item-details-release-area-details-ul' + selectorInput).hide();
        jQuery('.b2s-post-item-details-release-save-settings-label' + selectorInput).hide();
        jQuery('.b2s-post-item-details-release-area-label-duration' + selectorInput).hide();
        jQuery('.b2s-post-item-details-release-area-label-date' + selectorInput).hide();
        jQuery('.b2s-post-item-details-release-area-label-time' + selectorInput).hide();
        jQuery('.b2s-post-item-details-release-area-label-day' + selectorInput).hide();
        jQuery('.b2s-post-item-details-release-area-div-duration' + selectorInput).hide();
        jQuery('.b2s-post-item-details-release-area-div-date' + selectorInput).hide();
        jQuery('.b2s-post-item-details-release-area-div-time' + selectorInput).hide();
        jQuery('.b2s-post-item-details-release-area-div-day' + selectorInput).hide();
    } else if (choose == 1) {
        for (var i = 0; i <= dataNetworkCount; i++) {
            jQuery('.b2s-post-item-details-releas-area-details-row[data-network-count="' + i + '"]' + selectorInput).show();
            jQuery('.b2s-post-item-details-release-input-date[data-network-count="' + i + '"]' + selectorInput).show();
            jQuery('.b2s-post-item-details-release-input-date[data-network-count="' + i + '"]' + selectorInput).removeAttr('disabled');
            jQuery('.b2s-post-item-details-release-input-time[data-network-count="' + i + '"]' + selectorInput).show();
            jQuery('.b2s-post-item-details-release-input-time[data-network-count="' + i + '"]' + selectorInput).removeAttr('disabled');
        }
        jQuery('.b2s-post-item-details-release-input-weeks' + selectorInput).hide();
        jQuery('.b2s-post-item-details-release-input-weeks' + selectorInput).prop('disabled');
        jQuery('.b2s-post-item-details-release-input-daySelect' + selectorInput).hide();
        jQuery('.b2s-post-item-details-release-input-days' + selectorInput).prop('disabled', true);
        jQuery('.b2s-post-item-details-release-input-add' + selectorInput).hide();
        jQuery('.b2s-post-item-details-release-area-details-ul' + selectorInput).show();
        jQuery('.b2s-post-item-details-release-save-settings' + selectorInput).prop('disabled', false);
        jQuery('.b2s-post-item-details-release-save-settings-label' + selectorInput).show();
        jQuery('.b2s-post-item-details-release-area-label-duration' + selectorInput).hide();
        jQuery('.b2s-post-item-details-release-area-label-date' + selectorInput).show();
        jQuery('.b2s-post-item-details-release-area-label-time' + selectorInput).show();
        jQuery('.b2s-post-item-details-release-area-label-day' + selectorInput).hide();
        jQuery('.b2s-post-item-details-release-area-div-duration' + selectorInput).hide();
        jQuery('.b2s-post-item-details-release-area-div-date' + selectorInput).show();
        jQuery('.b2s-post-item-details-release-area-div-time' + selectorInput).show();
        jQuery('.b2s-post-item-details-release-area-div-day' + selectorInput).hide();
    } else if (choose == 2) {
        jQuery('.b2s-post-item-details-release-input-date' + selectorInput).show();
        jQuery('.b2s-post-item-details-release-input-date' + selectorInput).removeAttr('disabled');
        jQuery('.b2s-post-item-details-release-input-daySelect' + selectorInput).show();
        jQuery('.b2s-post-item-details-release-input-add' + selectorInput).show();
        jQuery('.b2s-post-item-details-release-area-details-ul' + selectorInput).show();
        jQuery('.b2s-post-item-details-release-save-settings' + selectorInput).prop('disabled', false);
        jQuery('.b2s-post-item-details-release-save-settings-label' + selectorInput).hide();
        for (var i = 0; i <= dataNetworkCount; i++) {
            jQuery('.b2s-post-item-details-releas-area-details-row[data-network-count="' + i + '"]' + selectorInput).show();
            jQuery('.b2s-post-item-details-release-input-time[data-network-count="' + i + '"]' + selectorInput).show();
            jQuery('.b2s-post-item-details-release-input-time[data-network-count="' + i + '"]' + selectorInput).removeAttr('disabled');
            jQuery('.b2s-post-item-details-release-input-weeks[data-network-count="' + i + '"]' + selectorInput).show();
            jQuery('.b2s-post-item-details-release-input-weeks[data-network-count="' + i + '"]' + selectorInput).removeAttr('disabled');
            jQuery('.b2s-post-item-details-release-input-days[data-network-count="' + i + '"]' + selectorInput).removeAttr('disabled');
        }
        jQuery('.b2s-post-item-details-release-area-label-duration' + selectorInput).show();
        jQuery('.b2s-post-item-details-release-area-label-date' + selectorInput).show();
        jQuery('.b2s-post-item-details-release-area-label-time' + selectorInput).show();
        jQuery('.b2s-post-item-details-release-area-label-day' + selectorInput).show();
        jQuery('.b2s-post-item-details-release-area-div-duration' + selectorInput).show();
        jQuery('.b2s-post-item-details-release-area-div-date' + selectorInput).hide();
        jQuery('.b2s-post-item-details-release-area-div-time' + selectorInput).show();
        jQuery('.b2s-post-item-details-release-area-div-day' + selectorInput).show();
    }

    var showMeridian = true;
    if (jQuery('#b2sLang').val() == 'de') {
        showMeridian = false;
    }

    jQuery('.b2s-post-item-details-release-input-time').timepicker({
        minuteStep: 30,
        appendWidgetTo: 'body',
        showSeconds: false,
        showMeridian: showMeridian,
        defaultTime: 'current',
        snapToStep: true
    });
}

function addTag(networkAuthId) {
    var selector = ".b2s-post-item-details-tag-input-elem[data-network-auth-id='" + networkAuthId + "']";
    jQuery(selector).last().after('<input class="form-control b2s-post-item-details-tag-input-elem" data-network-auth-id="' + networkAuthId + '" value="" name="b2s[' + networkAuthId + '][tags][]">');
    jQuery(".remove-tag-btn[data-network-auth-id='" + networkAuthId + "'").show();
}

function removeTag(networkAuthId) {
    var selector = ".b2s-post-item-details-tag-input-elem[data-network-auth-id='" + networkAuthId + "']";
    jQuery(selector).last().remove();
    if (jQuery(selector).length === 1)
        jQuery(".remove-tag-btn[data-network-auth-id='" + networkAuthId + "'").hide();
}

function networkLimitAll(networkAuthId, networkId, limit) {
    var regX = /(<([^>]+)>)/ig;
    var url = jQuery(".b2s-post-item-details-item-url-input[data-network-auth-id='" + networkAuthId + "']").val();
    var text = jQuery(".b2s-post-item-details-item-message-input[data-network-auth-id='" + networkAuthId + "']").val();
    jQuery(".b2s-post-item-details-item-url-input[data-network-auth-id='" + networkAuthId + "']").removeClass("error");
    if (url.length != "0") {
        if (url.indexOf("http://") == -1 && url.indexOf("https://") == -1) {
            url = "http://" + url;
            jQuery(".b2s-post-item-details-item-url-input[data-network-auth-id='" + networkAuthId + "']").val(url);
        }
    } else if (jQuery(".b2s-post-item-details-item-url-input[data-network-auth-id='" + networkAuthId + "']").hasClass("required_network_url")) {
        url = jQuery("#b2sDefault_url").val();
        jQuery(".b2s-post-item-details-item-url-input[data-network-auth-id='" + networkAuthId + "']").val(url);
    }

    var textLength = text.length;
    var newText = text;
    if (networkId == "2") { //twitter
        if (url.length != "0") {
            limit = limit - 24;
        }
    }

    if (textLength >= limit) {
        newText = text.substring(0, limit);
        var pos = getCaretPos(this);
        jQuery(".b2s-post-item-details-item-message-input[data-network-auth-id='" + networkAuthId + "']").val(newText.replace(regX, ""));
        setCaretPos(this, pos);
        var text = jQuery(".b2s-post-item-details-item-message-input[data-network-auth-id='" + networkAuthId + "']").val();
        var textLength = text.length;
    }
    var newLen = limit - textLength;
    jQuery(".b2s-post-item-countChar[data-network-auth-id='" + networkAuthId + "']").html(newLen);
}

function networkCount(networkAuthId) {
    var url = jQuery(".b2s-post-item-details-item-url-input[data-network-auth-id='" + networkAuthId + "']").val();
    var text = jQuery(".b2s-post-item-details-item-message-input[data-network-auth-id='" + networkAuthId + "']").val();
    jQuery(".b2s-post-item-details-item-url-input[data-network-auth-id='" + networkAuthId + "']").removeClass("error");
    if (url.length != "0") {
        if (url.indexOf("http://") == -1 && url.indexOf("https://") == -1) {
            url = "http://" + url;
            jQuery(".b2s-post-item-details-item-url-input[data-network-auth-id='" + networkAuthId + "']").val(url);
        }
    } else if (jQuery(".b2s-post-item-details-item-url-input[data-network-auth-id='" + networkAuthId + "']").hasClass("required_network_url")) {
        url = jQuery("#b2sDefault_url").val();
        jQuery(".b2s-post-item-details-item-url-input[data-network-auth-id='" + networkAuthId + "']").val(url);
    }
    var textLength = text.length;
    jQuery(".b2s-post-item-countChar[data-network-auth-id='" + networkAuthId + "']").html(textLength);
}


function getCaretPos(domElem) {
    var pos;
    if (document.selection) {
        domElem.focus();
        var sel = document.selection.createRange();
        sel.moveStart("character", -domElem.value.length);
        pos = sel.text.length;
    } else if (domElem.selectionStart || domElem.selectionStart == "0")
        pos = domElem.selectionStart;
    return pos;
}

function setCaretPos(domElem, pos) {
    if (domElem.setSelectionRange) {
        domElem.focus();
        domElem.setSelectionRange(pos, pos);
    } else if (domElem.createTextRange) {
        var range = domElem.createTextRange();
        range.collapse(true);
        range.moveEnd("character", pos);
        range.moveStart("character", pos);
        range.select();
    }
}

function ucfirst(str) {
    str += '';
    return str.charAt(0).toUpperCase() + str.substr(1);
}


function hideDuplicateAuths() {
    jQuery(".b2s-sidbar-wrapper-nav-li").each(function () {
        jQuery(this).show();
    });
    var mandantId = jQuery('.b2s-network-details-mandant-select').val();
    jQuery(".b2s-sidbar-wrapper-nav-li").each(function () {
        if (jQuery(this).is(":visible")) {
            var dataNetworkDisplayName = jQuery(this).children('.b2s-network-select-btn').attr('data-network-display-name');
            var dataNetworkId = jQuery(this).children('.b2s-network-select-btn').attr('data-network-id');
            var dataNetworkType = jQuery(this).children('.b2s-network-select-btn').attr('data-network-type');
            var dataNetworkAuthId = jQuery(this).children('.b2s-network-select-btn').attr('data-network-auth-id');
            jQuery('.b2s-network-select-btn[data-network-display-name="' + dataNetworkDisplayName + '"][data-network-id="' + dataNetworkId + '"][data-network-type="' + dataNetworkType + '"][data-network-auth-id!="' + dataNetworkAuthId + '"]').each(function () {
                var selectedDataMandantId = jQuery.parseJSON(jQuery(this).parents('.b2s-sidbar-wrapper-nav-li').attr('data-mandant-id'));
                if (jQuery(this).parents('.b2s-sidbar-wrapper-nav-li').attr('data-mandant-default-id') != mandantId && selectedDataMandantId.indexOf(mandantId) == -1) {
                    jQuery(this).parents('.b2s-sidbar-wrapper-nav-li').hide();
                }
            });
        }
    });
}

function chooseMandant() {
//Laden abbrechen und anzeige zurück setzten
    jQuery.xhrPool.abortAll();
    jQuery('.b2s-post-item-loading-dummy').remove();
    jQuery('.b2s-network-status-img-loading').hide();
    jQuery('.b2s-network-select-btn-deactivate').removeClass('b2s-network-select-btn-deactivate');
    imageCheck();
    //expiredDate wieder setzten
    jQuery('.b2s-network-status-expiredDate').each(function () {
        if (jQuery(this).is(':visible')) {
            jQuery('.b2s-network-select-btn[data-network-auth-id="' + jQuery(this).attr('data-network-auth-id') + '"').addClass('b2s-network-select-btn-deactivate');
        }
    });
    jQuery('.b2s-network-select-btn-deactivate')
    var mandantId = jQuery('.b2s-network-details-mandant-select').val();
    jQuery('.b2s-post-item').hide();
    jQuery('.b2s-post-item').find('.form-control').each(function () {
        jQuery(this).attr("disabled", "disabled");
    });
    jQuery('.b2s-network-select-btn').children().removeClass('active').find('.b2s-network-status-img').addClass('b2s-network-hide');
    //Check IS RE-PUBLISH
    if (jQuery('#b2sSelectedNetworkAuthId').val() > 0 && jQuery(".b2s-network-select-btn[data-network-auth-id='" + jQuery('#b2sSelectedNetworkAuthId').val() + "']").length > 0) { //exisits?
        jQuery(".b2s-network-select-btn[data-network-auth-id='" + jQuery('#b2sSelectedNetworkAuthId').val() + "']").trigger('click');
        var mandantId = jQuery(".b2s-network-select-btn[data-network-auth-id='" + jQuery('#b2sSelectedNetworkAuthId').val() + "']").parent('.b2s-sidbar-wrapper-nav-li').attr('data-mandant-id');
        jQuery('.b2s-network-details-mandant-select').val(mandantId);
        jQuery('#b2sSelectedNetworkAuthId').val("0");
    } else {
        jQuery(".b2s-sidbar-wrapper-nav-li").each(function () {
            var mandantIds = jQuery.parseJSON(jQuery(this).attr('data-mandant-id'));
            if (mandantIds.indexOf(mandantId) != -1 && !jQuery(this).children('.b2s-network-select-btn').hasClass('b2s-network-select-btn-deactivate')) {
                jQuery(this).children('.b2s-network-select-btn').trigger('click');
            }
        });
    }

    checkNetworkSelected();
}

function padDate(n) {
    return ("0" + n).slice(-2);
}

function wop(url, name) {
    jQuery('.b2s-network-auth-success').hide();
    var location = window.location.protocol + '//' + window.location.hostname;
    url = encodeURI(url + '&mandant_id=' + jQuery('.b2s-network-details-mandant-select').val() + '&location=' + location);
    window.open(url, name, "width=650,height=900,scrollbars=yes,toolbar=no,status=no,resizable=no,menubar=no,location=no,directories=no,top=20,left=20");
}

function loginSuccess(networkId, networkType, displayName, networkAuthId, mandandId) {
    jQuery('.b2s-network-auth-success').show();
    jQuery('#b2s-network-list-modal').modal('hide');
    jQuery('#b2s-network-list-modal').hide();
    jQuery('body').removeClass('modal-open');
    jQuery('body').removeAttr('style');
    if (jQuery('.b2s-network-select-btn[data-network-auth-id="' + networkAuthId + '"]').length == 0) {
        jQuery('.b2s-server-connection-fail').hide();
        jQuery.ajax({
            url: ajaxurl,
            type: "POST",
            dataType: "json",
            cache: false,
            data: {
                'action': 'b2s_ship_navbar_item',
                'networkId': networkId,
                'networkType': networkType,
                'displayName': displayName,
                'networkAuthId': networkAuthId,
                'mandandId': mandandId
            },
            error: function () {
                jQuery('.b2s-server-connection-fail').show();
                return false;
            },
            success: function (data) {
                if (data.result == true) {
                    jQuery(data.content).insertAfter('.b2s-sidbar-network-auth-btn');
                    imageCheck();
                    jQuery('.b2s-network-select-btn[data-network-auth-id="' + data.networkAuthId + '"]').trigger('click');
                }
            }
        });
    } else {
        jQuery('.b2s-network-status-expiredDate').remove();
        jQuery('.b2s-network-select-btn[data-network-auth-id="' + networkAuthId + '"]').removeClass('b2s-network-select-btn-deactivate');
        jQuery('.b2s-network-select-btn[data-network-auth-id="' + networkAuthId + '"]').removeAttr('onclick');
        jQuery('.b2s-network-select-btn[data-network-auth-id="' + networkAuthId + '"]').trigger('click');
    }
}