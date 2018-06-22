export default {
    props: {
        label: {
            type: String,
            default: '',
        },

        placeholder: {
            type: String,
            default: '',
        },

        id: {
            type: String,
            default: '',
        },

        error: {
            type: String,
            default: '',
        },

        value: {
            default: '',
        },
    },

    methods: {
        updateValue(value) {
            this.$emit('input', value);
        },
    },
}