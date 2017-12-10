FieldHelper = {

    map: function(code){
        let result;
        switch (code) {
            case 'checkbox':
                result = 'VueFieldCheckbox'; break;
            case 'select':
                result = 'VueFieldSelect'; break;
            case 'textarea':
                result = 'VueFieldTextarea'; break;
            case 'redactor':
                result = 'VueFieldRedactor'; break;
            case 'file':
                result = 'VueFieldFile'; break;
            case 'image':
                result = 'VueFieldImage'; break;
            case 'string':
            default:
                result = 'VueFieldString'; break;
        }
        return result;
    }
};