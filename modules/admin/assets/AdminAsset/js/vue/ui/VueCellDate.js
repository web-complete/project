Vue.component('VueCellDate', {
    template: `
<span class="field-date" v-if="value">
    {{date}}
</span>
    `,
    props: {
        value: {required: true},
        cellParams: Object
    },
    computed: {
        date(){
            return moment(this.value).format(this.cellParams.dateFormat);
        }
    }
});
