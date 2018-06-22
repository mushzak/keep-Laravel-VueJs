<template>
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="#" @click.prevent="showingSideBar = !showingSideBar">
                <i class="fa fa-bars"></i>
            </a>

            <nav class="col-xs-10 col-sm-6 col-md-4 col-lg-3 bg-light d-flex flex-column flex-nowrap py-3" v-if="showingSideBar">
                <a class="nav-link" href="#" style="position: absolute; top: 1rem; right: 1rem;" @click.prevent="showingSideBar = !showingSideBar">
                    <i class="fa fa-close"></i>
                </a>

                <slot></slot>
            </nav>
        </li>
    </ul>
</template>

<script>
    export default {
        props: {
            //
        },

        data() {
            return {
                showingSideBar: false,
            };
        },

        methods: {
            //
        },
    };
</script>

<style lang="sass" scoped>
    nav
        position: fixed
        top: 0
        left: 0
        bottom: 0
        z-index: 1000
        overflow-x: hidden
        overflow-y: auto
        border-right: 1px solid #eee

    .dropdown-header
        padding-left: 0.5rem
        padding-right: 0.5rem
</style>
