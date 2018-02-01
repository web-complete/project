VueMixinProcessEntityErrors = {
    methods: {
        processEntityErrors(response){
            _.each(this.detailFields, function(field) {
                this.$set(field, 'error', null);
                if (response.errors && response.errors[field.name]) {
                    field.error = response.errors[field.name];
                }
                this.$set(field, 'multilangError', null);
                if (response.multilangErrors && response.multilangErrors[field.name]) {
                    field.multilangError = response.multilangErrors[field.name];
                }
            }.bind(this));
        }
    }
};
