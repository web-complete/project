Log = {
    LEVEL_INFO: 200,
    LEVEL_WARNING: 300,
    LEVEL_ERROR: 400,
    LEVEL_CRITICAL: 500,

    initHandler: function () {
        if (typeof jQuery !== 'undefined') {
            $(document).ready(function(){
                $(document).ajaxError(function (event, jqxhr, settings, errorObj) {
                    this.exception('ajaxError', document.location.href, errorObj);
                }.bind(this));
            }.bind(this));
            window.onerror = function (errorMsg, url, lineNumber, column, errorObj) {
                this.exception(errorMsg, url, errorObj);
                return false;
            }.bind(this);
            if (window.Vue) {
                Vue.config.errorHandler = function (err, vm, info) {
                    this.error('Vue [' + vm.$options.name + ']: ' + err.stack + "\n" + info);
                }.bind(this);
                Vue.config.warnHandler = function (msg, vm, trace) {
                    this.error('Vue: ' + msg + "\n" + trace);
                }.bind(this);
            }
        }
    },

    info: function (message, category) {
        category = category || 'js';
        this._log(this.LEVEL_INFO, message, category);
        console.info(message, category);
    },

    warning: function (message, category) {
        category = category || 'js';
        this._log(this.LEVEL_WARNING, message, category);
        console.info(message, category);
    },

    error: function (message, category) {
        category = category || 'js';
        this._log(this.LEVEL_ERROR, message, category);
        console.error(message, category);
    },

    exception: function (message, url, exception, category) {
        category = category || 'js';
        message = message + "\nURL: " + url + "\nSTACK: " + exception.stack;
        this._log(this.LEVEL_ERROR, message, category);
        console.error(message, category);
    },

    _log: function (level, message, category) {
        $.post('/api/log', {level: level, message: message, category: category})
    }
};