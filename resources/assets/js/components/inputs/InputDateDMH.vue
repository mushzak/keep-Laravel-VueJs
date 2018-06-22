<template>
    <div class="form-group" :class="{ 'has-danger': error }">
        <label v-if="label" v-text="label" :for="id"></label>
        <input type="date" class="form-control" :id="id" :placeholder="label" :value="value" @input="updateValue($event.target.value)"></input>

        <p class="text-danger" v-if="error" v-text="error"></p>

        <slot></slot>
    </div>
</template>

<script>
    import InputField from "../../mixins/InputField";

    export default {
        mixins: [ InputField ],

        props: {

        },

        mounted() {
            
        },
    }
</script>
