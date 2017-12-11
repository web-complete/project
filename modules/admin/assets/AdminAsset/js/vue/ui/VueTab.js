Vue.component('VueTab', {
    template: `
        <div v-show="selected" :key="name">
            <slot></slot>
        </div>
    `,
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