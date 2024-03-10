import Vuex from "vuex"
import auth from './auth';
import signup from './register';
import newfeed from './newfeed';
import notification from './notification';
import friend from './friend';
import chat from './chat';

import {getToken} from './../data/api.js'

import { ElLoading } from 'element-plus';

const store = new Vuex.Store({
    namespaced: true,
    modules: {
        auth,
        signup,
        newfeed,
        notification,
        friend,
        chat
    },
    state: {
        state: {
            loading: null, // Initial loading state
        },
    },
    actions: {
        startLoading({ commit }) {
            const loadingInstance = ElLoading.service({
                lock: true,
                background: 'rgba(0, 0, 0, 0.7)',
            });
            commit('setLoading', loadingInstance);
        },
        stopLoading({ state }) {
            if (state.loading) {
              state.loading.close();
            }
          },
    },
    mutations: {
        setLoading(state, payload) {
            state.loading = payload;
        },
    },
    getters: {
        // Shared getters
        mediaPath: () => `uploads/media/`,
        startLoading: state => state.loading,
        stopLoading: state => state.loading,
        // mediaPath: () => `https://hthe.site/uploads/media/`
    }
})


export default store