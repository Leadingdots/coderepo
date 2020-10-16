var getParameters = function () {
    var parameters = '';
    if ($('#q').val() != null && $('#q').val() != '')
        parameters += '&q=' + $('#q').val();
    return parameters;
};

var getParametersObject = function () {
    var parameters = new Object();
    parameters['sync'] = 1;
    if ($('#q').val() != null && $('#q').val() != '')
        parameters['q'] = $('#q').val();
    return parameters;
};

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};
    
var recordList = function(){
    var parameters = getParametersObject();
    var urlparameters = getParameters();
            $.ajax({
                url: tblObj.data('url'),
                type : 'GET',
                data : parameters,
                dataType: 'json',
                success: function(response) {
                        tblObj.find('tbody').html(response.rows);
                        tblObj.find('tfoot tr td').html(response.pagination);
                        reinitPagination();
                        window.history.replaceState({
                            isBackPage: false,
                            "html": 'jscv',
                            "pageTitle": 'bsckj'
                        }, "", listUrl + '?query=q' + urlparameters);
                    },
                error: function(response, code) {
                        if(response.status == "419"){
                            toastr.error('Page session expired');
                            setTimeout(function(){
                                location.reload();             
                                },2000);
                        }
                        toastr.error('Error in listing rows');
                    }
                });
        };

recordList();

var reinitPagination = function(){
    $('.pagination a').on('click', function(e){
        var parameters = getParameters();
        e.preventDefault();
        $("#record-list").data('url', ($(this).data('url') + parameters));
        recordList();
    });
}

var sortList = function(_ele, sort_ele){
    var obj = $(_ele);
    $('#sort_ele').val(sort_ele);
    if($('#sort_with').val() == "none" || $('#sort_with').val() == "desc")
    $('#sort_with').val('asc');
    else
    $('#sort_with').val('desc');
    searchUserPageList();
    $('#record-list thead tr th').each(function() { 
        $(this).find('i').removeClass('fa-caret-down');
        $(this).find('i').removeClass('fa-caret-up');
        $(this).find('i').addClass('fa-sort');
        });
        obj.find('i').removeClass('fa-sort');
        if($('#sort_with').val() == "none" || $('#sort_with').val() == "desc")
        obj.find('i').addClass('fa-caret-up');
        else
        obj.find('i').addClass('fa-caret-down');
}

var searchUserPageList = function(reset = true){
    if(reset)
    paginationURL(1);
    
    var parameters = getParametersObject();
    var urlparameters = getParameters();
    var tblObj = $("#record-list");
    $.ajax({
        url: searchUrl,
        type : 'GET',
        data : parameters,
        dataType: 'json',
        success: function(response) {
                tblObj.find('tbody').html(response.rows);
                tblObj.find('tfoot tr td').html(response.pagination);
                reinitSearchedUserPagePagination();
                window.history.replaceState({
                    isBackPage: false,
                    "html": 'jscv',
                    "pageTitle": 'bsckj'
                }, "", listUrl + '?query=q' + urlparameters);
            },
        error: function(response, code) {
                if(response.status == "419"){
                    toastr.error('Page session expired');
                    setTimeout(function(){
                        location.reload();             
                        },2000);
                }
                console.log('Error in listing rows');
            }
        });
            return false;
};

var reinitSearchedUserPagePagination = function(){
$('.pagination a').on('click', function(e){
    var parameters = getParameters();
    e.preventDefault();
    searchUrl = $(this).data('url') + parameters;
    searchUserPageList(false);
});
}

var deleteRecord = function(id, ele){
    if(confirm('Are you sure want to delete this record?'))
    {
        $.ajax({
            url: deleteUrl,
            type : 'DELETE',
            data : {id:id, _token:window.Laravel.csrfToken},
            dataType: 'json',
            success: function(response) {
                    ele.parents('tr').remove();
                    toastr.success(response.message);
                    reformatSerialNo(ele);
                    if(tblObj.find('tbody').find('tr').length == 0){
                        window.location.href = listUrl;
                    }
                },
            error: function(response, code) {
                    if(response.status == "419"){
                        toastr.error('Page session expired');
                        setTimeout(function(){
                            location.reload();             
                            },2000);
                    }
                    toastr.error(response.responseJSON.message);
                }
            });
    }
}

var changeStatus = function(id, ele){
    if(confirm('Are you sure want to change this status?'))
    {
        $.ajax({
            url: changeUrl,
            type : 'POST',
            data : {id:id, _token:window.Laravel.csrfToken},
            dataType: 'json',
        
            success: function(response) {
                toastr.success(response.message);
                if(ele.hasClass('btn-primary')){
                ele.removeClass('btn-primary');
                ele.addClass('btn-info');
                ele.html('Inactive');
                }else{
                ele.removeClass('btn-info');
                ele.addClass('btn-primary');
                ele.html('Active');
                }
            },
            error: function(response, code) {
                if(response.status == "419"){
                    toastr.error('Page session expired');
                    setTimeout(function(){
                        location.reload();             
                        },2000);
                }
                toastr.error(response.responseJSON.message);
            }
        });
    }
}

var paginationURL = function (page) {
    if (getUrlParameter('page') != null){
        var newUrl = location.href.replace("page="+encodeURIComponent(getUrlParameter('page').trim()), "page="+page);
        window.history.replaceState({
            isBackPage: false,
            "html": 'jscv',
            "pageTitle": 'bsckj'
        }, "", newUrl);
    }else if(window.location.search){
        window.history.replaceState({
            isBackPage: false,
            "html": 'jscv',
            "pageTitle": 'bsckj'
        }, "", window.location.href+'&page='+page);
    }else{
        window.history.replaceState({
            isBackPage: false,
            "html": 'jscv',
            "pageTitle": 'bsckj'
        }, "", window.location.href+'?page='+page);
    }
    }

var startLoader = function(btn){
    btn.addClass('kt-spinner');
    btn.addClass('kt-spinner--right');
    btn.addClass('kt-spinner--sm');
    btn.addClass('kt-spinner--light');
    btn.prop("disabled", true);
}

var endLoader = function(btn){
    btn.removeClass('kt-spinner');
    btn.removeClass('kt-spinner--right');
    btn.removeClass('kt-spinner--sm');
    btn.removeClass('kt-spinner--light');
    btn.prop("disabled", false);
}

var reformatSerialNo = function(ele){
    var tr = tblObj.find('tbody').find('tr');
    tr.each(function( index ) {
        $(this).find('th').html(index+1)
        });
}