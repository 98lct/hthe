
<template>
    <header class="header-top">
        <div class="header_wrap">
            <div class="header_inner mcontainer">
                <div class="left_side">
                    <span class="slide_menu" uk-toggle="target: #wrapper ; cls: is-collapse is-active">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M3 4h18v2H3V4zm0 7h12v2H3v-2zm0 7h18v2H3v-2z" fill="currentColor"></path></svg>
                    </span>

                    <div id="logo">
                        <a href="/">
                            <img :src="'/assets/images/logo.png'" alt="">
                            <img :src="'/assets/images/logo.png'" class="logo_mobile" alt="">
                        </a>
                    </div>
                </div>
                <!-- search icon for mobile -->
                <div class="header-search-icon" uk-toggle="target: #wrapper ; cls: show-searchbox"> </div>
                <div class="header_search"><i class="uil-search-alt"></i>
                    <input value="" type="text" class="form-control" placeholder="Search for Friends , Videos and more.." autocomplete="off">
                    <div uk-drop="mode: click" class="header_search_dropdown">

                        <h4 class="search_title"> Recently </h4>
                        <ul>
                            <li>
                                <a href="#">
                                    <!-- <img src="/assets/images/avatars/avatar-1.jpg" alt="" class="list-avatar"> -->
                                    <div class="list-name">  Erica Jones </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <!-- <img src="/assets/images/avatars/avatar-2.jpg" alt="" class="list-avatar"> -->
                                    <div class="list-name">  Coffee  Addicts </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="right_side">
                    <div class="header_widgets">
                        <router-link :to="{name: 'Timeline'}" class="is_icon" uk-tooltip="title: Timeline">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 24 24">
                                <path d="M 12 2.0996094 L 1 12 L 4 12 L 4 21 L 10 21 L 10 14 L 14 14 L 14 21 L 20 21 L 20 12 L 23 12 L 12 2.0996094 z"></path>
                            </svg>
                        </router-link>
                        <a href="#" class="is_icon" uk-tooltip="title: Notifications" @click="loadNotification()">
                            <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
                            <span v-if="unread_notification > 0">{{unread_notification }}</span>
                        </a>
                        <div uk-drop="mode: click" class="header_dropdown" @click="loadNotification()">
                            <div class="dropdown_scrollbar" data-simplebar>
                                <div class="drop_headline">
                                    <h4>Notifications </h4>
                                    <div class="btn_action">
                                    <a href="#" data-tippy-placement="left" title="Notifications">
                                        view
                                    </a>
                                    <a href="#" @click="$store.dispatch('readAllNotification', $store.getters.getUser.user_id)" data-tippy-placement="left" title="Mark as read all">
                                        <ion-icon name="checkbox-outline"></ion-icon>
                                    </a>
                                </div>
                                </div>
                                <Notification :notifications="notifications" />
                            </div>
                        </div>
                        <a href="#" class="is_icon" uk-tooltip="title: Friends request">
                            <svg width="30" height="30" viewBox="2 4 19 17" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7ZM14 7C14 8.10457 13.1046 9 12 9C10.8954 9 10 8.10457 10 7C10 5.89543 10.8954 5 12 5C13.1046 5 14 5.89543 14 7Z" fill="currentColor" /><path d="M16 15C16 14.4477 15.5523 14 15 14H9C8.44772 14 8 14.4477 8 15V21H6V15C6 13.3431 7.34315 12 9 12H15C16.6569 12 18 13.3431 18 15V21H16V15Z" fill="currentColor" /></svg>
                        </a>
                        <div uk-drop="mode: click;offset:5" class="header_dropdown dropdown_cart">
                            <div class="dropdown_scrollbar" data-simplebar>
                                <div class="drop_headline">
                                    <h4>Friend Requests </h4>
                                    <div class="btn_action">
                                        <!-- <a href="#" data-tippy-placement="left" title="Notifications">
                                            view
                                        </a> -->
                                        <a href="#" @click="$store.dispatch('readAllNotification', $store.getters.getUser.user_id)" data-tippy-placement="left" title="Mark as read all">
                                            <ion-icon name="checkbox-outline"></ion-icon>
                                        </a>
                                    </div>
                                </div>
                                <FriendsRow :friend_requests="friend_requests" />
                            </div>
                        </div>
                        <router-link :to="{name: 'Message'}" class="is_icon" uk-tooltip="title: Message">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 50 50">
                                <path d="M 25 2 C 12.300781 2 2 11.601563 2 23.5 C 2 29.800781 4.898438 35.699219 10 39.800781 L 10 48.601563 L 18.601563 44.101563 C 20.699219 44.699219 22.800781 44.898438 25 44.898438 C 37.699219 44.898438 48 35.300781 48 23.398438 C 48 11.601563 37.699219 2 25 2 Z M 27.300781 30.601563 L 21.5 24.398438 L 10.699219 30.5 L 22.699219 17.800781 L 28.601563 23.699219 L 39.101563 17.800781 Z"></path>
                            </svg>
                        </router-link>  
                        <a href="#">
                            <img :src="'/assets/images/account.jpg'" class="is_avatar" alt="">
                        </a>
                        <div uk-drop="mode: click;offset:5" class="header_dropdown profile_dropdown">
                            <router-link :to="{name: 'Profile', params:{id: $store.getters.getUser.user_id}}" class="user">
                                <div class="user_avatar">
                                    <img class="object-cover h-full w-full" :src="'uploads/users/' + $store.state.auth.user.profile_img" alt="">
                                </div>
                                <div class="user_name">
                                    <div> {{ $store.state.auth.user.full_name }}</div>
                                    <span v-if="$store.state.auth.user.username"> @{{ $store.state.auth.user.username }}</span>
                                </div>
                            </router-link>
                            <hr>
                            <router-link :to="'/setting'">
                                <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
                                My Account
                            </router-link>
                            <a @click="logout">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Log Out
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>
<script setup>
    import Notification from '../../components/Notification.vue'
    import FriendsRow from '../../components/FriendsRequestRow.vue'
    import { mapState } from 'vuex';
</script>
<script>
    export default {
        name: "auth",
        props: ['notifications', 'unread_notification', 'friend_requests'],
        computed: {
            ...mapState({
                getUser: 'getUser',
                isLoggedIn: 'isLoggedIn',
            }),
        },
        mounted() {
        },
        methods: {
            async logout (){
                await this.$store.dispatch('logout')
                this.$router.push('/login')
            },
            loadNotification(){
                this.$store.dispatch('loadNotification')
            }
        },
    }
</script>