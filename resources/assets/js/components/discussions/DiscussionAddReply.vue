<template>
    <form @submit.prevent="onSubmit">
        <div>
            <input-checkbox label="Is this urgent?" v-model="form.data.is_urgent" :error="form.errors.get('is_urgent')">
            </input-checkbox>
        </div>

        <div v-if="showGroupUsers" class="search-filter-user-class">
            <p v-for="user in usersFilter" v-on:click="chooseUser(user)">{{ user }}</p>
        </div>

        <div class="d-flex">
            <div style="flex-grow: 1">
                <input-text-area
                        v-model="form.data.body"
                        :error="form.errors.get('body')"
                        :keyup="searchUser(form.data.body,)">
                </input-text-area>
            </div>

            <input-submit label="Leave reply" :disabled="this.form.isSubmitting" class="ml-2"></input-submit>
        </div>
    </form>
</template>

<script>
    import Form from "../../utilities/Form";

    import InputCheckbox from "../inputs/InputCheckbox.vue";
    import InputTextArea from "../inputs/InputTextArea.vue";
    import InputSubmit from "../inputs/InputSubmit.vue";

    export default {
        components: {
            InputCheckbox,
            InputTextArea,
            InputSubmit,
        },

        props: {
            discussion: {
                type: Object,
                required: true,
            },
            group: {
                type: Object,
               // required: true,
            },
            authUserId: {
                type: Number,
                //   required: true,
            },
            facilitatorId: {
                type: Number,
                //   required: true,
            },
        },

        watch: {
            search: function (val) {
                this.usersFilter = this.users.filter(name => {
                    return name.toLowerCase().includes(this.search.toLowerCase())
                })
            },
        },

        data() {
            return {
                form: new Form({
                    body: "",
                    is_urgent: false,
                }),
                showGroupUsers:false,
                startSearching:true,
                users:[],
                usersFilter:[],
                search: '',
                addDiscussion:true,
            };
        },

        methods: {
            /**
             * Triggers when the form has submitted.
             */
            onSubmit() {
                this.form.post(`/discussions/${this.discussion.id}/replies`)
                    .then(data => {
                        if(this.addDiscussion){
                            this.addDiscussion = false;

                            let xDataDiscussion = document.getElementsByClassName("replies-count-class");
                            for(let c = 0; c < xDataDiscussion.length; c++ ){
                                if(xDataDiscussion[c].getAttribute('data-replies_count') == this.discussion.id){
                                    xDataDiscussion[c].innerText = '1 seconds ago';
                                }
                            }

                        }
                        this.form.data.body = "";
                        this.form.data.is_urgent = false;
                        toastr.success("Your reply has been added successfully.");
                    }).then(data => {
                        this.addDiscussion = true;
                        if(this.authUserId != this.facilitatorId){
                            let xDataDiscussionModal = document.getElementsByClassName("discussion-modal-class");
                            for(let c = 0; c < xDataDiscussionModal.length; c++ ){
                                if(xDataDiscussionModal[c].getAttribute('data-discussionModal') == this.discussion.id){
                                    xDataDiscussionModal[c].style.display = 'none';
                                }
                            }
                        }
                    });
            },

            searchUser(userName){
                if(userName != ''){
                    let lastChars = userName.length;
                    if(userName.substring(lastChars-1,lastChars) == '@' && this.startSearching){
                        this.form.post(`/discussions/${this.group.id}/search`)
                            .then((data) => {
                                this.startSearching = false;
                                for(let j = 0 ; j < data.data.length ; j++){
                                    if(!this.users.includes(data.data[j].user.name)) {
                                        this.users.push(data.data[j].user.name);
                                        this.usersFilter.push(data.data[j].user.name);
                                    }
                                }
                                this.showGroupUsers = true;
                        });
                    }

                    let indexOfString = userName.lastIndexOf('@');
                    this.search = userName.substring(indexOfString+1,userName.length);

                    if(indexOfString == -1){
                        this.users = [];
                        this.usersFilter = [];
                        this.showGroupUsers = false;
                        this.startSearching = true;
                    }
                }
            },

            chooseUser(user){
                let findLetterInString = this.form.data.body;
                let spliteString = findLetterInString.split('@');

                let jonSpliteArray = [];
                let lastPartOfArray = spliteString[spliteString.length-1];

                let firstPartOfArray = [];
                for(let y = 0; y < spliteString.length-1; y++){
                    if(y == 1 || y == 3 || y%2 == 1){
                        spliteString[y] = "@" + spliteString[y];
                    }
                    firstPartOfArray.push(spliteString[y]);
                }

                jonSpliteArray[0] = firstPartOfArray.join('');

                 jonSpliteArray[1] = "@"+user;
                // jonSpliteArray[2] = spliteString[1].replace(this.search,'');

                let jonSpliteString = jonSpliteArray.join(' ');
                this.form.data.body = jonSpliteString;

                this.users = [];
                this.usersFilter = [];
                this.showGroupUsers = false;
                this.startSearching = true;
            },
        },
    };
</script>
