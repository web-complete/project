Notify = {

    _position: 'top-right',
    _duration: 1500,
    _successDefaultText: 'Выполнено успешно',
    _errorDefaultText: 'Ошибка выполнения',

    successDefault: function(){
        this.success(this._successDefaultText);
    },

    errorDefault: function(){
        this.error(this._errorDefaultText);
    },

    success: function(message){
        bus.$toasted.show(message, {
            type: 'success',
            position: this._position,
            icon: '',
            iconPack: 'fontawesome',
            duration: this._duration
        });
    },

    info: function(message){
        bus.$toasted.show(message, {
            type: 'info',
            position: this._position,
            icon: '',
            iconPack: 'fontawesome',
            duration: this._duration
        });
    },

    error: function(message){
        bus.$toasted.show(message, {
            type: 'error',
            position: this._position,
            icon: '',
            iconPack: 'fontawesome',
            duration: this._duration
        });
    }
};
