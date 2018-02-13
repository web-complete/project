VueMixinRbac = {
    methods: {
        isAllowed(permission){
            return Rbac.check(permission);
        }
    }
};
