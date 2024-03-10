<template>
<div @click="openModalPost()" class="card lg:mx-0 p-4">
    <div class="flex space-x-3">
        <img :src="'/uploads/users/' + $store.getters.getUser.profile_img" class="w-10 h-10 rounded-full">
        <input readonly :placeholder="`What's Your Mind ? ` + ($store.state.auth.user.first_name ?? $store.state.auth.user.full_name) + ` !`" class="bg-gray-100 hover:bg-gray-200 flex-1 h-10 px-6 rounded-full">
    </div>
    <div class="grid grid-flow-col pt-3 -mx-1 -mb-1 font-semibold text-sm">
        <div class="hover:bg-gray-100 flex items-center p-1.5 rounded-md cursor-pointer">
            <svg class="bg-blue-100 h-9 mr-2 p-1.5 rounded-full text-blue-600 w-9 -my-0.5 hidden lg:block" data-tippy-placement="top" title="Tooltip" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                </path>
            </svg>
            Photo /Album
        </div>
        <div class="hover:bg-gray-100 flex items-center p-1.5 rounded-md cursor-pointer">
            <svg class="bg-green-100 h-9 mr-2 p-1.5 rounded-full text-green-600 w-9 -my-0.5 hidden lg:block" uk-tooltip="title: Messages ; pos: bottom ;offset:7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" title="" aria-expanded="false">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                </path>
            </svg>
            Tags Friend
        </div>
        <div class="hover:bg-gray-100 flex items-center p-1.5 rounded-md cursor-pointer">
            <svg class="bg-red-100 h-9 mr-2 p-1.5 rounded-full text-red-600 w-9 -my-0.5 hidden lg:block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                </path>
            </svg>
            Fealing /Activity
        </div>
        <!-- <div class="hover:bg-gray-100 flex items-center p-1.5 rounded-md cursor-pointer">
                <svg class="bg-yellow-100 h-9 ml-2 mr-1 pr-1 pl-1.5 rounded-full text-gray-600 w-9 -my-0.5 hidden lg:block"
                fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"></path>
                </svg>
                Memory
            </div> -->
    </div>
</div>

<el-dialog v-model="popupCreatePost" custom-class="modal-mobile" align-center>
    <div class="d-block" v-if="statusView.type == 'main'">
        <div class="flex flex-1 items-start space-x-4">
            <img :src="'/uploads/users/' + $store.state.auth.user.profile_img" class="bg-gray-200 border border-white rounded-full w-11 h-11">
            <div>
                <div class="flex-1 font-semibold">
                    <router-link :to="{ name: 'Profile', params: { id: $store.state.auth.user.user_id } }"
                        class="text-black dark:text-gray-100">{{ typeof ($store.state.auth.user) !== undefined ?
                            $store.state.auth.user.full_name
                            : '' }}</router-link>
                    <span v-if="feeling_id || activity_id" class="ml-1"> is </span>
                    <span v-if="feeling_id != null" class="post-feeling font-bold">
                        <font-awesome-icon :class="'fa-lg mx-1 ' + feeling_selected.class" :icon="feeling_selected.icon"  />
                        <span>feeling</span>
                        <span class="mx-1 text-gray-500"> {{ feeling_selected.text }}</span>
                    </span>
                    <span v-if="feeling_id && activity_id"> and </span>
                    <span v-if="activity_id != null" class="post-activity">
                        <font-awesome-icon :class="'fa-lg mx-1 ' + activity_selected.class" :icon="activity_selected.icon"  />
                        <span>doing</span>
                        <span class="mx-1 text-gray-500"> {{ activity_selected.text }}</span>
                    </span>
                    <span v-if="location_id != null"> at </span>
                    <span v-if="location_id != null" class="post-activity">
                        <span class="mx-1 text-gray-500"> {{ location_selected.text }}</span>
                    </span>
                </div>
                <div
                    @click="toogleChangeStatus(type = 'open')"
                    class="d-inline-block cursor-pointer text-gray-600 text-xs bg-gray-200 px-1.5 rounded-md py-1 mt-1 items-center space-x-1">
                    <ion-icon v-if="status == 0" name="earth"></ion-icon>
                    <ion-icon v-if="status == 1" name="person-outline"></ion-icon>
                    <ion-icon v-if="status == 2" name="lock-closed-outline"></ion-icon>
                    <span>{{status_list[status]}}</span>
                </div>
            </div>
        </div>
        <div class="flex flex-1 items-start space-x-4">
            <div class="flex-1 pt-3">
                <textarea v-model="content" class="uk-textare text-black shadow-none focus:shadow-none text-xl font-medium resize-none" rows="1" :placeholder="`What's Your Mind ? ` + ($store.state.auth.user.first_name ?? $store.state.auth.user.full_name) + ` !`"></textarea>
            </div>
        </div>
        <div class="post-content space-x-4" style="max-height: 25vh; overflow-y:auto">
            <Post v-if="this.data != null" :newfeeds="[this.data]" />
        </div>
        <div v-if="mediaPreview.length > 0" class="post-content space-x-2 p-2">
            <div class="grid grid-cols-4 gap-4">
                <img v-for="(media,key) in mediaPreview" @click="removeImage(key)" class="bg-gray-200 border object-cover " style="height: 100px; width: 100%" :src="media" />
            </div>
        </div>
        <div class="bsolute bottom-0 space-x-4 w-full">
            <div class="flex bg-gray-50 border border-purple-100 rounded-2xl p-2 shadow-sm items-center">
                <div class="lg:block hidden ml-1"> Add to your post </div>
                <div class="flex flex-1 items-center lg:justify-end justify-center space-x-2">

                    <svg @click="
                        this.$refs.imageFile.click()
                      " title="photo /album" class="bg-blue-100 h-9 p-1.5 rounded-full text-blue-600 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <svg  @click="
                    this.$refs.videoFile.click()
                  " class="text-red-600 h-9 p-1.5 rounded-full bg-red-100 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"> </path>
                    </svg>
                    <input style="display: none" @change="chooseMedia($event)" type="file" accept="image/png, image/jpeg, image/jpg" ref="imageFile" multiple>
                    <input style="display: none" @change="chooseMedia($event)"  type="file" accept="video/mp4" ref="videoFile" multiple>
                    <!-- <svg class="text-green-600 h-9 p-1.5 rounded-full bg-green-100 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg> -->
                    <svg
                    @click="openModalLocation"
                    class="text-pink-600 h-9 p-1.5 rounded-full bg-pink-100 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"> </path>
                    </svg>
                    <svg 
                    @click="openModalActivity"
                    class="text-blue-500 h-9 p-1.5 rounded-full bg-yellow-300 w-9 -my-0.5 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    <!-- <svg class="text-pink-600 h-9 p-1.5 rounded-full bg-pink-100 w-9 cursor-pointer" id="veiw-more" hidden fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"> </path></svg> -->
                    <!-- <svg class="text-pink-600 h-9 p-1.5 rounded-full bg-pink-100 w-9 cursor-pointer" id="veiw-more" hidden fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg> -->
                    <!-- <svg class="text-purple-600 h-9 p-1.5 rounded-full bg-purple-100 w-9 cursor-pointer" id="veiw-more" hidden fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path> </svg> -->

                    <!-- view more -->
                    <!-- <svg class="hover:bg-gray-200 h-9 p-1.5 rounded-full w-9 cursor-pointer" id="veiw-more" uk-toggle="target: #veiw-more; animation: uk-animation-fade" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"> </path></svg> -->
                </div>
            </div>
        </div>
        <!--Button action-->
        <div class="flex items-center w-full justify-between mt-4 mb-2">
            <a @click="uploadPost" v-loading.fullscreen.lock="$store.state.loading" class="bg-blue-600 flex h-9 w-full items-center justify-center rounded-lg text-white px-12 font-semibold createpost">
                Post </a>
        </div>
    </div>
    <!--Status change post-->
    <div class="status-tab-share" v-if="statusView.type == 'status'">
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
                :class="((statusView.status == 0) ? 'bg-blue-50 ' : '') + 'flex justify-between items-center pointer p-2'">
                <div class="flex items-center">
                    <div style="width:35px; height: 35px">
                        <ion-icon class="wh-95" name="earth-outline"></ion-icon>
                    </div>
                    <div class="text pl-2">
                        <p>Public</p>
                        <p class="text-sm">Anyone on or off HThe</p>
                    </div>
                </div>
                <input :checked="status == 0 ? true : false" type="radio" value="0" v-model="statusView.status">
            </div>
            <div
                :class="((statusView.status == 2) ? 'bg-blue-50 ' : '') + 'flex justify-between items-center pointer p-2'">

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
                <input type="radio" :checked="status == 2 ? true : false" value="2"  v-model="statusView.status">
            </div>
            <div
                :class="((statusView.status == 1) ? 'bg-blue-50 ' : '') + 'flex justify-between items-center pointer p-2'">

                <div class="flex items-center">
                    <div style="width:35px; height: 35px">
                        <ion-icon class="wh-95" name="person-circle-outline"></ion-icon>
                    </div>
                    <div class="text pl-2">
                        <p>Friend</p>
                        <p class="text-sm">Your friends on Hthe</p>
                    </div>
                </div>
                <input type="radio" :checked="status == 1 ? true : false" value="1" v-model="statusView.status">
            </div>
        </div>
        <div class="flex justify-end">
            <button @click="saveChangeStatus()" class="w-full bg-blue-600 flex h-9 items-center justify-center rounded-lg text-white px-6 font-semibold">
                <span class="ml-1">Change</span>
            </button>
        </div>
    </div>
    <template #header>
        <div class="flex items-center w-full justify-center">
            <h5 class="font-bold"> Post</h5>
        </div>
    </template>
</el-dialog>
<!-- activity/ feeling -->
<el-dialog v-model="popupAddActivityPost" custom-class="modal-mobile" align-center>
    <div class="d-block">
        <el-tabs v-model="TabFeeling" @tab-click="handleClick">
            <el-tab-pane  label="Feeling" ref="feeling" name="feeling" style="max-height: 25vh; overflow-y:auto">
                <div class="flex flex-1 items-start space-x-4" v-if="!feeling_selected.id">
                    <el-input
                        v-model="feeling_keywork"
                        placeholder="Type feeling keywork"
                        size="small"
                    >
                        <template #prepend>
                            <font-awesome-icon class="fa-1x" icon="fa-search" />
                        </template>
                    </el-input>
                </div>
                <div v-if="feeling_selected.id" class="flex items-center justify-between mt-3">
                    <p class="font-bold text-center italic">
                        <span class="mr-2">feeling...</span> <font-awesome-icon :class="'fa-lg ' + feeling_selected.class" :icon="feeling_selected.icon"  />
                        <span class="ml-2">{{ feeling_selected.text }}</span>
                    </p>
                    <button class="d-flex items-center" @click="clearFeeling">
                        <ion-icon :style="'font-size: 1rem'" name="close-outline"></ion-icon>
                        <span class="ml-1"></span>
                    </button>
                </div>
                <div class="feeling-items mt-3">
                    <div v-for="feeling in $store.getters.feeling" class="mb-2 w-1/2 d-inline-block">
                        <div class="flex space-x-2 items-start" @click="chooseFeeling(feeling)">
                            <font-awesome-icon :class="'fa-2x ' + feeling.feel_class" :icon="feeling.feel_icon"  />
                            <span class="text-capitalize capitalize cursor-pointer" >{{feeling.feel_name}}</span>
                        </div>
                    </div>
                </div>
            </el-tab-pane>
            <el-tab-pane label="Activity" ref="activity" name="activity" style="max-height: 25vh; overflow-y:auto">
                <div class="flex flex-1 items-start space-x-4" v-if="!activity_selected.id">
                    <el-input
                        v-model="activity_keywork"
                        placeholder="Type activity keywork"
                        size="small"
                    >
                        <template #prepend>
                            <font-awesome-icon class="fa-1x" icon="fa-search" />
                        </template>
                    </el-input>
                </div>
                <div v-if="activity_selected.id" class="flex items-center w-full justify-between mt-3">
                    <p class="font-bold text-center italic">
                        <span class="mr-2">doing...</span> <font-awesome-icon :class="'fa-lg ' + activity_selected.class" :icon="activity_selected.icon"  />
                        <span class="ml-2">{{ activity_selected.text }}</span>
                    </p>
                    <button class="d-flex items-center" @click="clearActivity">
                        <ion-icon :style="'font-size: 1rem'" name="close-outline"></ion-icon>
                        <span class="ml-1"></span>
                    </button>
                </div>
                <div class="activity-items mt-3">
                    <div v-for="activity in $store.getters.activity" class="mb-2">
                        <div class="flex flex-1 space-x-2 items-start" @click="chooseActivity(activity)">     
                            <font-awesome-icon :class="'fa-2x w-10 ' + activity.feel_class" :icon="activity.feel_icon"  />
                            <p class="text-capitalize capitalize cursor-pointer" >{{activity.feel_name}}</p>
                        </div>
                    </div>
                </div>
            </el-tab-pane>
        </el-tabs>
    </div>
    <template #header>
        <div class="flex items-center w-full justify-start">
            <button class="d-flex items-center mr-3" @click="backModalPost">
                <ion-icon :style="'font-size: 2rem'" name="arrow-back-circle-outline"></ion-icon>
                <span class="ml-1"></span>
            </button>
            <p>How are you feeling?</p>
        </div>
    </template>
    <template #footer>
        <div class="items-center w-full justify-between">
            <a v-loading.fullscreen.lock="$store.state.loading" @click="selectedFeelAndActivity" class="w-100 bg-blue-600 flex h-9 items-center justify-center rounded-lg text-white px-12 font-semibold createpost w-100 text-center">
                Select </a>
        </div>
    </template>
</el-dialog>
<!-- Location -->
<el-dialog v-model="popupAddLocationPost" custom-class="modal-mobile" align-center>
    <div class="d-block">
        <div class="flex flex-1 items-start space-x-4" v-if="!location_selected.id">
            <el-input
                v-model="feeling_keywork"
                placeholder="Where are you ?"
                size="small"
            >
                <template #prepend>
                    <font-awesome-icon class="fa-1x" icon="fa-search" />
                </template>
            </el-input>
        </div>
        <div class="mt-3" v-for="location in $store.getters.location" >
            <div class="flex flex-1 items-center"  @click="chooseLocation(location)">
                <font-awesome-icon class="fa-2x fa-location-dot" icon="fa-location-dot"  />
                <div class="ml-4">
                    <p class="text-capitalize capitalize cursor-pointer font-bold" >{{location.location_short_name}}</p>
                    <p class="text-capitalize capitalize cursor-pointer text-sm" >{{location.location_name}}</p>
                </div>
            </div>
        </div>
    </div>
    <template #header>
        <div class="flex items-center w-full justify-start">
            <button class="d-flex items-center mr-3" @click="backModalPost">
                <ion-icon :style="'font-size: 2rem'" name="arrow-back-circle-outline"></ion-icon>
                <span class="ml-1"></span>
            </button>
            <p>Search for location</p>
        </div>
    </template>
    <!-- <template #footer>
        
    </template> -->
</el-dialog>
</template>
<style>
.modal-mobile {
    width: 40% !important;
}
@media (max-width: 768px) {
    .modal-mobile {
        width: 90% !important;
    }
}
.el-tabs__nav {
    justify-content: space-around;
    float: unset !important;
}
</style>
<script>
import Post from './Post.vue';

export default {
    props: ['data'],
    data: () => {
        return {
            content: '',
            disabled: false,
            status: 0,
            status_list: {
                0: 'Public',
                1: 'Friend',
                2: 'Only me'
            },
            popupCreatePost: false,
            popupAddActivityPost: false,
            popupAddLocationPost: false,
            action: 'Create',
            newfeed_id: '',
            key: '',
            newfeed: null,
            mediaPreview:[],
            media:[],
            fullscreenLoading: {
                value: false,
                lock: false
            },
            feeling_id: null,
            location_id: null,
            activity_id: null,
            activity_keywork: null,
            feeling_keywork: null,
            location_keywork: null,
            TabFeeling: 'feeling',
            statusView:{
                type: 'main',
                status: 0
            },
            feeling_selected: {
                text: '',
                id: null,
                class: '',
                icon: ''
            },
            activity_selected: {
                text: '',
                id: null,
                class: '',
                icon: ''
            },
            location_selected: {
                text: '',
                id: null
            }
        }
    },
    computed: {
        data: () => {
            return this.data
        },
        newfeed: () => {
            return [this.data]
        },
    },
    watch: {
        data: function (newData, oldData) {
            let mediaPreview = newData.medias.map(media => {
                // return "https://hthe.site/uploads/media/" + media.src
                // return "http://localhost:81/uploads/media/" + media.src
                return $store.state.index.mediaPath + media.src
            })
            mediaPreview.forEach(m => {
                this.renderMedia(m)
            })
            if (newData != null && newData !== oldData) {
                this.status = newData.status
                this.newfeed_id = newData.post_id
                this.content = newData.content
                this.action = 'Edit'
                this.popupCreatePost= true,
                this.key = newData.key
            } else {
                this.status = 0
                this.newfeed_id = ''
                this.content = ''
                this.action = 'Create'
                this.popupCreatePost= false,
                this.data= null,
                this.key = '',
                this.media = [],
                this.mediaPreview = []
            }
        }
    },
    unmounted(){
        // this.data = null
    },
    created() {
        
    },
    mounted(){
    },
    methods: {
        uploadPost() {
            this.fullscreenLoading.value = true
            if (this.content.length == 0) {
                return
            } else {
                this.$store.dispatch('uploadPost', {
                    content: this.content,
                    post_id: this.newfeed_id,
                    status: this.status,
                    action: this.action,
                    key: this.key,
                    media: this.media,
                    activity: this.activity_id,
                    feeling: this.feeling_id,
                    location_id: this.location_id,
                }).then(response => {
                    this.content = ''
                    this.status = 1
                    this.closeModalPost()
                    this.action = 'Create',
                    this.key = '',
                    this.media = [],
                    this.mediaPreview = [],
                    this.activity_id = null,
                    this.feeling_id = null,
                    this.location_id = null
                })
            }
        },
        openModalPost() {
            this.popupCreatePost = true,
            this.mediaPreview = [],
            this.content = '';
            this.statusView = {
                type: 'main',
                status: 0
            }
        },
        openModalActivity(){
            this.popupAddActivityPost = true
        },
        openModalLocation(){
            this.popupAddLocationPost = true
        },
        closeModalActivity(){
            this.popupAddActivityPost = false;
            this.clearActivity();
            this.clearFeeling();
        },
        backModalPost(){
            this.popupAddActivityPost = false;
            this.popupAddLocationPost = false;
        },
        closeModalPost() {
            this.popupCreatePost = false
        },
        clearFeeling(){
            this.feeling_selected = {
                text: '',
                id: null,
                class: '',
                icon: ''
            }
        },
        clearActivity(){
            this.activity_selected = {
                text: '',
                id: null,
                class: '',
                icon: ''
            }
        },
        selectedFeelAndActivity(){
            this.feeling_id = this.feeling_selected.id;
            this.activity_id = this.activity_selected.id;
            this.backModalPost()
        },
        selectedLocation(){
            this.location_id = this.location_selected.id;
            this.backModalPost()
        },
        chooseFeeling(feeling) {
            this.feeling_selected = {
                text: feeling.feel_name,
                id: feeling.feel_id,
                class: feeling.feel_class,
                icon: feeling.feel_icon
            }
        },
        chooseActivity(activity) {
            this.activity_selected = {
                text: activity.feel_name,
                id: activity.feel_id,
                class: activity.feel_class,
                icon: activity.feel_icon
            }
        },
        chooseLocation(location) {
            this.location_selected = {
                text: location.location_name,
                id: location.location_id,
            }
            this.selectedLocation()
        },
        toogleChangeStatus(type = 'open') {
            if (type == 'open') {
                this.statusView.type = 'status'
            } else {
                this.statusView.type = 'main'
                this.statusView.status = this.status
            }
        },
        toogleChangeStatus(type = 'open') {
            if (type == 'open') {
                this.statusView.type = 'status'
            } else {
                this.statusView.type = 'main'
                this.statusView.status = this.status
            }
        },
        saveChangeStatus(status) {
            this.status = this.statusView.status
            this.toogleChangeStatus('close')
        },
        chooseMedia(e) {
            let object = e.target.files;
            for (let key in object) {
                let size = object[key].size
                if(size > 3072000) {
                    alert('Vui lòng chọn ảnh bé hơn 3MB')
                    return
                }
                this.createImage(object[key]);
                this.media.push(object[key])
            }
        },
        renderMedia(imageSrc){
            return new Promise((resolve, reject) => {
                fetch(imageSrc)
                .then(response => response.blob())
                .then(blob => {
                    this.createImage(blob)
                    this.media.push(blob)
                })
                .catch(error => {
                    console.error('Error capturing image:', error);
                });
            })
        },
        createImage(file) {
            var image = new Image();
            var reader = new FileReader();
            var vm = this;

            reader.onload = (e) => {
                vm.mediaPreview.push(e.target.result);
            };
            reader.readAsDataURL(file);
        },
        removeImage: function (key) {
           this.mediaPreview.splice(key, 1);
           this.media.splice(key, 1);
        }
    }
}
</script>
<style scoped>
.el-dialog .el-dialog__body {
    padding: 5px 25px !important
}
</style>