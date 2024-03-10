<script setup>
import AddComment from './AddComment.vue';
import Comment from './Comment.vue';
import Media from './Media.vue';
import SharedPost from './SharedPost.vue';
import PostContent from './PostContent.vue';
import moment from 'moment';
</script>
<template>
    <section>
        <div v-if="(newfeeds != null)" v-for="(newfeed, index) in newfeeds"
            class="card mb-4 lg:mx-0 uk-animation-slide-bottom-small">
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
                        <span v-if="newfeed.feelings || newfeed.activity" class="ml-1"> is </span>
                        <span v-if="newfeed.feelings != null" class="post-feeling">
                            <font-awesome-icon :class="'fa-lg mx-1 ' + newfeed.feelings.feel_class" :icon="newfeed.feelings.feel_icon"  />
                            <span>feeling</span>
                            <span class="mx-1 text-gray-500"> {{ newfeed.feelings.feel_name }}</span>
                        </span>
                        <!-- <span v-if="newfeed.activity != null" class="post-activity">
                            <ion-icon name="accessibility-outline"></ion-icon>
                            {{ newfeed.activity }}
                        </span> -->
                        <span v-if="newfeed.feelings && newfeed.activitys"> and </span>
                        <span v-if="newfeed.activitys != null" class="post-activity">
                            <font-awesome-icon :class="'fa-lg mx-1 ' + newfeed.activitys.feel_class" :icon="newfeed.activitys.feel_icon"  />
                            <span>doing</span>
                            <span class="mx-1 text-gray-500"> {{ newfeed.activitys.feel_name }}</span>
                        </span>
                        <span v-if="newfeed.locations"> at </span>
                        <span v-if="newfeed.locations != null" class="post-activity">
                            <span class="mx-1 text-gray-500"> {{ newfeed.locations.location_name }}</span>
                        </span>
                        <span v-if="newfeed.shared_by !== null" class="post-shared mx-1">
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
                <!--action button dropdown-->
                <el-dropdown v-if="$store.state.auth.user.user_id === newfeed.user_id" trigger="click">
                    <span class="el-dropdown-link">
                        <i class="icon-feather-more-horizontal text-2xl transition -mr-1 dark:hover:bg-gray-700"></i>
                    </span>
                    <template #dropdown>
                        <el-dropdown-menu>
                            <!-- <el-dropdown-item>
                                <a @click="$emit('stateActionPost', { 'newfeed': newfeed, key: index })"
                                    class="flex items-center px-3 py-2 rounded-md dark:hover:bg-gray-800 text-sm">
                                    <i class="uil-edit-alt mr-1"></i> Edit post
                                </a>
                            </el-dropdown-item> -->
                            <el-dropdown-item>
                                <a @click="showModalChangeStatus(newfeed.post_id, index)"
                                    class="flex items-center px-3 py-2 rounded-md dark:hover:bg-gray-800 text-sm">
                                    <i class="uil-lock mr-1"></i> Edit audience
                                </a>
                            </el-dropdown-item>
                            <el-dropdown-item>
                                <a @click="toggleDisabledComment(newfeed.post_id, index)"
                                    class="flex items-center px-3 py-2 rounded-md dark:hover:bg-gray-800 text-sm">
                                    <i
                                        :class="(newfeed.disabled == 0) ? 'uil-comment-slash ' : 'uil-comment ' + 'mr-1'"></i>{{
                                            (newfeed.disabled == 0) ? 'Disable' : 'Enable' }} Comment
                                </a>
                            </el-dropdown-item>
                            <el-dropdown-item>
                                <a @click="removePost(newfeed.id, index)"
                                    class="flex items-center px-3 py-2 rounded-md dark:hover:bg-gray-800 text-sm">
                                    <i class="uil-trash-alt mr-1"></i> Move to trash
                                </a>
                            </el-dropdown-item>
                        </el-dropdown-menu>
                    </template>
                </el-dropdown>
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
            <!--liked comment shared-->
            <div v-if="hideAction" class="px-4 py-2 space-y-3">
                <div class="flex space-x-4 lg:font-bold">
                    <a class="flex items-center space-x-2" @click="likedPost(newfeed.post_id, index)">
                        <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22"
                                height="22" class="dark:text-gray-100">
                                <path :class="newfeed.reacts.length != 0 && (newfeed.reacts).find(x => x.user_id === getUser.user_id)
                                    ? 'liked' : ''"
                                    d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                            </svg>
                        </div>
                        <div> Like</div>
                    </a>
                    <a class="flex items-center space-x-2" @click="openCommentBox(newfeed.post_id, index)">
                        <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22"
                                height="22" class="dark:text-gray-100">
                                <path fill-rule="evenodd"
                                    d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div> Comment</div>
                    </a>
                    <el-dropdown trigger="click" class="flex items-center space-x-2 flex-1 justify-end">
                        <span class="el-dropdown-link">
                            <div class="flex items-center space-x-2 flex-1 justify-end">
                                <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        width="22" height="22" class="dark:text-gray-100">
                                        <path
                                            d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
                                    </svg>
                                </div>
                                <div> Share</div>
                            </div>
                        </span>
                        <template #dropdown>
                            <el-dropdown-menu>
                                <el-dropdown-item @click="showModalShareBox(newfeed.post_id, index, true)">
                                    <ion-icon name="arrow-redo-outline"></ion-icon>
                                    <span class="ml-2">Share now</span>
                                </el-dropdown-item>
                                <el-dropdown-item @click="showModalShareBox(newfeed.post_id, index)">
                                    <ion-icon name="create-outline"></ion-icon>
                                    <span class="ml-2">Share to Feed</span>
                                </el-dropdown-item>
                                <el-dropdown-item :plain="true" @click="updatedFeature(1)">
                                    <ion-icon name="link-outline"></ion-icon>
                                    <span class="ml-2" @click="updatedFeature(1)">Copy link</span>
                                </el-dropdown-item>
                                <el-dropdown-item :plain="true" @click="updatedFeature(2)">
                                    <ion-icon name="chatbubbles-outline"></ion-icon>
                                    <span class="ml-2" @click="updatedFeature(1)">Send in Messenger</span>
                                </el-dropdown-item>
                            </el-dropdown-menu>
                        </template>
                    </el-dropdown>
                </div>
                <!--Box Display total people liked-->
                <transition name="height-transition">
                <div v-if="newfeed.reacts.length > 0" class="flex items-center space-x-3 pt-0 border-b pb-3">
                    <div @click="showModalLiked(newfeed.post_id)" class="flex items-center">
                        <div v-for="(react, index) in newfeed.reacts">
                            <img :title="index" v-if="index < 3" :src="'/uploads/users/' + react.user.profile_img" alt=""
                                class="w-6 h-6 rounded-full border-2 border-white dark:border-gray-900">
                        </div>
                    </div>
                    <div @click="showModalLiked(newfeed.post_id)" class="dark:text-gray-100 pointer">
                        <strong> {{ newfeed.reacts[0].user.full_name }}</strong> <span
                            v-if="newfeed.reacts.length >= 2">and</span> <strong v-if="newfeed.reacts.length >= 2"> {{
                                newfeed.reacts.length - 1 }} </strong> Reacted
                    </div>
                </div>
                </transition>
                <!-- comment box -->
                <Comment :owner='newfeed.user_id' :post_key="index"
                    :postable_id="(typeof newfeed.postable_id === 'undefined' ? newfeed.post_id : newfeed.postable_id)"
                    :comments="newfeed.comments" v-if="isCommentBox.includes(index)" />
                <!-- reply post / add comment / disabled comment-->
                <AddComment v-if="newfeed.disabled == 0" :post_key="index" :post_id="newfeed.post_id"
                    :postable_type="newfeed.postable_type"
                    :postable_id="(typeof newfeed.postable_id === 'undefined' ? newfeed.post_id : newfeed.postable_id)" />
                <div v-else class="bg-gray-100 rounded-full relative dark:bg-gray-800 border-t p-2 text-center pointer">
                    Comment has been disabled by owner
                </div>
            </div>
        </div>
        <!-- Modal Like-->
        <el-dialog v-model="showModalLike" custom-class="modal-mobile" align-center>
            <template #header>
                <div class="my-header">
                    <div class="pb-2">People who reacted to this!</div>
                </div>
            </template>
            <div v-if="react_list != null">
                <div v-for="react in react_list" class="flex mb-2">
                    <div @click="gotoProfile(react.user.user_id)"
                        class="w-10 h-10 rounded-full relative flex-shrink-0 pointer"><img
                            :src="'/uploads/users/' + react.user.profile_img" alt=""
                            class="absolute h-full rounded-full w-full">
                    </div>
                    <div @click="gotoProfile(react.user.user_id)" class="mx-2 liked-user-row pointer">
                        <p>{{ react.user.full_name }}</p>
                        <span v-if="react.type == 1" class="text-blue-500">
                            <ion-icon name="thumbs-up"></ion-icon>
                        </span>
                        <span v-if="react.type == 2" class="text-red-500">
                            <ion-icon name="heart"></ion-icon>
                        </span>
                        <span v-if="react.type == 3" class="text-yellow-400">
                            <ion-icon name="happy"></ion-icon>
                        </span>
                        <span v-if="react.type == 4" class="text-indigo-500">
                            <ion-icon name="sad"></ion-icon>
                        </span>
                        <span v-if="react.type == 5" class="text-gray-700">
                            <ion-icon name="thumbs-down"></ion-icon>
                        </span>
                    </div>
                </div>
            </div>
        </el-dialog>
        <!-- Modal change Status: audience-->
        <el-dialog v-model="showModalStatus" custom-class="modal-mobile" align-center>
            <template #header>
                <div class="my-header">
                    <p class="pl-3">Edit audience</p>
                </div>
            </template>
            <div class="modal-body">
                <div class="desc-attr mb-2">
                    <strong class="mb-1 d-block">
                        Who can see your post?
                    </strong>
                    <p class="text-xs">Your post will show up in Feed, on your profile and in search results.</p>
                </div>
                <div class="status-box-selected">
                    <div
                        :class="((statusPost == 0) ? 'bg-blue-50 ' : '') + 'flex justify-between items-center pointer p-2'">
                        <div class="flex items-center">
                            <div style="width:35px; height: 35px">
                                <ion-icon class="wh-95" name="earth-outline"></ion-icon>
                            </div>
                            <div class="text pl-2">
                                <p>Public</p>
                                <p class="text-sm">Anyone on or off HThe</p>
                            </div>
                        </div>
                        <input type="radio" value="0" v-model="statusPost" :checked="statusPost == 0"
                        >
                    </div>
                    <div
                        :class="((statusPost == 2) ? 'bg-blue-50 ' : '') + 'flex justify-between items-center pointer p-2'">

                        <div class="flex items-center">
                            <div style="width:35px; height: 35px">
                                <ion-icon class="wh-95" name="lock-closed-outline"></ion-icon>
                            </div>
                            <div class="text pl-2">
                                <p>
                                    Only me
                                </p>
                            </div>
                        </div>
                        <input type="radio" value="2" v-model="statusPost" :checked="statusPost == 2"
                        >
                    </div>
                    <div
                        :class="((statusPost == 1) ? 'bg-blue-50 ' : '') + 'flex justify-between items-center pointer p-2'">

                        <div class="flex items-center">
                            <div style="width:35px; height: 35px">
                                <ion-icon class="wh-95" name="person-circle-outline"></ion-icon>
                            </div>
                            <div class="text pl-2">
                                <p>Friend</p>
                                <p class="text-sm">Your friends on Hthe</p>
                            </div>
                        </div>
                        <input type="radio" value="1" v-model="statusPost" :checked="statusPost == 1"
                            >
                    </div>
                </div>
            </div>
            <template #footer>
                <div class="items-center w-full justify-between">
                    <a v-loading.fullscreen.lock="$store.state.loading" @click="changeStatusPost()" class="w-100 bg-blue-600 flex h-9 items-center justify-center rounded-lg text-white px-12 font-semibold createpost w-100 text-center">
                        Select </a>
                </div>
            </template>
        </el-dialog>
        <!-- Model Share-->
        <el-dialog v-model="showModalShare" custom-class="modal-mobile" align-center>
            <template #header>
                <div class="my-header">
                    <h5 class="pl-3 font-bold text-center">Write post</h5>
                </div>
            </template>
            <div class="modal-body">
                <div class="main-tab-share" v-if="shareView.type == 'main'">
                    <div class="flex flex-1 items-start space-x-4 p-1">
                        <img :src="'/uploads/users/' + $store.state.auth.user.profile_img"
                            class="bg-gray-200 border border-white rounded-full w-11 h-11">
                        <div class="flex-1 pt-1">
                            <div class="flex-1 mb-2">
                                <router-link :to="{ name: 'Profile', params: { id: $store.state.auth.user.user_id } }"
                                    class="text-black dark:text-gray-100 font-semibold d-block">
                                    {{ $store.state.auth.user.full_name }}
                                </router-link>
                                <span @click="toogleChangeStatus('open')"
                                    class="cursor-pointer text-gray-600 text-xs bg-gray-200 px-1.5 rounded-md py-1 items-center space-x-1">
                                    <ion-icon v-if="shared.status == 0" name="earth"></ion-icon>
                                    <ion-icon v-if="shared.status == 1" name="person-outline"></ion-icon>
                                    <ion-icon v-if="shared.status == 2" name="lock-closed-outline"></ion-icon>
                                    <span>{{status_list[shared.status]}}</span>
                                </span>
                            </div>
                            <textarea v-model="shared.content" class="uk-textare resize-none" rows="3"
                                :placeholder="`What's Your Mind ? ` + ($store.state.auth.user.first_name ?? $store.state.auth.user.full_name) + ` !`"></textarea>
                        </div>
                    </div>
                    <div class="post">
                        <PostContent :newfeed="sharePostView" />
                    </div>
                    <div class="flex items-center w-full justify-end border-t p-1 pt-4">
                        <!-- justify-between -->
                        <!-- <select v-model="shared.status" style="width: 7rem" class="mt-1 story">
                            <option value="0">Every one</option>
                            <option value="1">Friends </option>
                            <option value="2"> Only me</option>
                        </select> -->
                        <a @click="sharePost()"
                            class="bg-blue-600 flex h-9 items-center justify-center rounded-lg text-white px-6 font-semibold createpost w-full">
                            Share </a>
                    </div>
                </div>
                <div class="status-tab-share" v-if="shareView.type == 'status'">
                    <button class="d-flex items-center px-2" @click="toogleChangeStatus('close')">
                        <ion-icon :style="'font-size: 2rem'" name="arrow-back-circle-outline"></ion-icon>
                        <span class="ml-3">Post Audience</span>
                    </button>
                    <div class="status-box-selected my-2">
                        <div class="desc-attr mb-2">
                            <strong class="mb-1 d-block">
                                Who can see your post?
                            </strong>
                            <p class="text-xs">Your post will show up in Feed, on your profile and in search results.</p>
                        </div>
                        <div
                            :class="((statusPost == 0) ? 'bg-blue-50 ' : '') + 'flex justify-between items-center pointer p-2'">
                            <div class="flex items-center">
                                <div style="width:35px; height: 35px">
                                    <ion-icon class="wh-95" name="earth-outline"></ion-icon>
                                </div>
                                <div class="text pl-2">
                                    <p>Public</p>
                                    <p class="text-sm">Anyone on or off HThe</p>
                                </div>
                            </div>
                            <input :checked="shared.status == 0 ? true : false" type="radio" value="0" v-model="shareView.status">
                        </div>
                        <div
                            :class="((statusPost == 2) ? 'bg-blue-50 ' : '') + 'flex justify-between items-center pointer p-2'">

                            <div class="flex items-center">
                                <div style="width:35px; height: 35px">
                                    <ion-icon class="wh-95" name="lock-closed-outline"></ion-icon>
                                </div>
                                <div class="text pl-2">
                                    <p>
                                        Only me
                                    </p>
                                </div>
                            </div>
                            <input type="radio" :checked="shared.status == 2 ? true : false" value="2"  v-model="shareView.status">
                        </div>
                        <div
                            :class="((statusPost == 1) ? 'bg-blue-50 ' : '') + 'flex justify-between items-center pointer p-2'">

                            <div class="flex items-center">
                                <div style="width:35px; height: 35px">
                                    <ion-icon class="wh-95" name="person-circle-outline"></ion-icon>
                                </div>
                                <div class="text pl-2">
                                    <p>Friend</p>
                                    <p class="text-sm">Your friends on Hthe</p>
                                </div>
                            </div>
                            <input type="radio" :checked="shared.status == 1 ? true : false" value="1" v-model="shareView.status">
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button @click="saveSharedStatus()" class="w-full bg-blue-600 flex h-9 items-center justify-center rounded-lg text-white px-6 font-semibold">
                            <span class="ml-1">Change</span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- <template #footer>
                
            </template> -->
        </el-dialog>
    </section>
</template>
<style>
.wh-95 {
    width: 95%;
    height: 95%
}

.modal-mobile {
    width: 30% !important;
}
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.2s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
    opacity: 0;
}
.height-transition-enter-active, .height-transition-leave-active {
    transition: height .5s ease;
}
.height-transition-enter, .height-transition-leave-to /* .height-transition-leave-active trong Vue 2.1.8 trở về trước */ {
    height: 0;
    opacity: 0;
}
@media (max-width: 768px) {
    .modal-mobile {
        width: 90% !important;
    }
}
</style>
<style scoped></style>

<script>
import { ElMessage, ElMessageBox } from 'element-plus'
import { set } from 'lodash';
// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';

export default {
    props: ['newfeeds', 'hideAction'],
    data: () => {
        return {
            showDropdownAction: false,
            showModalLike: false,
            showModalShare: false,
            showModalStatus: false,
            isCommentBox: [],
            statusPost: null,
            current_post_id: null,
            post_index: null,
            status_list: {
                0: 'Public',
                1: 'Friend',
                2: 'Only me'
            
            },
            shared: {
                content: '',
                status: 0,
                post_id: '',
                index: ''
            },
            routeName: '',
            sharePostView: null,
            shareView: {
                type: 'main',
                status: null
            }
        }
    },
    computed: {
        react_list: {
            get: function () {
                return this.$store.getters.getReacts
            },
            set: function () {
                return
            }
        },
        getUser: function () {
            return this.$store.getters.getUser
        }
    },
    created() {
        this.routeName = this.$route.name
        if ((this.routeName == 'Detail') && typeof this.$route.params.id != 'undefined') {
            this.isCommentBox = [0]
        } else {
            this.isCommentBox = []
        }
    },
    updated() {
        window.Echo.channel('load-notification')
        .listen('NotificationPublished', (e) => {
            if (e.user_id == this.$store.getters.getUser.user_id){
                // this.$store.dispatch('loadNewNotification', e.notifications)
                this.$store.dispatch('countNotification', e.notifications)
                .then((response) => {
                    if (response.data.status == 200) {
                    
                    } else {
                    
                    }
                })
                .catch((err) => {
                    console.log(err)
                })
            }
        });    
    },
    mounted() {
    },
    methods: {
        toggleDisabledComment(post_id, keyNewFeed) {
            try {
                this.newfeeds[keyNewFeed]['disabled'] = !this.newfeeds[keyNewFeed]['disabled']
                if (this.newfeeds[keyNewFeed]['disabled'] == 1) {
                    this.$toast.default('Disabled comment for this post', { position: 'bottom-left', duration: 1000 });
                } else {
                    this.$toast.default('Enabled comment for this post', { position: 'bottom-left', duration: 1000 });
                }
                this.$store.dispatch('disabledComment', post_id)
            } catch (error) {
                console.log(error)
            }

        },
        showPost(post_id) {
            return this.$router.push({ name: 'Detail', params: { id: post_id } })
        },
        likedPost(post_id, keyNewFeed) {
            this.$store.dispatch('likedPost', {
                post_id: post_id,
                keyNewFeed: keyNewFeed,
                route: this.routeName,
            })
        },
        removePost(post_id, keyNewFeed) {
            ElMessageBox.confirm(
                'Items in your trash will be automatically deleted after 30 days. You can delete them from your trash earlier by going to activity log in settings.',
                'Are you sure remove to trash?',
                {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Cancel',
                    type: 'warning',
                    center: true,
                }
            )
            .then(() => {
                this.$store.dispatch('startLoading');
                this.newfeeds.splice(keyNewFeed, 1);
                this.$store.dispatch('removePost', {
                    post_id: post_id,
                    redirect: this.$route.name == 'Timeline' ? true : false
                }).then(response => {
                    setTimeout(() => {
                        this.$store.dispatch('stopLoading');
                        this.$toast.default('Remove to trash success', { position: 'bottom-left', duration: 1000 });
                    }, 1000);
                })
            })
            .catch(() => {
            })
        },
        turnOnReadMore(post_id, keyNewFeed, content) {
            let conutWord = content.split(" ").length;
            let conutChar = content.length;
            if (conutWord <= 300 || conutChar < 1300) {
                this.newfeeds[keyNewFeed]['readmore'] = true
                this.$store.dispatch('setContentNewFeed', { 'newNewfeedKey': keyNewFeed, 'content': content })
            } else {
                this.$store.dispatch('setContentNewFeed', { 'newNewfeedKey': keyNewFeed, 'content': content })
                this.showPost(post_id);
            }
        },
        async openCommentBox(post_id, keyNewFeed) {
            if (this.routeName != 'Detail') {
                // if (!this.$route.params.id) {
                if (!this.isCommentBox.includes(keyNewFeed)) {
                    this.isCommentBox.push(keyNewFeed);
                } else {
                    const index = this.isCommentBox.indexOf(keyNewFeed);
                    if (index > -1) {
                        this.isCommentBox.splice(index, 1);
                    }
                }
                // }
            }

            await this.$store.dispatch('loadComment', {
                post_id: post_id,
                keyNewFeed: keyNewFeed
            })
        },
        showModalShareBox(post_id, keyNewFeed, now = false) {
            this.shared.post_id = post_id
            this.shared.index = keyNewFeed
            this.shared.content = ''
            this.shared.status = 0
            this.sharePostView = this.newfeeds[keyNewFeed]
            this.shareView.type = 'main'
            if (now) {
                this.sharePost()
                return ;
            }
            this.showModalShare = true
        },
        sharePost() {
            if (this.shared.post_id != '') {
                this.shared.route = this.routeName
                this.$store.dispatch('sharedPost', this.shared).then(response => {
                    this.$toast.default('Shared Post', { position: 'bottom-left', duration: 1000 });
                    this.showModalShare = false
                    this.shared.post_id = ''
                    this.shared.index = ''
                    this.shared.route = ''
                })
            }
        },
        async showModalLiked(post_id) {
            await this.$store.dispatch('listUserReactPost', post_id)
            this.showModalLike = true
        },
        showModalChangeStatus(post_id, index) {
            this.showModalStatus = true
            this.statusPost = this.newfeeds[index].status;
            this.current_post_id = post_id,
                this.post_index = index
        },
        changeStatusPost() {
            this.$store.dispatch('changeStatusPost', {
                post_id: this.current_post_id,
                status: this.statusPost,
                index: this.post_index,
                route: this.routeName,
            }).then(response => {
                this.showModalStatus = false
                this.current_post_id = null
                this.post_index = null
                this.statusPost = null
            })
        },
        gotoProfile(user_id) {
            this.$router.push({ name: 'Profile', params: { id: user_id } });
        },
        toogleChangeStatus(type = 'open') {
            if (type == 'open') {
                this.shareView.type = 'status'
            } else {
                this.shareView.type = 'main'
                
            }
        },
        saveSharedStatus(status) {
            this.shared.status = this.shareView.status
            this.toogleChangeStatus('close')
        },
        updatedFeature(type = null) {
            ElMessage({
                message: 'Comming soon!',
                type: 'warning',
                duration: 5000,
                showClose: true,
            });
        }
    }
}
</script>
