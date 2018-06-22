<template>
    <div class="card mb-3">
        <div class="card-header">Professional Background</div>
        <div class="card-body">
            <div class="row">
                <div class="col-xs-6 col-sm-2">
                    <div v-if="business_avatar">
                        <img :src="'/storage/' + business_avatar" class="img-fluid rounded" :alt="company_name">
                    </div>
                    <div v-else>
                        [no image uploaded]
                    </div>
                </div>

                <div class="col-sm-10">
                    <b>Company Name</b>
                    <p class="dmh-preserve-text-area">{{company_name}}</p>
                 
                    <b>Company Bio</b>
                    <p class="dmh-preserve-text-area">{{business_bio}}</p>
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
                company_name: this.member.company_name,
                business_bio: this.member.business_bio,
                business_avatar: this.member.business_avatar,
            };
        },

        mounted() {
            // Broadcasting consumption
            Echo.private(`members.${this.member.id}`)
                .listen("MemberUpdated", (e) => {
                    this.company_name = e.member.company_name;
                    this.business_bio = e.member.business_bio;
                    this.business_avatar = e.member.business_avatar;
                });
        },

        methods: {

        },
    };
</script>
