Vue.component('VueCellDate', {
    template: `
<span class="field-date" v-if="value">
    {{date}}
    <template v-if="timeFormat">
        <br><span>{{time}}</span>
    </template>
</span>
    `,
    props: {
        value: {required: true},
        dateFormat: {default: 'DD.MM.YYYY'},
        timeFormat: {default: 'HH:mm:ss'}
    },
    computed: {
        date(){
            return moment(this.value).format(this.dateFormat);
        },
        time(){
            if (this.timeFormat) {
                return moment(this.value).format(this.timeFormat);
            }
        }
    }
});
