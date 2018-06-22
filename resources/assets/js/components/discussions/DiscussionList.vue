<template>
<span>

    <span v-for="discussion in orderedDiscussions" :key="discussion.id"  class="search-descussions-object data-discussion-socket-id" :data-discussionSocketId="`${discussion.id}`">
         <modal-discussion-thread :initial-discussion="discussion" :members="members" :group="group" :facilitatorId="facilitator" :authUserId="auth" :flattened="flattened" :gotocommentdiscussionid="gotocommentdiscussionid">
            <div class="mr-auto">

                <div v-if="flattened.indexOf(discussion.id) == -1" class="search-value data-discussion-title" :data-discussion="`${discussion.id}`"><b>{{ discussion.title }}</b></div>
                <div v-if="flattened.indexOf(discussion.id)>-1" class="search-value data-discussion-title" :data-discussion="`${discussion.id}`">{{  discussion.title }}</div>

                <div class="text-muted small">
                    by  <span v-if="discussion.author">{{ discussion.author.user.name }}</span>
                    &ndash;

                    <span v-if="discussion.replies">
                        <span v-if="discussion.replies.length">
                            <date-format v-if="discussion.replies[discussion.replies.length-1]" :value="(discussion.replies[discussion.replies.length-1].created_at)" format="MMM DD, h:mm a"></date-format>
                        </span>

                        <span v-if="discussion.replies.length == 0">
                             <date-format :value="(discussion.created_at)" format="MMM DD, h:mm a"></date-format>
                        </span>
                    </span>
                </div>
            </div>
            <div>
                <span class="text-muted small"><b class="replies-count-class" :data-replies_count="`${discussion.id}`">{{ discussion.replies_count }}</b> replies</span>
            </div>
        </modal-discussion-thread>
    </span>

</span>

</template>

<script>

    export default {
        props: {
            discussions: {
                type: Object,
                required: true,
            },
            members: {
                required: true,
            },
            auth: {
                type: Number,
                required: true,
            },
            facilitator: {
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

        data() {
            return {
                discussions2:this.discussions,
                discussions3: {}
            };
        },

        methods: {

            appendNewDiscussion(discussion) {
                let num = 1;
                this.$set(this.discussions3, 0, discussion);

                for( let key in this.discussions2 ) {
                    this.$set(this.discussions3, num, this.discussions2[key]);
                    num++;
                }

                this.discussions2 = {};
                let xxx = 0;
                for( let key in this.discussions3 ) {
                    this.$set(this.discussions2, xxx, this.discussions3[key]);
                    xxx++;
                }
            },

            ObjectLength( object ) {
                let length = 0;
                for( let key in object ) {
                    if( object.hasOwnProperty(key) ) {
                        ++length;
                    }
                }
                return length;
            },
        },

        mounted() {
            window.Echo.private(`group.${this.group.id}`)
                .listen("DiscussionCreated", (data) => {
                    this.appendNewDiscussion(data.discussion);

                    let unreadMessageBadges = document.getElementsByClassName('unread-group-message-count');
                    let unreadMessageBadgesBtag = document.getElementsByClassName('should-be-bold');
                    for(let c = 0; c < unreadMessageBadges.length; c++ ){
                        if(unreadMessageBadges[c].innerHTML == '' || unreadMessageBadges[c].innerHTML == 0){
                            unreadMessageBadgesBtag[c].style.fontWeight = '700';
                            unreadMessageBadges[c].innerHTML = 1;
                        }else{
                            unreadMessageBadges[c].innerHTML = parseInt(unreadMessageBadges[c].innerHTML) + 1;
                        }
                    }

                    toastr.success("A discussion was created.");
                })
                .listen("DiscussionUpdated", (data) => {

                    let maxLengthObject = this.ObjectLength(this.discussions2);
                    for(let y = 0;y < maxLengthObject ;y++){
                        if(this.discussions2[y].id ==  data.discussion.id){
                            this.discussions2[y].title = data.discussion.title;
                        }
                    }

                    let xDataDiscussionVue = document.getElementsByClassName("discussion-title-socket-id-class");
                    for(let c = 0; c < xDataDiscussionVue.length; c++ ){
                        if(xDataDiscussionVue[c].getAttribute('data-discussionTitleSocketId') == data.discussion.id){
                            xDataDiscussionVue[c].innerText = data.discussion.title;
                        }
                    }
                    toastr.success("A discussion was updated.");
                })
                .listen("DiscussionDeleted", (data) => {
                    let xDataDiscussionDel = document.getElementsByClassName("data-discussion-socket-id");

                    for(let c = 0; c < xDataDiscussionDel.length; c++ ){
                        if(xDataDiscussionDel[c].getAttribute('data-discussionSocketId') == data.discussion.id){
                            xDataDiscussionDel[c].style.display = 'none';
                            xDataDiscussionDel[c].remove();
                        }
                    }

                    if(this.flattened.indexOf(data.discussion.id) == -1){
                        let unreadMessageBadges = document.getElementsByClassName('unread-group-message-count');
                        let unreadMessageBadgesBtag = document.getElementsByClassName('should-be-bold');
                        for(let c = 0; c < unreadMessageBadges.length; c++ ){
                            if(unreadMessageBadges[c].innerHTML == 1){
                                unreadMessageBadgesBtag[c].style.fontWeight = '400';
                            }
                            unreadMessageBadges[c].innerHTML = parseInt(unreadMessageBadges[c].innerHTML) - 1;
                        }
                    }

                    toastr.success("A discussion was deleted.");
                });
        },

        computed: {
            orderedDiscussions: function () {
                return _.orderBy(this.discussions2, ['sort'],['desc'])
            }
        }


    };
</script>