<template></template>

<script>
    import Form from "../../utilities/Form";
    import InputTextArea from "../inputs/InputTextArea.vue";
    import InputSubmit from "../inputs/InputSubmit.vue";
    import DiscussionThread from "../../mixins/DiscussionThread.js";
    import ModalDiscussionThread from "./ModalDiscussionThread.vue";

    export default {
        props: {
            group: {},
        },

        components: {
            ModalDiscussionThread,
        },

        data() {
            return {

            };
        },

        methods: {
            appendNewDiscussion(dataEncode,data) {
                let xDataDiscussionCreate = document.getElementById("search-descussions-object");
                xDataDiscussionCreate.insertAdjacentHTML( 'afterbegin', dataEncode.discussionView );
            }
        },

        mounted() {
            window.Echo.private(`group.${this.group.id}`)
                .listen("DiscussionCreated", (data) => {
                    console.log(data);
                    var dataEncode = JSON.parse(data);
                    this.appendNewDiscussion(dataEncode,data);
                    toastr.success("A discussion was created.");
                })

                .listen("DiscussionUpdated", (data) => {
                    let xDataDiscussionBlade = document.getElementsByClassName("data-discussion-title");
                    for(let c = 0; c < xDataDiscussionBlade.length; c++ ){
                        if(xDataDiscussionBlade[c].getAttribute('data-discussion') == data.discussion.id){
                            xDataDiscussionBlade[c].innerText = data.discussion.title;
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
                    toastr.success("A discussion was deleted.");
                });
        },
    };
</script>