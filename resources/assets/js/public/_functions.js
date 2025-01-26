String.prototype.replaceAll = function(search, replacement) {
    return this.replace(new RegExp(search, 'g'), replacement);
};

String.prototype.toSlug = function() {
    var string = this;
    string = string.replace(/^\s+|\s+$/g, '');
    string = string.toLowerCase();

    var from = "àáäâèéëêìíïîòóöôőùúüûűñ";
    var to = "aaaaeeeeiiiiooooouuuuun";

    for(var i=0, l=from.length ; i<l ; i++) {
        string = string.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    return string.replace(/[^a-z0-9 -]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
};

$.extend($.expr[":"], {
    "containsIN": function(elem, i, match) {
        return ((elem.textContent || elem.innerText || "").toSlug().replaceAll('-', '')).indexOf(match[3].toSlug().replaceAll('-', '') || "") >= 0;
    },
    "containsValue": function(elem, i, match) {
        return (elem.value.toSlug().replaceAll('-', '') || "").indexOf((match[3].toSlug().replaceAll('-', '') || "")) >= 0;
    }
});

var delay = (function(){
    var timer = 0;
    return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
    };
})();

function isset(value){
    return typeof value !== 'undefined' || false;
}

function empty(value){
    return isset(value) ? (value == '' || value.length == 0) : true;
}

function isJson(string){
    try {
        return JSON.parse(string);
    } catch(e) {
        return false;
    }
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie(cname) {
    return getCookie(cname) ? true : false;
}

function route(name, variables){
    return routes.route(name, variables);
}

function dd(){
    for(var i = 0; i < arguments.length; i++){
        console.log(arguments[i]);
    }

    throw 'Script stop';
}

function gtag(){
    dataLayer.push(arguments);
}