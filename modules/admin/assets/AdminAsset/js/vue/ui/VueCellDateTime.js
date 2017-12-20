Vue.component('VueCellDateTime', {
    template: `
<span class="field-date" v-if="value">
    {{date}}<br><span>{{time}}</span>
</span>
    `,
    props: {
        value: {required: true},
        cellParams: Object
    },
    computed: {
        date(){
            return moment(this.value).format(this.cellParams.dateFormat);
        },
        time(){
            return moment(this.value).format(this.cellParams.timeFormat);
        }
    }
});
