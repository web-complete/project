Vue.component('VueCellSex', {
    template: `
<div class="text-center">
    <span class="field-sex" :class="value"></span>
</div>
    `,
    props: {
        value: {required: true}
    }
});
