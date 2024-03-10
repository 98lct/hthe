import {fetchLogin, fetchSignUp} from "../data/api";
import router from '../router';

const state = {
    isLoggedIn: false,
    password: '',
    email: '',
    first_name: '',
    last_name: '',
    gender: 0,
    errors: [],
    mode: 'signUp'
};
const mutations = {
    setError(state, newErrors) {
        state.errors = newErrors;
    },
}
// actions
const actions = {
    setEmail({state}, newEmail) {
        state.email = newEmail;
    },
    setPassword({state}, newPassword) {
        state.password = newPassword;
    },
    setFirstname({state}, newFirstname) {
        state.first_name = newFirstname;
    },
    setLastname({state}, newLastname) {
        state.last_name = newLastname;
    },
    setGender({state}, newGender) {
        state.gender = newGender;
    },
    signUp({commit, dispatch}) {
        return new Promise((resolve, reject) => {
            fetchSignUp().then(response => {
                resolve(response)
                if (response.status == 201) {
                    router.push('/login')
                } else {
                    commit('setError', response.data.message)
                }
            }).catch((err) => {
                console.log(err)
            })
        })
    }
};

export default {
    state,
    mutations,
    actions
}