Vue.component('VueFieldString', {
    // language=Vue
    template: '<div class="form-row">\n    <label>{{label}}</label>\n    <input :type="type"\n           :name="name"\n           :value="value"\n           :title="label"\n           :placeholder="placeholder"\n           :disabled="disabled"\n           :maxlength="maxlength"\n           @input="$emit(\'input\', $event.target.value)"\n    />\n</div>',
    props: {
        label: String,
        type: {type: String, default: 'text'},
        name: {type: String, required: true},
        value: [String, Number],
        placeholder: String,
        disabled: Boolean,
        maxlength: Number
    }
});
