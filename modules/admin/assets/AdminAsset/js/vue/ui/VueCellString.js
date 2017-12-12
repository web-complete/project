Vue.component('VueCellString', {
    template: `
<span>{{value}}</span>
    `,
    props: {
        value: {required: true}
    }
});
