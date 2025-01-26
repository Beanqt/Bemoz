var Request = function(){};

Request.prototype.get = function(url, type, options){
    options = $.extend({
        url: url,
        dataType: isset(type) ? type : 'json'
    }, options);

    return $.ajax(options);
};

Request.prototype.post = function(url, data, type, options){
    options = $.extend({
        url: url,
        method: 'post',
        data: data,
        dataType: isset(type) ? type : 'json'
    }, options);

    return $.ajax(options);
};

function get(url, type, options){
    return new Request().get(url, type, options);
}
function post(url, data, type, options){
    return new Request().post(url, data, type, options);
}