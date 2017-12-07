Vue.component('VueTab', {
    // language=Vue
    template: '<div v-show="selected"><slot></slot></div>',
    props: {
        name: {required: true},
        active: {default: false}
    },
    data: function(){
        return {
            selected: false
        }
    },
    mounted: function(){
        this.selected = this.active;
    }
});