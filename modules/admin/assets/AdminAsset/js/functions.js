extendVuePage = function(parent, current){
    return _.merge({}, parent, current);
};

uniqueId = function(length){
    length = length || 32;
    var idStr = String.fromCharCode(Math.floor((Math.random()*25)+65));
    do {
        var code = Math.floor((Math.random()*42)+48);
        if (code<58 || code>64){
            idStr += String.fromCharCode(code);
        }
    } while (idStr.length < length);

    return (idStr);
};
