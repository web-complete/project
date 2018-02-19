Vue.component('VueMultilangSelect', {
    // language=Vue
    template: `
        <div v-if="langs.length > 1" class="form-row">
            <label><b>Перевод</b></label>
            <div class="button-set">
                <button type="button" @click="select('0')" :class="{'_active': selected === '0'}">Все</button>
                <button type="button" v-for="lang in langs" @click="select(lang.code)" :class="{'_active': selected === lang.code}">{{lang.code}}</button>
            </div>
        </div>    
    `,
    data(){
        return {
            selected: this.$store.getters.mainLang.code
        }
    },
    computed: {
        langs: function(){
            return this.$store.state.lang.langs;
        }
    },
    methods: {
        select(code){
            this.selected = code;
            this.$emit('input', code);
        }
    }
});
