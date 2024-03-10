<script setup>
    import Header from './part/header.vue'
    import Sidebar from './part/sidebar.vue'
    import Aside from './part/aside.vue'
</script>
<template>
    <Header :notifications="$store.getters.getNotifications" :unread_notification="$store.getters.getUnreadNotifications" :friend_requests="friend_requests" />
    <Sidebar />
    <!-- Main Contents -->
    <router-view></router-view>
    <Aside />
    <vue3-confirm-dialog></vue3-confirm-dialog>
</template>

<style scope>
.timeline-content>div {
    word-wrap: break-word;
}

.timeline-content .short-content {
    max-height: 70px;
    overflow: hidden;
    text-overflow: ellipsis
}
.detail-post .short-content{
    max-height: unset;
}

.full-content {
    height: auto;
}

.timeline-content div.readmore {
    cursor: pointer;
}

.timeline .full-content {
    height: auto;
}

.pointer {
    cursor: pointer;
}

a {
    cursor: pointer;
}

.liked {
    color: dodgerblue;
    transition: color .05s ease;
}
.height-transition-enter-active, .height-transition-leave-active {
    transition: height 0.5s ease;
}
.height-transition-enter, .height-transition-leave-to /* .height-transition-leave-active trong Vue 2.1.8 trở về trước */ {
    height: 0;
    opacity: 0;
}
.disabled {
    cursor: not-allowed;
    opacity: .7;
    color: white !important;
}

a.createpost {
    color: white !important;
}
.modal {
    transition: all .4s;
    position: fixed;
    z-index: 9999;
    left: 50%;
    width: 300px;
    max-width: 90%;
    top: 50%;
    height: 50vh;
    transform: translate(-50%, -50%);
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 3px 3px #ccc;
    background: white;
}
.modal.change-status{
    max-height: 24vh;
}
.modal.share-status{
    max-height: 38vh;
}
.modal.change-status .modal-body {
    padding: .25rem .5rem 0rem .5rem;
    height: 100%;
}
.modal div.btn-close {
    position: absolute;
    right: 0px;
    top: 5px;
    width: 40px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.modal .modal-content {
    padding: 1rem;
}
.modal .modal-title {
    padding: .25rem;
    display: flex;
    align-items: center;
    z-index: 999;
    height: 40px;
    border-bottom: 1px solid #ccc;
}
.modal .modal-body {
    padding: .5rem 1rem 0rem 1rem;
    height: 43vh;
    overflow-y: auto;
}
.liked-user-row{
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    margin-left: 1rem;
}
.liked-user-row > span {
    font-size: 1.5rem;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    border: .5px solid;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.post-feeling, .post-activity, .post-shared{
    display: inline-block;
    font-weight: 400;
    vertical-align: top;
    color: #6699CC;
    font-style: italic;
}
.post-shared{
    font-weight: 500;
}
.box-shared-post.is-delete{
    padding: .5rem 1rem;
    display: flex;
    cursor: default;
}
.box-shared-post.is-delete p{
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: .15rem
}
.box-shared-post.is-delete .icon{
    align-self: center;
    margin-right: 10px;
    font-weight: 700;
}
.box-shared-post.is-delete .icon ion-icon{
    font-weight: 700;
    font-size: 2rem
}
header.header-top {
    z-index: 9999;
}
.modal-body textarea{
    height: unset;
    min-height: unset;
}
.el-dialog__body {
    padding: .5rem 1rem !important;
}
textarea {
    min-height: 85px !important;
}
</style>
<script>
export default {
    name: "App",
    data() {
        return {
        }
    },
    computed: {
        isLoggedIn: function () {
            return this.$store.getters.isLoggedIn
        },
        notifications: function () {
            return this.$store.getters.getNotifications
        },
        unread_notification: function () {
            return this.$store.getters.getUnreadNotifications
        },
        friend_requests: function () {
            return this.$store.getters.getFriendRequests
        }
    },
    created() {
        if (this.isLoggedIn) {
            this.$store.dispatch('getUser');
        }
    },
    methods: {
    }
}
</script>