import {
    readAll,
    listNotification
} from "../data/api";
import router from '../router';

const state = {

};
const mutations = {
}
// actions
const actions = {
    readAllNotification({commit, dispatch}, userID){
        readAll({
            source_id: userID
        }).then(response => {
            commit('set_notifications', response.data.notifications)
            dispatch('countNotification', {})
        });
    },
    loadNotification({commit, dispatch}) {
        listNotification({

        }).then(response => {
            commit('set_notifications', response.data.notifications)
            // dispatch('countNotification', {})
        });
    }
};

export default {
    state,
    mutations,
    actions
}