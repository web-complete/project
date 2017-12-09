FieldHelper = {

    map: function(code){
        var result;
        switch (code) {
            case 'string':
            default:
                result = 'VueFieldString';
                break;
        }
        return result;
    }
};