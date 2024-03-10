import {appectFriend, declineFriend, requestFriend, unFriend} from "../data/api";
import axios from 'axios'

const state = {

};
const mutations = {
    setEmail(state, email){
        state.email = email
    },
    setPassword(state, newPassword){
        state.password = newPassword
    },
}
// actions
const actions = {
    appectRequest({commit, dispatch}, params){
        return new Promise((resolve, reject) => {
            appectFriend(params).then(response => {
                resolve(response)
            })
        });
    },
    declineRequest({commit, dispatch}, params){
        return new Promise((resolve, reject) => {
            declineFriend(params).then(response => {
                resolve(response)
            })
        });
    },
    sendRequest({commit, dispatch}, params){
        params.type = 'send'
        return new Promise((resolve, reject) => {
            requestFriend(params).then(response => {
                if (params.index != null) {
                    dispatch('setAfterAddFriend', params.index)
                }
                resolve(response)
            })
        });
    },
    unSendRequest({commit, dispatch}, params){
        params.type = 'unsend'
        return new Promise((resolve, reject) => {
            requestFriend(params).then(response => {
                dispatch('setAfterAddFriend', params.index)
                resolve(response)
            })
        });
    },
    unFriend({commit, dispatch}, params){
        return new Promise((resolve, reject) => {
            unFriend(params).then(response => {
                // dispatch('setAfterAddFriend', params.index)
                resolve(response)
            })
        });
    }
};

const getters = {
}

export default {
    state,
    getters,
    mutations,
    actions
}