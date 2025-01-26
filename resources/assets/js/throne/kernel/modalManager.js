var modalManager = function(options){
    this.options = options;
    this.modal, this.acceptBtn, this.closeBtn = '';

    this.watch();
};

modalManager.prototype = {
    watch: function(){
        app.document.on('click', '[data-modal-accept]', function(e){
            e.preventDefault();
        });
    }
};

modalManager.prototype.setModal = function(target){
    this.modal = $(target);
};

modalManager.prototype.open = function(name, callback){
    var self = this;
    this.modal = $(name);
    this.acceptBtn = this.modal.find('[data-modal-accept]');

    if(typeof callback === 'function'){
        callback(self);
    }

    this.modal.modal('show');
    this.modal.on('hidden.bs.modal', function() {
        self.acceptBtn.unbind("click");
    });

    return this;
};

modalManager.prototype.accept = function(callback){
    var self = this;

    this.acceptBtn.click(function(){
        callback(self, this);
        self.acceptBtn.unbind("click");
    });
    return this;
};

modalManager.prototype.reject = function(callback){
    var self = this;

    this.modal.on('hidden.bs.modal', function() {
        callback(self, this);

        self.acceptBtn.unbind("click");
    });
    return this;
};

modalManager.prototype.close = function(){
    var self = this;

    this.modal.modal('hide');
    this.modal.on('hidden.bs.modal', function() {
        self.acceptBtn.removeClass('btn-loading').removeAttr('disabled').attr('href', '');
        self.acceptBtn.unbind("click");
    });
};