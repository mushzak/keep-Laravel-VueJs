<template>
    <div class="form-check" :class="{ 'has-danger': error }">
        <label class="form-check-label">
            <input class="form-check-input" type="checkbox" :checked="value"
                   @change="updateValue($event.target.checked)"/> {{ label }}
        </label>

        <slot></slot>
    </div>
</template>

<script>
	import InputField from "../../mixins/InputField";

	export default {
		mixins: [InputField],

		props: {
			value: {
				default: false,
			},
		},
	}
</script>
