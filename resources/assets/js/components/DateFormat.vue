<template>
    <span>{{ dateValue }}</span>
</template>

<script>
	let moment = require('moment');

	export default {
		props: {
			value: {
				required: true,
			},

			format: {
				default: "DD MMMM YYYY, h:mm:ss a",
			},
		},

		computed: {
			dateValue() {
				return moment(this.value)
					.local()
					.format(this.format);
			},
		},
	}
</script>