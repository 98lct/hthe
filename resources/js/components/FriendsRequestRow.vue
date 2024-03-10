<template>
    <ul>
        <li v-for="(request,index) in friend_requests">
            <router-link :to="{name: 'Profile', params: {id: request.user_id}}">
                <div class="drop_avatar">
                    <img :src="'/uploads/users/' + request.profile_img" alt="" >
                </div>
                <div class="drop_text">
                    <p>{{ request.full_name }} <time style="display: inline"> {{ moment.unix(request.created_at).startOf('minute').fromNow()
                    }} </time></p>
                    <button @click="appect(request.user_id, index)" type="button" class="inline-flex border-2 ml-1 bg-blue-500 text-white px-2 rounded">Appect</button>
                    <button @click="decline(request.user_id, index)" type="button" class="inline-flex border-2 ml-1 bg-gray-200 px-2 rounded">Delete</button>
                </div>
            </router-link>
        </li>
    </ul>
</template>
<script setup>
import moment from 'moment';
</script>
<script>
export default {
    props: ['friend_requests'],
    data: () => {
        return {

        }
    },
    mounted(){
    },
    methods: {
        appect(requested_by, index) {
            this.$store.dispatch('appectRequest', {requested_by: requested_by}).then(response => {
                this.friend_requests.splice(index, 1);
                this.$toast.default(response.data.message, { position: 'top', duration: 1000 });
            })
        },
        decline(requested_by, index) {
            this.$store.dispatch('declineRequest', {requested_by: requested_by}).then(response => {
                this.friend_requests.splice(index, 1);
                this.$toast.default(response.data.message, { position: 'top', duration: 1000 });
            })
        }
    }
}
</script>