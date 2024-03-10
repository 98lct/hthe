<template>
    <div class="main_content">
        <div class="mcontainer">
            page
        </div>
    </div>
</template>
<script setup>
import NewPost from '../components/NewPost.vue';
import Post from '../components/Post.vue';
</script>
<script>
export default {
    data: () => {
        return {
            postData: null,
            // newfeeds: []
        }
    },
    computed: {
        newfeeds: function () {
            let myNewFeed = (this.$store.getters.getNewFeed).filter(newfeed => {
                return (newfeed.user_id == this.$route.params.id) && (newfeed.postable_type == 'App\\Models\\Post' || newfeed.postable_type == 'App\\Models\\User')
            })
            return myNewFeed
        },
        user: function () {
            return this.$store.getters.getUser
        },
        friends: function () {
            return this.$store.getters.getFriends
        },
        friend_suggests: function () {
            return this.$store.getters.getFriendSuggests
        },
    },
    created() {
        this.$store.dispatch('loadNewfeeds');
    },
    mounted() {
        // console.log('friend_suggests', this.friend_suggests);
    },
    methods: {
        getStateActionPost(value) {
            this.postData = value.newfeed
            this.postData['key'] = value.key
        }
    },
}
</script>