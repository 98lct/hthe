<template>
    <div class="main_content">
        <div class="mcontainer">
            <div class="profile is_page">

                <div class="profiles_banner">
                    <img :src="'//assets/images/group/group-cover-1.jpg'" alt="">
                </div>
                <div class="profiles_content">
                    <div class="profile_avatar">
                        <div class="profile_avatar_holder">
                            <img :src="'/uploads/users/' + user.profile_img" alt="">
                        </div>
                        <div class="icon_change_photo" hidden> <ion-icon name="camera" class="text-xl"></ion-icon> </div>
                    </div>
                    <div class="profile_info">
                        <h1> {{ user.full_name }} </h1>
                        <p> {{ friends.length }} Friends</p>
                    </div>
                    <div class="flex items-center space-x-4" v-if=" is_friend == false && is_request == true">
                        <div class="flex items-center -space-x-4">
                        </div>
                        <button @click="appect(user.user_id)" type="button" class="inline-flex border-2 ml-1 bg-blue-500 text-white px-2 rounded">Appect</button>
                        <button @click="decline(user.user_id)" type="button" class="inline-flex border-2 ml-1 bg-gray-200 px-2 rounded">Delete</button>
                    </div>
                    <div class="flex items-center space-x-4" v-if="$store.getters.getUser.user_id != $route.params.id">
                        <div class="flex items-center -space-x-4">
                        </div>
                        <button v-if="is_friend == true" @click="unFriend(user.user_id)" type="button" class="inline-flex border-2 text-white ml-1 bg-blue-500 px-4 py-2 rounded">Friend</button>
                        <button v-if="is_friend == false && is_request == false" @click="sendRequest(user.user_id)" type="button" class="inline-flex border-2 text-white ml-1 bg-blue-500 px-4 py-2 rounded">add Friend</button>
                        <button v-if="is_request == true" @click="unSendRequest(user.user_id)" type="button" class="inline-flex border-2 text-white ml-1 bg-blue-500 px-4 py-2 rounded">remove request</button>
                        <button type="button" class="inline-flex border-2 text-white ml-1 bg-blue-400 px-4 rounded py-2">Messager</button>
                    </div>
                </div>

                <nav class="responsive-nav border-t -mb-0.5 lg:pl-2">
                    <ul>
                        <li :class="active_tab == 'Home' ? 'active' : ''"><a @click="switchTab('Home')"> Home</a></li>
                        <li :class="active_tab == 'Friends' ? 'active' : ''"><a @click="switchTab('Friends')">Friends</a></li>
                        <!-- <li><a href="#0">Photos</a></li>
                        <li><a href="#0">Reviews</a></li>
                        <li><a href="#0">Discussion</a></li>
                        <li><a href="#0">Videos</a></li>
                        <li><a href="#0">About</a></li> -->
                    </ul>
                </nav>
            </div>
            <div v-if="active_tab == 'Home'" class="md:flex md:space-x-6 lg:mx-0">
                <div class="space-y-5 flex-shrink-0 md:w-7/12">
                    <NewPost v-if="($store.getters.getUser.user_id == $route.params.id)" :data="postData" />
                    <Post :hideAction="true" @stateActionPost="getStateActionPost" :newfeeds="newfeeds" />
                </div>
                <div class="w-full flex-shirink-0">
                    <div class="card p-5 mb-5">
                        <h1 class="block text-lg font-bold"> About </h1>
                        <div class="space-y-4 mt-3">
                            <div class="flex items-center space-x-3">{{ user.introduce }}</div>
                            <div class="flex items-center space-x-3">
                                <ion-icon name="alert-circle" class="bg-gray-100 p-1.5 rounded-full text-xl"></ion-icon>
                                <div class="flex-1">
                                    <div> {{ user.live_at }} </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <ion-icon name="globe" class="bg-gray-100 p-1.5 rounded-full text-xl"></ion-icon>
                                <div class="flex-1">
                                    <div> <a href="#" class="text-blue-500"> {{ user.social_address }} </a> </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <ion-icon name="mail-open" class="bg-gray-100 p-1.5 rounded-full text-xl"></ion-icon>
                                <div class="flex-1">
                                    <div> <a href="#" class="text-blue-500">{{ user.email }}</a> </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <ion-icon name="heart" class="bg-gray-100 p-1.5 rounded-full text-xl"></ion-icon>
                                <div class="flex-1">
                                    <div>
                                        <span v-if="user.marital_status == 0">Singel</span>
                                        <span v-if="user.marital_status == 1">Tìm hiểu</span>
                                        <span v-if="user.marital_status == 2">Dating</span>
                                        <span v-if="user.marital_status == 3">Married</span>
                                        <span v-if="user.marital_status == 4">Relict</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="widget card p-5 border-t" v-if="$store.getters.getUser.user_id == $route.params.id">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <h4 class="text-lg font-semibold"> Related Friends </h4>
                            </div>
                            <!-- <a href="#" class="text-blue-600 "> See all</a> -->
                        </div>
                        <div class="friend-suggest">
                            <FriendsSuggest :friend_suggests="friends_suggest"/>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="active_tab == 'Friends'" class="md:flex md:space-x-6 lg:mx-0 bg-white border-gray-200 border rounded-2xl">
                <div class="space-y-5 flex-shrink-0">
                    <div class="grid md:grid-cols-3 grid-cols-3 gap-x-2 gap-y-4 m-3">
                        <div v-for="friend in friends" class="flex items-center flex-col md:flex-row justify-center p-2 rounded-md shadow hover:shadow-md md:space-x-2">
                            <router-link :to="{name: 'Profile', params:{id:  friend.user_id }}" class="w-16 h-16 flex-shrink-0 overflow-hidden rounded-full relative">
                                <img :src="'/uploads/users/' + friend.profile_img" class="absolute w-full h-full inset-0 " alt="">
                            </router-link>
                            <div class="flex-1">
                                <router-link :to="{name: 'Profile', params:{id:  friend.user_id }}" class="text-base font-semibold capitalize">{{ friend.full_name }}</router-link>
                                <div class="text-sm text-gray-500">@{{ friend.username ?? friend.user_id }}</div>
                            </div>
                            <button v-if="friend.user_id != $store.getters.getUser.user_id" class="bg-blue-600 text-white font-semibold py-2 px-3 rounded-md text-sm md:mt-0 mt-3">
                                Friend
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import FriendsSuggest from '../components/FriendsSuggestRow.vue';
import NewPost from '../components/NewPost.vue';
import Post from '../components/Post.vue';
</script>
<script>
export default {
    data: () => {
        return {
            postData: null,
            user: [],
            newfeeds: [],
            un_send: false,
            is_friend: false,
            is_request: false,
            active_tab: 'Home',
            friends: [],
            friends_suggest: []
        }
    },
    computed: {
        newfeeds: function () {
            return (this.$store.getters.getNewFeed)
        },
        // user: {
        //     get() {
        //         if (this.$route.params.id == this.$store.getters.getUser.user_id) {
        //             return this.$store.getters.getUser
        //         }
        //         else {
        //             console.log('vo nè')
        //             return this.user
        //         }
        //     },
        //     set() {
        //         alert('set lại nè')
        //     }
        // },
        // friends: function () {
        //     return this.$store.getters.getFriends
        // },
        // friend_suggests: function () {
        //     return this.$store.getters.getFriendSuggests
        // },
    },
    created() {
        let user_id = this.$route.params.id
        if (typeof user_id != undefined) {
            this.getUser(user_id);
            this.$store.dispatch('loadNewfeeds', user_id);
        }
    },
    watch: {
        '$route.params.id': {
            handler: function (newValue, old) {
                if (typeof newValue != 'undefined' && old != 'undefined'){
                    this.getUser(newValue);
                    this.getNewFeed(newValue)
                }
            },
            deep: true,
            immediate: true
        }
    },
    methods: {
        switchTab(tab_name){
            this.active_tab = tab_name
        },
        getStateActionPost(value) {
            this.postData = value.newfeed
            this.postData['key'] = value.key
        },
        getUser(user_id){
            if (typeof user_id != 'undefined') {
                return axios.get(`/api/u/${user_id}`, {}).then(response => {
                    this.user = response.data.user
                    this.friends = response.data.friends
                    this.friends_suggest = response.data.friends_suggest
                    this.is_friend = response.data.is_friend
                    this.is_request = response.data.is_request
                })
            }
        },
        getNewFeed(user_id){
            this.$store.dispatch('loadNewfeeds', user_id);
        },
        appect(requested_by) {
            this.$store.dispatch('appectRequest', {requested_by: requested_by}).then(response => {
                this.$toast.default(response.data.message, { position: 'top', duration: 1000 });
                this.is_friend = true;
                this.is_request = false;
            })
        },
        decline(requested_by) {
            this.$store.dispatch('declineRequest', {requested_by: requested_by}).then(response => {
                this.$toast.default(response.data.message, { position: 'top', duration: 1000 });
                this.is_friend = false;
                this.is_request = false;
            })
        },
        sendRequest(requested_by){
            this.$store.dispatch('sendRequest', {requested_by: requested_by, index: null}).then(response => {
                this.$toast.default(response.data.message, { position: 'top', duration: 1000 });
                this.unsend = true;
            })
        },
        unSendRequest(requested_by){
            this.$store.dispatch('unSendRequest', {requested_by: requested_by, index: null}).then(response => {
                this.$toast.default(response.data.message, { position: 'top', duration: 1000 });
                this.unsend = false;
                this.is_friend = false;
                this.is_request = false;
            })
        },
        unFriend(requested_by) {
            this.$confirm({
                title: 'Are you sure unfriend?',
                message: 'After unfriending someone, you will need to send a friend request and wait for their approval again.',
                button: {
                    yes: 'Yes',
                    no: 'Cancel'
                },
                callback: confirm => {
                    if (confirm) {
                        this.$store.dispatch('unFriend', {requested_by: requested_by}).then(response => {
                            this.$toast.default(response.data.message, { position: 'top', duration: 1000 });
                            this.is_friend = false;
                            this.is_request = false;
                        })
                    }
                }
            })
        }
    },
}
</script>