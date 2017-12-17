Vue.component('VueButton', {
    template: `
<button @click="$emit('click', $event)" type="button" class="button">
    <slot></slot>
</button>
    `
});
