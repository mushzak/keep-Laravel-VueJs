import DiscussionTopic from "../components/discussions/DiscussionTopic.vue";
import DiscussionReply from "../components/discussions/DiscussionReply.vue";
import DiscussionAddReply from "../components/discussions/DiscussionAddReply.vue";

export default {
    components: {
        DiscussionTopic,
        DiscussionReply,
        DiscussionAddReply,
    },

    props: {
        initialDiscussion: {
            type: Object,
            required: true,
        },

        group: {
            type: Object,
            required: true,
        },

        members: {
            type: Array,
            required: true,
        }
    },

    data() {
        return {
            discussion: {
                author: {
                    user: {},
                },
                body: "",
                replies: [],
            }
        };
    },

    mounted() {
        // Pull props into active state.
        this.discussion = this.initialDiscussion;

        // Broadcasting consumption
        Echo.private(`discussions.${this.discussion.id}`)
            .listen("DiscussionUpdated", (e) => {
                console.log("This discussion was updated.");

                this.discussion.body = e.discussion.body;
            })
            .listen("DiscussionDeleted", (e) => {
                console.log("This discussion was deleted.");

                window.location.reload();
            })
            .listen("ReplyCreated", (e) => {
                console.log("This discussion has a reply that was created.");

                this.discussion.replies.push(e.reply);

            })
            .listen("ReplyUpdated", (e) => {
                console.log("This discussion has a reply that was updated.");

                let replyIndex = this.discussion.replies.findIndex(reply => reply.id == e.reply.id);

                this.$set(this.discussion.replies, replyIndex, e.reply);
            })
            .listen("ReplyDeleted", (e) => {
                console.log("This discussion has a reply that was deleted.");

                let replyIndex = this.discussion.replies.findIndex(reply => reply.id == e.reply.id);

                this.discussion.replies.splice(replyIndex, 1);
            });
    },

};