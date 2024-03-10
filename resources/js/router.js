import { createRouter, createWebHistory, useRoute } from 'vue-router'
import store from './store/index'


import Master from './layouts/App.vue'
import Timeline from './views/Timeline.vue'
import Profile from './views/Profile.vue'
import Page from './views/Page.vue'
import Login from './views/Login.vue'
import Register from './views/Register.vue'
import Message from './views/Message.vue'
import DetailPost from './components/DetailPost.vue'
import Setting from './components/Setting.vue'

function guard(to, from, next) {
    if (store.getters.isLoggedIn === true) {
        // or however you store your logged in state
        next(); // allow to enter route
    } else {
        next('/login'); // go to '/login';
    }
}

const routes = [
    {
        name: 'home',
        path: '/',
        component: Master,
        redirect: '/timeline',
        meta: {
            requiresAuth: true,
        },
        beforeEnter: guard,
        children: [
            {
                name: 'Timeline',
                path: 'timeline',
                component: Timeline,
                meta: {
                    requireAuth: true,
                },
                beforeEnter: guard
            },
            {
                name: 'Detail',
                path: '/post/:id',
                component: DetailPost,
                meta: {
                    requireAuth: true,
                },
                beforeEnter: guard
            },
            {
                name: 'Profile',
                path: '/u/:id',
                component: Profile,
                meta: {
                    requireAuth: true,
                },
                beforeEnter: guard
            },
            {
                name: 'Page',
                path: '/p/:id',
                component: Page,
                meta: {
                    requireAuth: true,
                },
                beforeEnter: guard
            },
            {
                name: 'Setting',
                path: '/setting',
                component: Setting,
                meta: {
                    requireAuth: true,
                },
                beforeEnter: guard
            },
            {
                path: '/message',
                name: 'Message',
                component: Message,
                meta: {
                },
            },
        ]
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
        meta: {
            requireGuest: true,
        },
    },
    {
        path: '/register',
        name: 'Register',
        component: Register,
        meta: {
            requireGuest: true,
        },
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes
})

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requireAuth)) {
        const loggedIn = localStorage.getItem('token');
        if (store.getters.isLoggedIn) {
            next();
            return;
        }
        next("/login");
    } else {
        next();
    }
});
router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requireGuest)) {
        if (store.getters.isLoggedIn) {
            next("/timeline");
            return;
        }
        next();
    } else {
        next();
    }
});

axios.interceptors.response.use(undefined, function (error) {
    if (error.response.status === 401 || error.response.status === 500) {
        store.dispatch('logout')
        router.push('/login')
    }
}, (error) => {
    if (error.response && error.response.data) {
        return Promise.reject(error.response.data);
    }
    return Promise.reject(error.message);
})

export default router