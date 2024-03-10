<template>

    <div id="wrapper" class="flex flex-col justify-between h-screen register-page">
        <!-- header-->
        <div class="bg-white py-4 shadow dark:bg-gray-800">
            <div class="max-w-6xl mx-auto">
                <div class="flex items-center lg:justify-between justify-around">
                    <a href="trending.html">
                        <img :src="'/assets/images/logo.png'" alt="" class="w-32">
                    </a>
                    <div class="capitalize flex font-semibold hidden lg:block my-2 space-x-3 text-center text-sm">
                        <router-link to="/login" class="py-3 px-4">Login</router-link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content-->
        <div>
            <div class="lg:p-12 max-w-xl lg:my-0 my-12 mx-auto p-6 space-y-">
                <form class="lg:p-10 p-6 space-y-3 relative bg-white shadow-xl rounded-md" method="POST" @submit.prevent="signUp">
                    <h1 class="lg:text-2xl text-xl font-semibold mb-6"> Register </h1>
                    <div class="grid lg:grid-cols-2 gap-3">
                        <div>
                            <label class="mb-0"> First Name </label>
                            <input required type="text" v-model="first_name" placeholder="Your Name" class="bg-gray-100 h-12 my-2 px-3 rounded-md w-full">
                            <label v-if="typeof errors['first_name'] !== 'undefined'" class="text-danger">
                                {{ errors['first_name'][0] }}
                            </label>
                        </div>
                        <div>
                            <label class="mb-0"> Last  Name </label>
                            <input required type="text" v-model="last_name" placeholder="Last  Name" class="bg-gray-100 h-12 my-2 px-3 rounded-md w-full">
                            <label v-if="typeof errors['last_name'] !== 'undefined'" class="text-danger">
                                {{ errors['last_name'][0] }}
                            </label>
                        </div>
                    </div>
                    <!-- <div>
                        <label class="mb-0"> Username </label>
                        <input required type="text" placeholder="Username" class="bg-gray-100 h-12 my-2 px-3 rounded-md w-full">
                    </div> -->
                    <div>
                        <label class="mb-0"> Email Address </label>
                        <input required type="email" v-model="email" placeholder="Info@example.com" class="bg-gray-100 h-12 my-2 px-3 rounded-md w-full">
                        <label v-if="typeof errors['email'] !== 'undefined'" class="text-danger">
                            {{ errors['email'][0] }}
                        </label>
                    </div>
                    <div>
                        <label class="mb-0"> Password </label>
                        <input required type="password" v-model="password" placeholder="******" class="bg-gray-100 h-12 my-2 px-3 rounded-md w-full">
                        <label v-if="typeof errors['password'] !== 'undefined'" class="text-danger">
                            {{ errors['password'][0] }}
                        </label>
                    </div>
                    <div class="grid lg:grid-cols-2 gap-3">
                        <div>
                            <label class="mb-0"> Gender </label>
                            <select v-model="gender" class="selectpicker my-2 rounded-md">
                                <option selected value="0">Male</option>
                                <option value="1">Female</option>
                            </select>

                        </div>
                        <!-- <div>
                            <label class="mb-0"> Phone: optional  </label>
                            <input required type="text" placeholder="+543 5445 0543" class="bg-gray-100 h-12 my-2 px-3 rounded-md w-full">
                        </div> -->
                    </div>

                    <div class="checkbox">
                        <input required type="checkbox" id="chekcbox1" checked="">
                        <label for="chekcbox1"><span class="checkbox-icon"></span> I agree to the <a href="#" target="_blank" class="uk-text-bold uk-text-small uk-link-reset"> Terms and Conditions </a>
                        </label>
                    </div>
                    <div>
                        <button required type="submit" class="bg-blue-600 font-semibold p-2 mt-5 rounded-md text-center text-white w-full">
                            Get Started</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer -->

        <div class="lg:mb-5 py-3 uk-link-reset">
            <div class="flex flex-col items-center justify-between lg:flex-row max-w-6xl mx-auto lg:space-y-0 space-y-3">
                <div class="flex space-x-2 text-gray-700 uppercase">
                    <a href="#"> About</a>
                    <a href="#"> Help</a>
                    <a href="#"> Terms</a>
                    <a href="#"> Privacy</a>
                </div>
                <p class="capitalize"> © copyright 2020 by Socialite</p>
            </div>
        </div>

    </div>
</template>
<script>
    import {mapActions, mapMutations, mapState} from "vuex";
    import router from '../router';
    export default {
        name: "signup",
        methods: {
            ...mapMutations({
                setEmail: 'setEmail',
                setPassword: 'setPassword',
                setFirstname: 'setFirstname',
                setLastname: 'setLastname',
                setGender: 'setGender',
                setError: 'setError'
            }),
            ...mapActions({
                signUp: 'signUp'
            }),
        },
        mounted() {
        },
        computed: {
            email:{
                get: function(){
                    return this.$store.state.signup.email
                },
                set: function(newEmail){
                    return this.$store.dispatch('setEmail', newEmail);
                }
            },
            password:{
                get: function(){
                    return this.$store.state.signup.password
                },
                set: function(newPassword){
                    return this.$store.dispatch('setPassword', newPassword);
                }
            },
            first_name:{
                get: function(){
                    return this.$store.state.signup.first_name
                },
                set: function(newFirstname){
                    return this.$store.dispatch('setFirstname', newFirstname);
                }
            },
            last_name:{
                get: function(){
                    return this.$store.state.signup.last_name
                },
                set: function(newLastname){
                    return this.$store.dispatch('setLastname', newLastname);
                }
            },
            gender:{
                get: function(){
                    return this.$store.state.signup.gender
                },
                set: function(newGender){
                    return this.$store.dispatch('setGender', newGender);
                }
            },
            errors: {
                get: function(){
                    return this.$store.state.signup.errors
                },
            }
        }
    }
</script>
<style scope>
.register-page input , .bootstrap-select.btn-group button{
    background-color: #f3f4f6  !important;
    height: 44px  !important;
    box-shadow: none  !important;
}
.register-page select.selectpicker {
    display: unset !important;
}
.register-page input:-webkit-autofill {
    -webkit-box-shadow: unset !important;
    -webkit-text-fill-color: unset !important;
}

.text-danger{
    color: red;
}
</style>