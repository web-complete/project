Vue.component('VueCellMap', {
    template: `
<span>{{mapValue}}</span>
    `,
    props: {
        value: {required: true},
        cellParams: Object
    },
    computed: {
        mapValue(){
            return this.cellParams['map'][this.value] || this.value;
        }
    }
});
