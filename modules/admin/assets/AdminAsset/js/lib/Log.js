Log = {
    LEVEL_INFO: 200,
    LEVEL_WARNING: 300,
    LEVEL_ERROR: 400,
    LEVEL_CRITICAL: 500,

    initHandler: function () {
        window.onerror = function (errorMsg, url, lineNumber, column, errorObj) {
            if (window.Notify) Notify.error('Ошибка js');
            this.exception(errorMsg, url, errorObj);
            return false;
        }.bind(this);
        if (Vue) {
            Vue.config.errorHandler = function (err, vm, info) {
                if (window.Notify) Notify.error('Ошибка Vue');
                this.error('Vue [' + vm.$options.name + ']: ' + err.stack + "\n" + info);
            }.bind(this);
            Vue.config.warnHandler = function (msg, vm, trace) {
                if (window.Notify) Notify.error('Ошибка Vue');
                this.error('Vue: ' + msg + "\n" + trace);
            }.bind(this);
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