<template>
    <div class="form-group" :class="{ 'has-danger': error }">
        <label v-if="label" v-text="label" :for="id"></label>
        <select class="form-control" :id="id" :value="value" @input="updateValue($event.target.value)">
            <option v-for="(value, name) in options" v-text="value" :value="name"></option>
        </select>

        <p class="text-danger" v-if="error" v-text="error"></p>

        <slot></slot>
    </div>
</template>

<script>
	import InputField from "../../mixins/InputField";

	export default {
		mixins: [InputField],

		props: {
			options: {
				type: Object,
				required: true,
			},
		},
	}
</script>
