import {loadChatFriend} from "../data/api";
import axios from 'axios'

const state = {
    messages: [],
};
const mutations = {
    setMessages(state, messages){
        state.messages = messages
    },
    addMessage(state, message){
        state.messages.push(message)
    },

}
// actions
const actions = {
    // load chat by user id
    loadChat({commit}, id){
        return new Promise((resolve, reject) => {
            loadChatFriend(id).then(response => {
                commit('setMessages', response.data.messages)
                resolve(response)

            })
            .catch(error => {
                reject(error)
            })
        })
    },
    sendChat({commit}, param){
        return new Promise((resolve, reject) => {
            axios.post(`/api/chat/${param.id}/send`, {
                message: param.content
            })
            .then(response => {
                //commit('addMessage', response.data.message)
                resolve(response)
            })
            .catch(error => {
                reject(error)
            })
        })
    }
};

const getters = {
    messages: state => state.messages,
    messageById: (state) => (id) => {
        return state.messages.find(message => message.id === id)
    },

}

export default {
    state,
    getters,
    mutations,
    actions
}