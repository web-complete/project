Vue.component('VueMultilangSelect', {
    template: `
<div class="form-row">
    <label><b>Перевод</b></label>
    <select class="select2">
        <option value="0">Все языки</option>
        <option v-for="lang in langs" :value="lang.code" :selected="lang.is_main">{{lang.name}}</option>
    </select>
</div>    
    `,
    computed: {
        langs: function(){
            return this.$store.state.lang.langs;
        }
    },
    mounted: function(){
        let self = this;
        $(this.$el).find('select').select2().on('change', function(){
            self.$emit('input', $(this).val());
        });
    },
    destroyed: function(){
        $(this.$el).hide().find('select').select2('destroy');
    }
});
