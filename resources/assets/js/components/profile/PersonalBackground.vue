<template>
    <div class="card mb-3">
        <div class="card-header">Personal Background</div>
            <div class="card-body">
                <div >
                   <b>Name</b>
                    <p class="dmh-preserve-text-area">{{name}}</p>
                </div>

                <div>
                    <b>Bio</b>
                    <p class="dmh-preserve-text-area">{{personal_bio}}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        components: {
        },

        props: {
            member: {
                type: Object,
                required: true,
            }
        },

        data() {
            return {
                personal_bio: this.member.personal_bio,
                //personal_avatar: this.member.personal_avatar,
                name:this.member.user.name,
            };
        },

        mounted() {
            // Broadcasting consumption
            Echo.private(`members.${this.member.id}`)
                .listen("MemberUpdated", (e) => {
                    this.personal_bio = e.member.personal_bio;
                    //this.personal_avatar = e.member.personal_avatar;
                });
        },

        methods: {

        },
    };
</script>
