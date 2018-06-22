<template>
    <div class="form-group" :class="{ 'has-danger': error }">
        <label v-if="label" v-text="label" :for="id"></label>
        <textarea class="form-control" :id="id" :placeholder="label" :rows="rows" :value="value" data-autosize @input="updateValue($event.target.value)"></textarea>

        <p class="text-danger" v-if="error" v-text="error"></p>

        <slot></slot>
    </div>
</template>

<script>
    import InputField from "../../mixins/InputField";
    import autosize from "autosize";

    export default {
        mixins: [ InputField ],

        props: {
            rows: {
                type: Number,
                default: 1,
            },
        },

        mounted() {
            autosize(document.querySelectorAll("*[data-autosize]"));
        },
    }
</script>
