<template>
    <div>
        <button :type="type" class="btn" :class="classes" :disabled="disabled" v-text="label"></button>
        <i class="fa fa-spin fa-spinner ml-1" v-show="disabled"></i>
    </div>
</template>

<script>
    export default {
        props: {
            classes: {
                type: Array,
                default: () => {
                    return ["btn-primary"];
                },
            },

            disabled: {
                type: Boolean,
                default: false,
            },

            label: {
                type: String,
                required: true,
            },

            type: {
                type: String,
                default: "submit",
            },
        }
    };
</script>
