Rbac = {

    check: function(permissionName){
        if (!permissionName) return true;
        return _.indexOf(store.state.user.permissions, permissionName) !== -1;
    }
};
