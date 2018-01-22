WCP = {

    getValue: function(object, path) {
        let value = null;
        if (path.indexOf('.') === -1) {
            return object[path];
        }
        path = path.split('.');
        _.each(path, function(node){
            value = (value === null) ? object[node] : value[node];
        });
        return value;
    }
};
