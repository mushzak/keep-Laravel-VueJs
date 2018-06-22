<template>
    <div>
        <div id="dmhscrollingelement" class="discussion-container mb-3 px-1" style="height: 65vh; overflow-y: scroll;">
            <discussion-topic :discussion="discussion" :members="members" :group="group"></discussion-topic>

            <discussion-reply
                    v-for="reply in discussion.replies"
                    :key="reply.id"
                    :discussion="discussion"
                    :reply="reply"
                    :group="group"
                    :members="members">
            </discussion-reply>
        </div>

        <discussion-add-reply :discussion="discussion"></discussion-add-reply>
    </div>
</template>

<script>
    import DiscussionThread from "../../mixins/DiscussionThread.js";

    export default {
        mixins: [DiscussionThread],

        mounted(){
                this.scrollToBottom();
                console.log('mounted');
            },


        updated(){
                this.scrollToBottom();
                console.log('updated');
            },

        methods: {
            /**
             * Scroll to Last Reply.
             */
            scrollToBottom(){
                let container = this.$el.querySelector("#dmhscrollingelement");
                container.scrollTop = container.scrollHeight;
                console.log('scrolled');
            },
        },
    };

</script>
