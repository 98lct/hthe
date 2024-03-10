<template>
   <!-- sidebar -->
    <div class="sidebar">
        <div class="sidebar_inner" data-simplebar>
            <ul>
                <li class="active">
                    <router-link :to="'/'">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-blue-600">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        <span> Feed </span>
                    </router-link>
                </li>
                <!-- <li>
                    <router-link :to="{name: 'Profile', params: {id : $store.getters.getUser.user_id }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-yellow-500">
                            <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd"></path>
                        </svg>
                        <span> Profile </span>
                    </router-link>
                </li> -->
            </ul>
            <div class="footer-links" style="position: absolute; bottom: 0; left: 0">
                <a>About</a>
                <a>Blog </a>
                <a>Careers</a>
                <a>Support</a>
                <a>Contact Us </a>
                <a>Developer</a>
                <a>Terms of service</a>
            </div>
        </div>
        <!-- sidebar overly for mobile -->
        <div class="side_overly" uk-toggle="target: #wrapper ; cls: is-collapse is-active"></div>
    </div>
</template>