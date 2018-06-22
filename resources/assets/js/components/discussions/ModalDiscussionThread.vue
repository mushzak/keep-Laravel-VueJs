<template>
    <div class="list-group-item list-group-item-action mb-3">
        <a href="#!"  @click.prevent="markAsRead" class="list-group-item-action d-flex">
            <slot></slot>
        </a>
        <div class="text-right align-self-bottom discussion-modal-class" :data-discussionModal="`${discussion.id}`">

            <span v-if="facilitatorId === authUserId">
                 <a href="#" class="btn btn-sm btn-outline-secondary" @click.prevent="deleteDiscussion">
                    <i class="fa fa-trash"></i>
                </a>
            </span>

            <span v-if="facilitatorId !== authUserId && initialDiscussion.author && discussion.replies == ''">
                 <a href="#" class="btn btn-sm btn-outline-secondary" v-if="initialDiscussion.author.user.id === authUserId" @click.prevent="deleteDiscussion">
                    <i class="fa fa-trash"></i>
                </a>
            </span>

            <span v-if="facilitatorId !== authUserId && initialDiscussion.author && discussion.replies == ''">
                <a href="#" class="btn btn-sm btn-outline-secondary" v-if="initialDiscussion.author.user.id === authUserId" @click.prevent="onEditTitle">
                    <i class="fa fa-edit"></i>
                </a>
            </span>
        </div>

        <div v-if="isEditingMode">
            <br>
            <form @submit.prevent="updateTitle">
                <input-text-area
                        v-model="form.data.title"
                        :error="form.errors.get('body')">
                </input-text-area>

                <input-submit label="Update title" :disabled="this.form.isSubmitting"></input-submit>
            </form>
        </div>
        <b-modal v-model="modalShow"  @shown="scrollToBottom" @hidden="reloadPage" size="lg" busy lazy centered hide-footer>
            <div slot="modal-title">
                <div class="d-flex align-items-center">
                    <div class="mr-1">
                        <discussion-subscription-button :discussion="discussion"></discussion-subscription-button>
                    </div>
                    <div v-if="isEditingMode">
                        <form @submit.prevent="updateTitle">
                            <input-text-area
                                    v-model="form.data.title"
                                    :error="form.errors.get('body')">
                            </input-text-area>

                            <!--<input-submit label="Update title" :disabled="this.form.isSubmitting"></input-submit>-->
                        </form>
                    </div>
                    <div v-else>
                        <span :data-discussionTitleSocketId="`${discussion.id}`" class="discussion-title-socket-id-class">{{ discussion.title }}</span>
                    </div>
                </div>

            </div>

            <div id="dmhscrollingelement" class="discussion-container mb-3 px-1" style="height: 65vh; overflow-y: scroll;">
                <discussion-topic :discussion="discussion" :members="members" :group="group" :authUserId="authUserId" :facilitatorId="facilitatorId"></discussion-topic>

                <discussion-reply
                        v-for="reply in discussion.replies"
                        :key="reply.id"
                        :discussion="discussion"
                        :reply="reply"
                        :group="group"
                        :members="members" :authUserId="authUserId" :facilitatorId="facilitatorId">
                </discussion-reply>
            </div>

            <discussion-add-reply :discussion="discussion" :group="group" :authUserId="authUserId" :facilitatorId="facilitatorId"></discussion-add-reply>
        </b-modal>
    </div>
</template>

<script>
    import Form from "../../utilities/Form";
    import InputTextArea from "../inputs/InputTextArea.vue";
    import InputSubmit from "../inputs/InputSubmit.vue";
    import DiscussionThread from "../../mixins/DiscussionThread.js";
    import DiscussionSubscriptionButton from "./DiscussionSubscriptionButton.vue";

    export default {
        props: {
            initialDiscussion: {
                type: Object,
                required: true,
            },
            authUserId: {
                type: Number,
                required: true,
            },
            facilitatorId: {
                type: Number,
                required: true,
            },
            group: {
                type: Object,
            },
            flattened:{
                type: Array,
            },
            gotocommentdiscussionid: {
                type:Number,
            }
        },

        mixins: [
            DiscussionThread
        ],

        components: {
            DiscussionSubscriptionButton,
            InputTextArea,
            InputSubmit,
        },

        data() {
            return {
                modalShow: false,
                isEditingMode: false,
                form: new Form({
                    title: '',
                }),
                deleteEditShow:true,
                letDiscussionCreate:true,
                letDiscussionUpdate:true,
                letDiscussionDelete:true,
            };
        },

        updated(){
            this.scrollToBottom();
        },

        methods: {
            /**
             * Scroll to Last Reply.
             */
            scrollToBottom(){
                if(this.modalShow){
                    let container = this.$el.querySelector("#dmhscrollingelement");
                    container.scrollTop = container.scrollHeight;
                };
            },

            markAsRead() {
                this.modalShow = true;

                if(this.flattened.indexOf(this.discussion.id) == -1){
                    this.flattened.push(this.discussion.id);
                    let unreadMessageBadges = document.getElementsByClassName('unread-group-message-count');
                    let unreadMessageBadgesBtag = document.getElementsByClassName('should-be-bold');
                    for(let c = 0; c < unreadMessageBadges.length; c++ ){
                        if(unreadMessageBadges[c].innerHTML == 1){
                            if(unreadMessageBadgesBtag){
                                unreadMessageBadgesBtag[c].style.fontWeight = '400';
                            }
                        }
                        unreadMessageBadges[c].innerHTML = parseInt(unreadMessageBadges[c].innerHTML) - 1;
                    }
                }

                let xDataDiscussion = document.getElementsByClassName("data-discussion-title");
                for(let c = 0; c < xDataDiscussion.length; c++ ){
                    if(xDataDiscussion[c].getAttribute('data-discussion') == this.discussion.id){
                        xDataDiscussion[c].innerHTML = this.discussion.title;
                    }
                }

                window.axios.post(`/discussions/${this.discussion.id}/mark-as-read`);
            },

            reloadPage() {
              //  location.reload(true);
                console.log('you suck');

            },
            /**
             * Update title
             */
            updateTitle() {
                this.form.patch(`/discussions/${this.discussion.id}`)
                    .then(data => {
                        this.isEditingMode = false;
                        this.discussion.title = this.form.data.title;

                        let xDataDiscussion = document.getElementsByClassName("data-discussion-title");
                        for(let c = 0; c < xDataDiscussion.length; c++ ){
                            if(xDataDiscussion[c].getAttribute('data-discussion') == this.discussion.id){
                                xDataDiscussion[c].innerHTML = this.discussion.title;
                            }
                        }

                        toastr.success('The discussion has been updated successfully.');
                    });
            },
            /**
             * On click edit button
             */
            onEditTitle() {
                this.form.data.title = this.discussion.title;
                this.form.data.body = this.discussion.body;
                this.isEditingMode = !this.isEditingMode;
            },

            deleteDiscussion() {
                swal({
                    title: "Want to delete this?",
                    text: "Are you sure you want to delete this discussion?  You will not be able to reverse this action!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Confirm",
                    cancelButtonText: "Cancel",
                    confirmButtonClass: "btn btn-danger",
                    cancelButtonClass: "btn btn-secondary",
                }).then(() => {
                    axios.delete(`/discussions/${this.discussion.id}`)
                        .then(data => {
                            window.location.reload();
                            toastr.success('The discussion has been deleted successfully.');
                        });
                });
            },

        },

        mounted(){
            if(this.gotocommentdiscussionid == this.discussion.id){
                this.modalShow = true;
            }
        }

    };
</script>