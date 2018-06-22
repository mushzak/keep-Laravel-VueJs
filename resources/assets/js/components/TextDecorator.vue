<template>
    <span v-html="output"></span>
</template>

<script>
    export default {
        props: {
            text: {
                type: String,
                default: '',
            },

            shouldAddBreaks: {
                type: Boolean,
                default: true,
            },

            shouldAddLinks: {
                type: Boolean,
                default: true,
            },

            shouldAddMentions: {
                type: Boolean,
                default: false,
            },

            group: {
                type: Object,
                default: function () {
                    return {};
                }
            },

            members: {
                type: Array,
                default: function () {
                    return [];
                }
            }
        },

        computed: {
            output() {
                let output = this.text;

                if(output==null) output="";

                if (this.shouldAddBreaks)
                    output = output.replace(/\n/g, "<br />");

                if (this.shouldAddLinks)
                    output = output.replace(/(?:(?:http|https):\/\/)?((?:[\w_-]+(?:(?:\.[\w_-]+)+))(?:[\w.,@?^=%&:/~+#-]*[\w@?^=%&/~+#-])?)/ig, "<a href=\"//$1\" target=\"_blank\" rel=\"nofollow\">$1</a>");

                if (this.shouldAddMentions && this.group) {
                    this.members.forEach(member => {
                        if(member.user){
                            var searchMask =`@${member.user.name}`;
                            var regEx = new RegExp(searchMask, "ig");
                            var replaceMask = `<a href="/groups/${this.group.slug}/profiles/${member.id}" class="badge badge-pill badge-info" target="_blank">${member.user.name}</a>`;
                            output = output.replace(regEx, replaceMask);
                        }
                    })
                }

                return output;
            },
        },
    }
</script>
