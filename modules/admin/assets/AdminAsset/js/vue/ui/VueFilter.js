Vue.component('VueFilter', {
    template: `
<div v-if="filterFields.length">
    <button @click="openModal" :class="{_active: filterLength}" class="filter-button">Фильтр: <span>{{filterLength}}</span></button>
    <modal :name="'modal-filter'" width="600px" height="auto">
        <h1>Фильтр</h1>
        <div class="popup-content">
            <form @submit.prevent="submit" class="form-filter">
                <div v-for="field in filterFields">
                    <component :is="field.component"
                               :fieldParams="field.fieldParams"
                               :label="field.title"
                               :name="field.name"
                               v-model="field.value"
                    ></component>
                </div>
                <div class="form-actions">
                    <button @click.prevent="submit" class="button" type="submit">Применить</button>
                    <button @click.prevent="reset" class="button gray" type="reset">Сбросить</button>
                </div>
            </form>
        </div>
    </modal>
</div>
    `,
    props: {
        filterFields: {required: true, type: Array}
    },
    data(){
        return {
            filter: {}
        }
    },
    computed: {
        filterLength(){
            return Object.keys(this.filter).length;
        }
    },
    methods: {
        openModal(){
            this.$modal.show('modal-filter');
        },
        closeModal(){
            this.$modal.hide('modal-filter');
        },
        reset(){
            this.filter = {};
            _.each(this.filterFields, function(field){
                field.value = '';
            });
            this.closeModal();
            this.$emit('applyFilter', this.filter);
        },
        submit(){
            this.filter = {};
            _.each(this.filterFields, function(field){
                if (field.value.length) {
                    this.filter[field.name] = field.value;
                }
            }.bind(this));
            this.closeModal();
            this.$emit('applyFilter', this.filter);
        }
    }
});
