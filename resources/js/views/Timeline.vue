<template>
    <div class="main_content">
        <div class="mcontainer">
            <!--  TIMELINE  -->
            <div class="lg:flex lg:space-x-10">
                <div class="lg:w-3/4 lg:px-10 space-y-7">
                    <!-- STORY -->
                    <!-- End Story-->
                    <!-- NEW POST -->
                    <NewPost :data="postData" />
                    <!-- POST-->
                    <Post :hideAction="true" @stateActionPost="getStateActionPost" :newfeeds="newfeeds"/>
                    <!-- LOADMORE-->
                    <div class="flex justify-center mt-6">
                        <a href="#"
                            class="bg-white dark:bg-gray-900 font-semibold my-3 px-6 py-2 rounded-full shadow-md dark:bg-gray-800 dark:text-white">
                            Load more ..</a>
                    </div>
                </div>
                <!--- RIGHT TIMELINE -->
                <!-- <RightTimeline :friends="$store.state.auth.friends" /> -->
            </div>
        </div>
    </div>
</template>
<style scoped>
.wh-95{
    width: 95%; 
    height: 95%
}
</style>
<script setup>
import Story from './../components/Story.vue';
import Post from './../components/Post.vue';
import NewPost from './../components/NewPost.vue';
import RightTimeline from './../components/RightTimeline.vue';
import { mapState } from 'vuex';
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
            return this.$store.getters.getNewFeed
        }
    },
    created() {
        this.$store.dispatch('loadNewfeeds', null);
    },
    mounted() {
    },
    methods: {
        getStateActionPost(value){
            this.postData = value.newfeed
            this.postData['key']= value.key
        }
    },
}
</script>