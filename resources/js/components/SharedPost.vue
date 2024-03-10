<script setup>
    import moment from 'moment';
    import Media from './Media.vue';
</script>
<template>
    <section class="mt-4">
        <div v-if="shared !== null && (shared.is_delete == 1 || shared.status != 2)" class="box-shared-post border">
            <div class="flex justify-between items-center lg:p-4 p-2.5 pointer">
                <div class="flex flex-1 items-center space-x-4">
                    <a>
                        <img v-if="shared.postable_type.split('\\')[2].toLowerCase() == 'user' || shared.postable_type.split('\\')[2].toLowerCase() == 'post'" :src="'/uploads/users/' + shared.user.profile_img"
                            class="bg-gray-200 border border-white rounded-full w-10 h-10">
                        <img v-else-if="shared.postable_type.split('\\')[2].toLowerCase() == 'page'" :src="'/uploads/pages/' + shared.page.profile_img"
                            class="bg-gray-200 border border-white rounded-full w-10 h-10">
                    </a>
                    <div class="flex-1 font-semibold">
                        <router-link :to="{name: 'Profile', params: {id: shared.user.user_id}}" v-if="shared.postable_type.split('\\')[2].toLowerCase() == 'user' || shared.postable_type.split('\\')[2].toLowerCase() == 'post'"  class="text-black dark:text-gray-100">{{ typeof (shared.user) !== undefined ?
                            shared.user.full_name
                            : 'NULLable' }}</router-link>
                        <router-link :to="{name: 'Page', params: {id: shared.postable_id}}"  v-if="shared.postable_type.split('\\')[2].toLowerCase() == 'page'"  class="text-black dark:text-gray-100">{{ typeof (shared.page) !== undefined ?
                            shared.page.name
                            : 'NULLable' }}</router-link>

                        <div @click="$emit('showSharePost', shared.post_id)" class="text-gray-700 flex items-center space-x-2">
                            <span :title="moment.unix(shared.created_at).format('DD/MM/YYYY HH:mm')" class="pointer font-normal">{{ moment.unix(shared.created_at).startOf('minute').fromNow()
                            }}</span>
                            <ion-icon v-if="shared.status == 0" name="earth"></ion-icon>
                            <ion-icon v-if="shared.status == 1" name="person-outline"></ion-icon>
                            <ion-icon v-if="shared.status == 2" name="lock-closed-outline"></ion-icon>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-5 pt-0 pb-2 border-b dark:border-gray-700 timeline-content">
                <div
                    :class="typeof shared.readmore !== 'undefined' && shared.readmore == true ? 'full' : 'short' + '-content'">
                    {{ shared.content }}
                </div>
            </div>
            <Media :medias="shared.medias" />
        </div>
        <div v-else class="box-shared-post is-delete border bg-gray-200">
            <div class="icon">
                <ion-icon name="lock-closed-outline"></ion-icon>
            </div>
            <div>
                <p>Content is not displayed</p>
                <span>
                    Frequently, the reason behind this mistake is that the proprietor has restricted the content to a limited group, altered the visibility settings, or erase the content.
                </span>
            </div>
        </div>
    </section>
</template>
<script>
export default {
    props: ['shared'],
    data: () => {
        return {

        }
    },
    mounted() {
    },
}
</script>
