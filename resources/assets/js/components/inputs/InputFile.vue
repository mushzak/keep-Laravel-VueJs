<template>
    <div class="form-group" :class="{ 'has-danger': error }">
        <label v-if="label" v-text="label" :for="id"></label>
        <input type="file" class="form-control" :id="id" :placeholder="label" :value="value" @change="updateValue($event.target.files[0])" />

        <span class="text-danger" v-if="error" v-text="error"></span>

        <slot></slot>
    </div>
</template>

<script>
    import InputField from "../../mixins/InputField";

    export default {
        mixins: [ InputField ],
    }
</script>