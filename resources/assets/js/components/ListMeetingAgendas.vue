<template>
    <div>
        todo list meeting agendas
    </div>
</template>

<script>
    export default {
        components: {
            //
        },

        props: {
            meeting: {
                type: Object,
                required: true,
            },

            agendas: {
                type: Array,
                required: true,
            },
        },

        computed: {

        },

        data() {
            return {
                //
            };
        },

        methods: {
            //
        },
    };
</script>
