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

Array.prototype.max = function() {
    return Math.max.apply(null, this);
};

Array.prototype.min = function() {
    return Math.min.apply(null, this);
};

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
    return isset(value) ? (value == null || value == '' || value.length == 0) : true;
}

function isJson(string){
    try {
        return JSON.parse(string);
    } catch(e) {
        return false;
    }
}

function changeSubmit(element, value) {
    $(element).closest('form').find('#submit').val(value);
}

function array_remove(array, id){
    var index = array.indexOf(id);

    if(index > -1){
        array.splice(index, 1);
    }
}

function isFixed(el) {
    var parent = el.offsetParent();

    return parent.prop("tagName") === 'HTML' ? false : ((parent.css("position") !== 'fixed') ? isFixed(parent): parent);
}