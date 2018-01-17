Vue.component('VueField', {
    template: `
        <div>
            <component v-if="!field.isMultilang"
                       :is="field.component"
                       :fieldParams="field.fieldParams"
                       :label="field.title"
                       :name="field.name"
                       :error="field.error"
                       :key="field.name"
                       v-model="field.value"
                       @input="field.error = null"
            ></component>
            
            <template v-else v-for="lang in $store.state.lang.langs">
                <component v-if="currentLang == 0 || currentLang === lang.code || getError(lang)"
                           :is="field.component"
                           :fieldParams="field.fieldParams"
                           :label="field.title + ' (' + lang.code + ')'"
                           :name="field.name"
                           :error="getError(lang)"
                           :key="field.name + '_' + lang.code"
                           :value="getValue(lang)"
                           @input="setValue(lang, $event)"
                ></component>
            </template>
        </div>
    `,
    props: {
        field: Object,
        currentLang: String
    },
    created(){
        if (_.isArray(this.field['multilangData'])) {
            this.field['multilangData'] = {};
        }
    },
    methods: {
        getValue(lang){
            return lang['is_main']
                ? this.field.value
                : this.field['multilangData'][lang.code];
        },
        setValue(lang, value){
            lang['is_main']
                ? this.field.value = value
                : this.$set(this.field['multilangData'], lang.code, value);
        },
        getError(lang){
            if (lang['is_main']) {
                return this.field.error;
            } else if (this.field['multilangError']) {
                return this.field['multilangError'][lang.code];
            }
        }
    }
});
