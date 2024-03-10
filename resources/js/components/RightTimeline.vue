<template>
    <div class="lg:w-72 w-full hidden-kg-down">

        <!-- <a href="#birthdays" uk-toggle>
            <div class="bg-white mb-5 px-4 py-3 rounded-md shadow">
                <h3 class="text-line-through font-semibold mb-1"> Birthdays </h3>
                <div class="-mx-2 duration-300 flex hover:bg-gray-50 px-2 py-2 rounded-md">
                    <img src="/assets/images/icons/gift-icon.png" class="w-9 h-9 mr-3" alt="">
                    <p class="line-clamp-2 leading-6"> <strong> Jessica Erica </strong> and <strong> two others </strong>
                        have a birthdays to day .
                    </p>
                </div>
            </div>
        </a> -->

        <h3 class="text-xl font-semibold"> Contacts </h3>

        <div class=" " uk-sticky="offset:80">

            <!-- <nav class="responsive-nav border-b extanded mb-2 -mt-2">
                <ul uk-switcher="connect: #group-details; animation: uk-animation-fade">
                    <li class="uk-active"><a class="active" href="#0"> Friends <span> 310 </span> </a></li>
                    <li><a href="#0">Groups</a></li>
                </ul>
            </nav> -->
            <div class="mb-5 -mt-3">

            </div>
            <div class="contact-list mt-5">
                <template v-for="friend in friends">
                    <a href="#">
                        <div class="contact-avatar">
                            <img :src="'/uploads/users/'+ friend.user.profile_img" alt="">
                            <span :class="((friend.user.is_online != 1) ? 'user_status status_online' : 'user_status')"></span>
                        </div>
                        <div class="contact-username"> {{ friend.user.full_name }}</div>
                    </a>
                    <div uk-drop="pos: left-center ;animation: uk-animation-slide-left-small">
                        <div class="contact-list-box">
                            <div class="contact-avatar">
                                <img :src="'/uploads/users/'+ friend.user.profile_img" alt="">
                                <span :class="((friend.user.is_online != 1) ? 'user_status status_online' : 'user_status')"></span>
                            </div>
                            <div class="contact-username"> {{ friend.user.full_name }}</div>
                            <p v-if="friend.user.live_at">
                                <ion-icon name="home-outline" class="text-md mr-1"></ion-icon>
                                <span>Live at: {{ friend.user.live_at }}</span>
                            </p>
                            <p v-else-if="friend.user.learn_at">
                                <ion-icon name="home-outline" class="text-md mr-1"></ion-icon>
                                <span>Learn at: {{ friend.user.learn_at }}</span>
                            </p>
                            <!-- <div class="contact-list-box-btns center"> -->
                                <!-- <button type="button" class="button primary flex-1 block mr-2">
                                    <i class="uil-envelope mr-1"></i> Send message</button> -->
                                <button type="button" href="#" class="button secondary button-icon mr-2 my-1">
                                   Profile 
                                </button>
                                <!-- <button type="button" a href="#" class="button secondary button-icon">
                                    <i class="uil-ellipsis-h"> </i> 
                                </button>-->
                            <!-- </div> -->
                        </div>
                    </div>
                </template>
                
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['friends'],
    data: () => {
        return {
            
        }
    },
    computed: {
        isLoggedIn: function () {
            return this.$store.getters.isLoggedIn
        }
    },
    created() {
        if (this.isLoggedIn) {
            this.$store.dispatch('getUser');
        } 
    },
}
</script>