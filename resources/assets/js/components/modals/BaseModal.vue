<template>
    <div class="">
        <a href="#"
           :class="showModalButtonClasses"
           @click.prevent="modalShow = !modalShow"
           ><slot name="button"></slot></a>
        <b-modal v-model="modalShow" :title="title" size="lg" busy lazy hide-footer>
            <slot></slot>
        </b-modal>
    </div>
</template>

<script>
    export default {
        props: {
            showModalButtonText: {
                type: String,
                default: 'View details',
            },

            showModalButtonClasses: {
                type: Array,
                default: function () {
                    return ['btn', 'btn-secondary'];
                },
            },

            title: {
                type: String,
                default: '',
            },
        },

        data() {
            return {
                modalShow: false,
            };
        },
    };
</script>
