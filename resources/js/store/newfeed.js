import {
    getNewfeeds, destroyPost, disabledComment,
    reactPost, showPost, loadComment, showUsersReact, saveComment,
    removeComment, changeStatus, sharedPost, uploadPost
} from "../data/api";
import router from '../router';

const state = {
    newfeeds: [],
    detail: null,
    reacts: [],
};
const mutations = {
    ['getNewFeed'](state, newfeeds) {
        state.newfeeds = newfeeds;
    },
    set_newfeeds(state, newfeeds){
        state.newfeeds = newfeeds
    },
    set_newfeeds_key_field(state, object){
        state.newfeeds[object.index][object.field] = object.value
    },
}
// actions
const actions = {
    addNewfeeds({state}, newNewfeeds) {
        (state.newfeeds).unshift(newNewfeeds);
    },
    setReactList({state}, newReactList) {
        state.reacts = newReactList;
    },
    setNewfeed({state}, newNewfeed) {
        state.detail = [newNewfeed];
    },
    setValueNewFeed({state}, newNewfeedKey, newDeatil) {
        state.newfeeds[newNewfeedKey] =  newDeatil
    },
    setContentNewFeed({state}, object) {
        state.newfeeds[object.newNewfeedKey]['content'] =  object.content
    },
    loadNewfeeds({commit}, user_id){
        getNewfeeds(user_id).then(response => {
            commit('set_newfeeds', response.data.newfeeds);
        });
    },
    disabledComment({dispatch}, post_id){
        disabledComment(post_id).then(response => {
        });
    },
    removePost({dispatch}, object){
        destroyPost(object.post_id).then(response => {
            if(object.redirect == true) router.push('/timeline')
        });
    },
    likedPost({dispatch}, object){
        return new Promise((resolve, reject) => {
            reactPost(object.post_id).then(response => {
                if(object.keyNewFeed != null) {
                    if(object.route != 'Detail'){
                        this.state.newfeed.newfeeds[object.keyNewFeed] = response.data.detail
                    } else {
                        this.state.newfeed.detail[object.keyNewFeed] = response.data.detail
                    }
                    dispatch('setReactList', response.data.detail.reacts);
                }
            });
        })
    },
    loadComment({commit}, object){
        return new Promise((resolve, reject) => {
            loadComment(object.post_id).then(response => {
                if(object.keyNewFeed != null) {
                    commit('set_newfeeds_key_field', {index: object.keyNewFeed, field: 'comments', value:response.data.comments})
                    // this.state.newfeed.newfeeds[object.keyNewFeed]['comments'] = response.data.comments
                }
            })
        })
    },
    detailPost({dispatch}, post_id){
        showPost(post_id).then(response => {
            dispatch('setNewfeed', response.data.newfeed);
        });
    },
    listUserReactPost({dispatch}, post_id){
        showUsersReact(post_id).then(response => {
            dispatch('setReactList', response.data.reacts);
        })
    },
    addComment({dispatch}, object){
        return new Promise((resolve, reject) => {
            saveComment(object.post_id, object).then(response => {
                if(object.route != 'Detail') {
                    this.state.newfeed.newfeeds[object.post_key]['comments'] = response.data.comments
                } else {
                    this.state.newfeed.detail[0]['comments'] = response.data.comments
                }
                resolve()
            })
        })
    },
    removeComment({dispatch}, object){
        return new Promise((resolve, reject) => {
            removeComment(object.id).then(response => {
                resolve()
            })
        })
    },
    changeStatusPost({dispatch}, object){
        return new Promise((resolve, reject) => {
            changeStatus(object.post_id, {
                'post_id' : object.post_id,
                'status' : object.status
            }).then(response => {
                if(object.route != 'Detail') {
                    this.state.newfeed.newfeeds[object.index] = response.data.newfeed
                } else {
                    this.state.newfeed.detail[0] = response.data.newfeed
                }
                resolve()
            })
        })
    },
    sharedPost({dispatch}, object){
        return new Promise((resolve, reject) => {
            sharedPost(object.post_id, object).then(response => {
                if(object.route != 'Detail') {
                    this.dispatch('addNewfeeds', response.data.newfeed)
                } else {
                    //this.state.newfeed.detail[0] = response.data.newfeed
                }
                resolve()
            })
        })
    },
    uploadPost({dispatch}, object){
        this.dispatch('startLoading');
        return new Promise((resolve, reject) => {
            uploadPost(object).then(response => {
                if (response.data.status == 200) {
                    if (object.action == 'Create') {
                        setTimeout(() => {
                            this.dispatch('addNewfeeds', response.data.newfeed)
                            this.dispatch('stopLoading');
                        }, 350);
                    }
                    else {
                        setTimeout(() => {
                            this.state.newfeed.newfeeds[object.key] = response.data.newfeed
                            this.dispatch('stopLoading');
                        }, 350);
                    }
                    resolve()
                }
            })
        })
    }
};
const getters = {
    getNewFeed: state => state.newfeeds,
    getDetail: state => state.detail,
    getReacts: state => state.reacts
}
export default {
    state,
    mutations,
    getters,
    actions
}