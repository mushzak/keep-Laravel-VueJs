<template></template>

<script>
	export default {
		props: {
			message: {
				type: String,
				required: true,
			},

			level: {
				type: String,
				default: 'info',
			},

			title: {
				type: String,
				default: null,
			},

			options: {
				type: Object,
			},
		},

		mounted() {
			toastr[this.level](this.message, this.title, toastr.options);
		},
	}
</script>
