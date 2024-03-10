import {fetchLogin, fetchSignUp, fetchUser, removeToken, getTokenExpires} from "../data/api";
import axios from 'axios'

const state = {
    token: localStorage.getItem('token') || '',//(getToken() != null & typeof getToken() != undefined) ? true : false,
    pending: false,
    password: '',
    email: '',
    status: '',
    user: {},
    friends:[],
    friend_requests:[],
    friend_suggests: [],
    notifications: [],
    count_unread_notification: '',
    isLoggedIn: false,
    feeling_list: [],
    activity_list: [],
    location_list: []
};
const mutations = {
    setEmail(state, email){
        state.email = email
    },
    setPassword(state, newPassword){
        state.password = newPassword
    },
    auth_request(state){
        state.status = 'loading'
    },
    logout(state){
        state.status = ''
        state.token = ''
        state.isLoggedIn = false
    },
    set_user(state, user){
        state.user = user
    },
    set_friends(state, friends){
        state.friends = friends
    },
    set_notifications(state, notifications){
        state.notifications = notifications
    },
    set_friend_requests(state, friend_requests){
        state.friend_requests = friend_requests
    },
    set_friend_suggests(state, friend_suggests){
        state.friend_suggests = friend_suggests
    },
    set_count_notifications(state, notifications){
        state.count_unread_notification = notifications
    },
    set_record_friend_suggests(state, index){
        // if (typeof state.friend_suggests[index]['is_request'] != 'undefined')
            state.friend_suggests[index]['is_request'] = ! state.friend_suggests[index]['is_request']
        // else
        // state.friend_suggests[index]['is_request'] = true;
    },
    set_notifications(state, notifications){
        state.notifications = notifications
    },
    auth_success(state, token){
        state.status = 'success'
        state.token = token
        state.isLoggedIn = true
    },
    set_feeling_list(state, feeling) {
        state.feeling_list = feeling
    },
    set_activity_list(state, activity) {
        state.activity_list = activity
    },
    set_location_list(state, location) {
        state.location_list = location
    }
}
// actions
const actions = {
    login({commit, dispatch}) {
        return new Promise((resolve, reject) => {
            commit('auth_request')
            fetchLogin().then((response) => {
                if (response.data.status == 200) {
                    const token = 'Bearer ' + response.data.access_token
                    const user = response.data.user
                    localStorage.setItem('token', token)
                    axios.defaults.headers.common['Authorization'] = token
                    commit('auth_success', token)
                    commit('set_user', user)
                    commit('set_friends', response.data.friends)
                    commit('set_notifications', response.data.notifications)
                    commit('set_friend_requests', response.data.friend_requests)
                    commit('set_friend_suggests', response.data.friend_sussegts)
                    commit('set_feeling_list', response.data.feeling_list.feeling)
                    commit('set_activity_list', response.data.feeling_list.activity)
                    commit('set_location_list', response.data.location_list)
                    dispatch('countNotification', {})
                    resolve(response)
                }
            }).catch(error => {
                localStorage.removeItem('token')
                reject(error)
            })
        })
    },
    logout({commit}){
        return new Promise((resolve, reject) => {
          commit('logout')
          localStorage.removeItem('token')
          delete axios.defaults.headers.common['Authorization']
          resolve()
        })
    },
    getUser({commit, dispatch}){
        return new Promise((resolve, reject) => {
            fetchUser().then(response => {
                commit('set_user', response.data.user)
                commit('set_friends', response.data.friends)
                commit('set_notifications', response.data.notifications)
                commit('set_friend_requests', response.data.friend_requests)
                commit('set_friend_suggests', response.data.friend_suggests)
                commit('set_feeling_list', response.data.feeling_list.feeling)
                commit('set_activity_list', response.data.feeling_list.activity)
                commit('set_location_list', response.data.location_list)
                dispatch('countNotification', {})
            })
        });
    },
    setAfterAddFriend({commit}, index){
        commit('set_record_friend_suggests', index)
    },
    countNotification({commit}, count = 0){
        if (count == 0){
            let count_unread = state.notifications.filter(n => {
                return n.is_read == 0
            })
            commit('set_count_notifications', count_unread.length)
        } else {
            commit('set_count_notifications', count)
        }
       
    },
    loadNewNotification({commit, dispatch}, notification){
        commit('set_notifications', notification)
        dispatch('countNotification', {})
    },
};

const getters = {
    isLoggedIn: state => !!state.token,
    authStatus: state => state.status,
    getUser: state => state.user,
    getFriends: state => state.friends,
    getNotifications: state => state.notifications,
    getUnreadNotifications: state => state.count_unread_notification,
    getFriendRequests: state => state.friend_requests,
    getFriendSuggests: state => state.friend_suggests,
    activity: state => state.activity_list,
    feeling: state => state.feeling_list,
    location: state => state.location_list,
    

}

export default {
    state,
    getters,
    mutations,
    actions
}