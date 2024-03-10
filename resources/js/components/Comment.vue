<script setup>
import moment from 'moment';
</script>
<template>
    <div v-if="comments.length != 0" class="space-y-4 dark:border-gray-600" style=" max-height: 30vh;
    overflow-y: auto;">
        <div v-for="(comment, index) in comments">
            <div class="flex">
                <div @click="gotoProfile(comment.user.user_id)" class="w-10 h-10 rounded-full relative flex-shrink-0 pointer">
                    <img :src="'/uploads/users/' + comment.user.profile_img" alt=""
                        class="absolute h-full rounded-full w-full">
                </div>
                <div>
                    <div
                        class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12  dark:bg-gray-800 dark:text-gray-100">
                        <p class="leading-6">
                            <strong @click="gotoProfile(comment.user.user_id)" class="pointer">{{ comment.user.full_name }}</strong> <br/>
                            {{ comment.body }}
                        </p>
                        <div
                            class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800">
                        </div>
                    </div>
                    <div class="text-sm flex items-center space-x-3 mt-2 ml-5">
                        <a href="#" class="text-red-600"> <i class="uil-heart"></i> Love </a>
                        <!-- <a href="#"> Replay </a> -->
                        <span :title="moment.unix(comment.created_at).format('DD/MM/YYYY HH:mm')" class="text-xs">{{ moment.unix(comment.created_at).startOf('minute').fromNow() }} </span>
                        <a v-if="comment.user_id == $store.state.auth.user.user_id || (typeof comment.post != undefined && $store.state.auth.user.user_id == comment.post.user_id)" class="pointer" @click="removeComment(comment.id, index)"><ion-icon name="trash-outline"></ion-icon></a>
                    </div>
                </div>
            </div>
            <div class="reply-box py-4 ml-12" v-if="comment.replies != undefined && comment.replies.length != 0">
                <div class="flex" v-for="reply in comment.replies">
                    <div class="w-10 h-10 rounded-full relative flex-shrink-0">
                        <img :src="'/uploads/users/' + reply.user.profile_img" alt=""
                            class="absolute h-full rounded-full w-full">
                    </div>
                    <div>
                        <div
                            class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12  dark:bg-gray-800 dark:text-gray-100">
                            <p class="leading-6">
                                <strong class="pointer">{{ reply.user.full_name }}</strong> <br>
                                {{ reply.body }}
                            </p>
                            <div
                                class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800">
                            </div>
                        </div>
                        <div class="text-sm flex items-center space-x-3 mt-2 ml-5">
                            <!-- <a href="#" class="text-red-600"> <i class="uil-heart"></i> Love </a> -->
                            <a href="#"><ion-icon name="trash-outline"></ion-icon></a>
                            <!-- <a href="#"> Replay </a> -->
                            <span :title="moment.unix(reply.created_at).format('DD/MM/YYYY HH:mm')"> add {{ moment.unix(reply.created_at).startOf('minute').fromNow() }} </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['comments', 'postable_id' ,'post_key', 'owner'],
    data: () => {
        return {
            readmore: false,
        }
    },
    created(){
    },
    computed() {
    },
    mounted(){
    },
    methods: {
        removeComment(commentID, index){
            this.$confirm({
                title: 'Are you sure delete this comment?',
                // message: 'Are you sure delete this comment?',
                button: {
                    yes: 'Yes',
                    no: 'Cancel'
                },
                callback: confirm => {
                    if (confirm) {
                        this.$store.dispatch('removeComment', {
                            'id': commentID,
                        }).then(response => {
                            this.comments.splice(index, 1);
                        })
                    }
                }
            })
            
        },
        loadComment(){
        },
        gotoProfile(user_id){
           this.$router.push({name: 'Profile', params: {id: user_id}});
        }
    }
}
</script>