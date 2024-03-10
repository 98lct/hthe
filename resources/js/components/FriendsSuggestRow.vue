<template>
    <div v-for="friend,index in friend_suggests" class="flex items-center space-x-4 rounded-md -mx-2 p-2 hover:bg-gray-50">
        <router-link :to="{name: 'Profile', params: {id: friend.user_id}, replace: false}"
            class="w-12 h-12 flex-shrink-0 overflow-hidden rounded-full relative">
            <img :src="'/uploads/users/' + friend.profile_img" class="absolute w-full h-full inset-0 "
                alt="">
        </router-link>
        <div class="flex-1">
            <router-link :to="{name: 'Profile', params: {id: friend.user_id}, replace: false}" class="text-base font-semibold capitalize"> {{ friend.full_name }}
            </router-link>
            <!-- <div class="text-sm text-gray-500 mt-0.5"> {{ friend.friends.length }} Friends</div> -->
        </div>
        <p v-if="(typeof friend.is_request == 'undefined') || friend.is_request == false" @click="send(friend.user_id, index)"
            class="pointer flex items-center justify-center h-8 px-3 rounded-md text-sm border font-semibold bg-blue-500 text-white">
            Add friends
        </p>
        <p v-else @click="unsend(friend.user_id, index)"
            class="pointer flex items-center justify-center h-8 px-3 rounded-md text-sm border font-semibold bg-blue-500 text-white">
            unsend
        </p>

    </div>
</template>
<script setup>
</script>
<script>
import { useRouter } from 'vue-router';

export default {
    props: ['friend_suggests'],
    data: () => {
        return {

        }
    },
    mounted(){
    },
    methods: {
        send(requested_by, index) {
            this.$store.dispatch('sendRequest', {requested_by: requested_by, index: index}).then(response => {
                this.$toast.default(response.data.message, { position: 'top', duration: 1000 });
            })
        },
        unsend(requested_by, index) {
            this.$store.dispatch('unSendRequest', {requested_by: requested_by, index: index}).then(response => {
                this.$toast.default(response.data.message, { position: 'top', duration: 1000 });
            })
        }
    }
}
</script>