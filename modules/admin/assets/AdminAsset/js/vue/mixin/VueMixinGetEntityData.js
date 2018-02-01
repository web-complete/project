VueMixinGetEntityData = {
    methods: {
        getEntityData(append){
            let data = {};
            _.each(this.detailFields, function(field){
                data[field.name] = field.value;
            });

            if (this.isMultilang) {
                data.multilang = {};
                _.each(this.detailFields, function(field){
                    if (field.isMultilang) {
                        _.each(this.$store.state.lang.langs, function(lang){
                            if (!lang.is_main) {
                                data.multilang[lang.code] = data.multilang[lang.code] || {};
                                data.multilang[lang.code][field.name] = field.multilangData[lang.code] || '';
                            }
                        }.bind(this));
                    }
                }.bind(this));
            }

            _.extend(data, append || {});
            return {id: this.entityId, data: data};
        }
    }
};
