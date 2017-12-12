Vue.component('VueCellCheckbox', {
    template: `
<div class="text-center">
    <i v-if="value" class="field-bool _y ion-checkmark"></i>
    <i v-else class="field-bool _n ion-close"></i>
</div>
    `,
    props: {
        value: {required: true}
    }
});
