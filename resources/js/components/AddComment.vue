<template>
    <div class="bg-gray-100 rounded-full relative dark:bg-gray-800 border-t">
        <input v-model="body" @keyup.enter="addComment" placeholder="Add your Comment.." class="bg-transparent max-h-10 shadow-none px-5">
        <div class="-m-0.5 absolute bottom-0 flex items-center right-3 text-xl">
            <!-- <a href="#">
                <ion-icon name="happy-outline"
                class="hover:bg-gray-200 p-1.5 rounded-full"></ion-icon>
            </a>
            <a href="#">
                <ion-icon name="image-outline"
                class="hover:bg-gray-200 p-1.5 rounded-full"></ion-icon>
            </a>
            <a href="#">
                <ion-icon name="link-outline"
                class="hover:bg-gray-200 p-1.5 rounded-full"></ion-icon>
            </a> -->
            <a @click="addComment">
                <ion-icon class="hover:bg-gray-200 p-1.5 rounded-full" name="send-outline"></ion-icon>
            </a>
        </div>
    </div>
</template>
<script>
export default {
    props: ['postable_type', 'postable_id', 'post_key', 'post_id'],
    data: () => {
        return {
           body: ''
        }
    },
    // computed: {}
    created(){
        // console.log('postable_type', this.postable_type)
        // console.log('postable_id', this.postable_id)
    },
    methods: {
        addComment(){
            new Promise((resolve, reject) => {
                this.$store.dispatch('addComment', {
                    'post_key': this.post_key,
                    'post_id': this.post_id,
                    'postable_type' : 'App\\Models\\Post',
                    'route' :  this.$route.name,
                    'body': this.body
                }).then(response => {
                    this.body = ''
                    // this.$store.dispatch('loadComment', {
                    //     post_id: this.post_id,
                    //     keyNewFeed: this.post_key
                    // })
                })
            })
        }
    }
}

</script>