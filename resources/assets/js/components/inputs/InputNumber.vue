<template>
    <div class="form-group" :class="{ 'has-danger': error }">
        <label v-if="label" v-text="label" :for="id"></label>

        <input type="number" class="form-control"
               :id="id" :placeholder="label" :value="value" :min="min" :max="max" :step="step"
               @input="updateValue($event.target.value)"/>

        <span class="text-danger" v-if="error" v-text="error"></span>

        <slot></slot>
    </div>
</template>

<script>
    import InputField from "../../mixins/InputField";

    export default {
        mixins: [InputField],

        props: {
            min: {
                default: 0,
            },

            max: {
                default: null,
            },

            step: {
                default: 1,
            },
        },
    };
</script>