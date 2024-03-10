<script setup>
import Media from './Media.vue';
import SharedPost from './SharedPost.vue';
import moment from 'moment';
</script>
<template>
    <section class="height-fixed">
        <div class="card mb-4 lg:mx-0 uk-animation-slide-bottom-small">
            <!-- post header-->
            <div class="flex justify-between items-center lg:p-4 p-2.5 pointer">
                <!--POST profile & name-->
                <div class="flex flex-1 items-center space-x-4">
                    <a>
                        <img v-if="newfeed.postable_type.split('\\')[2].toLowerCase() == 'user' || newfeed.postable_type.split('\\')[2].toLowerCase() == 'post'"
                            :src="'/uploads/users/' + newfeed.user.profile_img"
                            class="bg-gray-200 border border-white rounded-full w-10 h-10">
                        <img v-else-if="newfeed.postable_type.split('\\')[2].toLowerCase() == 'page'"
                            :src="'/uploads/pages/' + newfeed.page.profile_img"
                            class="bg-gray-200 border border-white rounded-full w-10 h-10">
                    </a>
                    <div class="flex-1 font-semibold">
                        <router-link :to="{ name: 'Profile', params: { id: newfeed.user.user_id } }"
                            v-if="newfeed.postable_type.split('\\')[2].toLowerCase() == 'user' || newfeed.postable_type.split('\\')[2].toLowerCase() == 'post'"
                            class="text-black dark:text-gray-100">{{ typeof (newfeed.user) !== undefined ?
                                newfeed.user.full_name
                                : '' }}</router-link>
                        <router-link :to="{ name: 'Page', params: { id: newfeed.postable_id } }"
                            v-else-if="newfeed.postable_type.split('\\')[2].toLowerCase() == 'page'"
                            class="text-black dark:text-gray-100">{{ typeof (newfeed.page) !== undefined ?
                                newfeed.page.name
                                : '' }}</router-link>
                        <span v-if="newfeed.feeling != null" class="post-feeling">
                            <ion-icon name="happy-outline"></ion-icon>
                            {{ newfeed.feeling }}
                        </span>
                        <span v-if="newfeed.activity != null" class="post-activity">
                            <ion-icon name="accessibility-outline"></ion-icon>
                            {{ newfeed.activity }}
                        </span>
                        <span v-if="newfeed.shared_by !== null" class="post-shared">
                            shared
                        </span>
                        <div @click="showPost(newfeed.post_id)" class="text-gray-700 flex items-center space-x-2">
                            <span :title="moment.unix(newfeed.created_at).format('DD/MM/YYYY HH:mm')"
                                class="pointer font-normal">{{ moment.unix(newfeed.created_at).startOf('minute').fromNow()
                                }}</span>
                            <ion-icon v-if="newfeed.status == 0" name="earth"></ion-icon>
                            <ion-icon v-if="newfeed.status == 1" name="person-outline"></ion-icon>
                            <ion-icon v-if="newfeed.status == 2" name="lock-closed-outline"></ion-icon>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-5 pt-0 pb-2 border-b dark:border-gray-700 timeline-content">
                <!-- text content -->
                <div v-if="newfeed['content'] != null"
                    :class="typeof newfeed.readmore !== 'undefined' && newfeed.readmore == true ? 'full' : 'short' + '-content'">
                    {{ newfeed.content }}
                </div>
                <!---Post shared form other post-->
                <SharedPost @showSharePost="showPost" :shared="newfeed.shared" v-if="newfeed.shared_by != null" />
                <div v-if="(routeName != 'Detail') && (typeof newfeed.readmore == 'undefined' || newfeed.readmore == false) && (newfeed['content'] != null && newfeed['content'].length > 300)"
                    class="readmore" @click="turnOnReadMore(newfeed.post_id, index, newfeed.content)">Read more</div>
                <!--  && -->
            </div>
            <!--HAS MEDIA-->
            <Media :medias="newfeed.medias" />
        </div>
    </section>
</template>
<style>
.height-fixed {
    max-height: 200px;
    overflow-y: auto;
}
</style>
<script>
export default {
    props: ['newfeed'],
    data: () => {
        return {

        }
    },
    mounted() {
    },
}
</script>