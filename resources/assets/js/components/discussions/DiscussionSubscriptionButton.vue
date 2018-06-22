<template>
    <div>
        <a href="#" class="btn btn-secondary" @click.prevent="toggleSubscription" v-if="discussion.has_user_subscribed">
            <i class="fa fa-heart"></i>
        </a><br>
        <h6 v-if="discussion.has_user_subscribed"><span>Subscribed</span></h6>
        <a href="#" class="btn btn-outline-secondary" @click.prevent="toggleSubscription" v-else>
            <i class="fa fa-heart-o"></i><br>
        </a>
        <h6 v-if="!discussion.has_user_subscribed"><span>Unsubscribed</span></h6>
    </div>
</template>

<script>
    export default {
        props: {
            discussion: {
                type: Object,
                required: true,
            },
        },

        methods: {
            toggleSubscription() {
                window.axios.post(`/discussions/${this.discussion.id}/subscription`).then(() => {
                    this.discussion.has_user_subscribed = !this.discussion.has_user_subscribed;
                    window.toastr.success("Your subscription to this discussion has been updated.");
                })
            },
        },
    }
</script>
