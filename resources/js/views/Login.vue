<template>
<div class="lg:flex max-w-5xl min-h-screen mx-auto p-6 py-10">
    <div class="flex flex-col items-center lg: lg:flex-row lg:space-x-10">
        <div class="lg:mb-12 flex-1 lg:text-left text-center">
            <img :src="'/assets/images/logo.png'" alt="" class="lg:mx-0 lg:w-52 mx-auto w-40">
            <p class="font-medium lg:mx-0 md:text-2xl mt-6 mx-auto sm:w-3/4 text-xl"> Connect with friends and the world around you on Socialite.</p>
        </div>
        <div class="lg:mt-0 lg:w-96 md:w-1/2 sm:w-2/3 mt-10 w-full">
            <form class="p-6 space-y-4 relative bg-white shadow-lg rounded-lg" method="POST" @submit.prevent="login">
                <input type="email" placeholder="Info@example.com" v-model="email" class="with-border" required>
                <input placeholder="******" type="password" required v-model="password" class="with-border">
                <div class="error-box my-2" v-show="showError">
                    <p v-if="typeof errors['password'] != 'undefined'" class="text-danger">{{ errors['password'][0] }}</p>
                </div>
                <button type="submit" class="bg-blue-600 font-semibold p-3 rounded-md text-center text-white w-full">
                    Log In
                </button>
                <a href="#" class="text-blue-500 text-center block"> Forgot Password? </a>
                <hr class="pb-3.5">
                <div class="flex">
                    <router-link to="/register" class="bg-green-600 hover:bg-green-500 hover:text-white font-semibold py-3 px-5 rounded-md text-center text-white mx-auto">Create New Account</router-link>
                </div>
            </form>
            <div class="mt-8 text-center text-sm"> <a href="#" class="font-semibold hover:underline"> Create a Page </a> for a celebrity, band or business </div>
        </div>

    </div>
</div>
</template>

<style scoped>
.text-danger {
    color: red;
}

.input-error {
    border: 1px solid red
}
</style>

<script>
import {
    mapActions,
    mapMutations,
    mapState
} from "vuex";
export default {
    name: "login",
    data() {
        return {
            email: 'hthesimple@gmail.com',
            password: '123456',
            showError: false,
            errors: []
        }
    },
    created() {},
    methods: {
        login() {
            this.showError = false;
            this.errors = []
            this.setAuthState(this.email, this.password);
            this.$store.dispatch('login')
                .then((response) => {
                    if (response.data.status == 200) {
                        this.$router.push('/timeline')
                    } else {
                        this.showError = true
                        this.errors = response.data.message
                    }
                })
                .catch((err) => {
                    console.log(err)
                })
        },
        setAuthState(email, password) {
            this.$store.commit('setEmail', email)
            this.$store.commit('setPassword', password)
        },
    },
    mounted() {

    },
}
</script>
