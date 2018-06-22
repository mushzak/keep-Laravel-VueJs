<template>
    <div class="form-group" :class="{ 'has-danger': error }">
        <label v-if="label" v-text="label" :for="id"></label>
        <input type="text" class="form-control" :id="id" :placeholder="placeholder" :value="value"
               @input="updateValue($event.target.value)"/>

        <span class="text-danger" v-if="error" v-text="error"></span>

        <slot></slot>
    </div>
</template>

<script>
    import InputField from "../../mixins/InputField";

    export default {
        mixins: [InputField],
    };
</script>