VuePageLangDetail = extendVuePage(VuePageEntityDetail, {
    computed: {
        entityName(){
            return 'system-lang';
        }
    },
    methods: {
        saveItem($e, toContinue){
            Request.post(this.apiUrl, this.getEntityData(), function(response){
                if (response.result) {
                    if (response.state) {
                        this.$store.commit('updateLangState', response.state);
                    }
                    Notify.successDefault();
                    if (toContinue) {
                        this.$router.push('/detail/' + this.entityName + '/' + response.id);
                    } else {
                        this.$router.push(this.listRoute);
                    }
                } else {
                    Notify.error(response.error || 'Ошибка сохранения');
                }
                this.processEntityErrors(response);
            }.bind(this));
        },
        deleteItem(){
            Modal.confirm('Вы уверены?', function(){
                Request.delete(this.apiUrl, {id: this.entityId}, function(response){
                    if (response.state) {
                        this.$store.commit('updateLangState', response.state);
                    }
                    Notify.successDefault();
                    this.$router.push(this.listRoute);
                }.bind(this));
            }.bind(this));
        }
    }
});
