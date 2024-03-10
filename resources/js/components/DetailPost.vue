<script setup>
import RightTimeline from './RightTimeline.vue';
import Post from './Post.vue';
</script>
<template>
    <div class="main_content">
        <div class="mcontainer">
            <!--  TIMELINE  -->
            <div class="lg:flex lg:space-x-10 detail-post">
                <div class="lg:w-3/4 lg:px-10 space-y-7">
                    <Post :hideAction="true" :newfeeds= "newfeeds"/>
                </div>
                <!--- RIGHT TIMELINE -->
                <!-- <RightTimeline /> -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: () => {
        return {
            // detail: this.$storestate.newfeed.detail
        }
    },
    computed: {
        newfeeds: function () {
            return this.$store.getters.getDetail
        }
    },
    created() {
        this.$store.dispatch('detailPost', this.$route.params.id);
    },
}
</script>