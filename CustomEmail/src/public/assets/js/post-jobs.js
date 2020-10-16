var formSubmit = function (_form) {

    var frm = jQuery(_form);
    var btn = frm.find(".saveBtn");
    var msg = frm.find("#msg");
    axios({
        method: 'post',
        url: frm.attr('action'),
        data: frm.serialize(),
        onUploadProgress: function (progressEvent) {
            msg.hide();
            startLoader(btn);
        }
    })
        .then(function (response) {
            if (response.data) {
                $(window).scrollTop(0);
                frm.find('.form-group').removeClass('error');
                frm.find('.help-block').html('');
                if (response.data.success) {
                    frm[0].reset();
                    msg.removeClass('alert-danger');
                    msg.addClass('alert-success');
                    msg.show();
                    msg.find('.alert-text').html(response.data.message);
                    endLoader(btn);

                    setTimeout(function () {
                        window.location.href = response.data.redirect;
                    }, 1000);
                    setTimeout(function () {
                        msg.fadeOut(500);
                    }, 3000);
                } else {
                    msg.removeClass('alert-success');
                    msg.addClass('alert-danger');
                    msg.show();
                    msg.find('.alert-text').html(response.data.message);
                    endLoader(btn);
                    setTimeout(function () {
                        msg.fadeOut(500);
                    }, 3000);
                }
            }
        })
        .catch(function (error) {
            endLoader(btn);
            if (error.response) {
                if (error.response.status == "419") {
                    toastr.error('Page session expired');
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                }
                $(window).scrollTop(0);
                var errors = error.response.data.errors;
                frm.find('.form-group').removeClass('error');
                frm.find('.help-block').html('');
                var checkFirstEle = 0;
                jQuery.each(errors, function (i, _msg) {
                    var el = frm.find("[name=" + i + "]");
                    if (checkFirstEle == 0) {
                        el.focus();
                        checkFirstEle++;
                    }
                    el.parents('.form-group').addClass('error');
                    el.parents('.form-group').find('.help-block').html(_msg[0]);
                });
            }
        });
    return false;
};

var updateForm = function (_form) {

    var frm = jQuery(_form);
    var btn = frm.find(".saveBtn");
    var msg = frm.find("#msg");

    axios({
        method: 'post',
        url: frm.attr('action'),
        data: frm.serialize(),
        onUploadProgress: function (progressEvent) {
            msg.hide();
            startLoader(btn);
        }
    })
        .then(function (response) {
            if (response.data) {
                $(window).scrollTop(0);
                frm.find('.form-group').removeClass('error');
                frm.find('.help-block').html('');
                if (response.data.success) {
                    msg.removeClass('alert-danger');
                    msg.addClass('alert-success');
                    msg.show();
                    msg.find('.alert-text').html(response.data.message);
                    endLoader(btn);
                   
                    setTimeout(function () {
                        window.location.href = response.data.redirect;
                    }, 1000);
                    setTimeout(function () {
                        msg.fadeOut(500);
                    }, 3000);

                } else {
                    endLoader(btn);
                }

            }
        })
        .catch(function (error) {
            endLoader(btn);
            if (error.response) {
                if (error.response.status == "419") {
                    toastr.error('Page session expired');
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                }
                $(window).scrollTop(0);
                var errors = error.response.data.errors;
                frm.find('.form-group').removeClass('error');
                frm.find('.help-block').html('');
                var checkFirstEle = 0;
                jQuery.each(errors, function (i, _msg) {
                    var el = frm.find("[name=" + i + "]");
                    if (checkFirstEle == 0) {
                        el.focus();
                        checkFirstEle++;
                    }
                    el.parents('.form-group').addClass('error');
                    el.parents('.form-group').find('.help-block').html(_msg[0]);
                });
            }
        });
    return false;
};

var startLoader = function (btn) {
    btn.addClass('kt-spinner');
    btn.addClass('kt-spinner--right');
    btn.addClass('kt-spinner--sm');
    btn.addClass('kt-spinner--light');
    btn.prop("disabled", true);
}

var endLoader = function (btn) {
    btn.removeClass('kt-spinner');
    btn.removeClass('kt-spinner--right');
    btn.removeClass('kt-spinner--sm');
    btn.removeClass('kt-spinner--light');
    btn.prop("disabled", false);
};