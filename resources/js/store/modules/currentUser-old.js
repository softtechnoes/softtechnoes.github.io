import axios from "axios";
const state = {
    auth_user: [], //Authenticated user
    is_auth: false, // to store auth status
    config: {}, // to store all configuration variables
    permissions: [], // to store all permissions of authenticated user
    last_activity: null, // to store last activity time of user
    users_list: [], // users lists when Admin is authenticated
    breadcrumbs: [],
};
const getters = {
    getAuthStatus: (state) => {
        return state.is_auth;
    },
};
const actions = {
    login({ commit, state }, payload) {
        return new Promise((resolve, reject) => {
            axios({
                    method: 'post',
                    url: `api/auth/login`,
                    data: payload,
                })
                .then(response => {
                    if (response.status === 200) {
                        commit('SET_AUTH_STATUS',true);
                        // commit('SET_USER', response.data.user); // This is going to be done by check
                        resolve(response) // return response data to calling function
                    } else {
                        resolve(response) // return error to calling function    
                    }
                }).catch(error => {
                    // request failed
                    reject(error) // return error to calling function
                })
        })
    },
    logout({ commit, dispatch }, payload) {
        return new Promise((resolve, reject) => {
            axios({
                    method: 'post',
                    url: `api/auth/logout`,
                    data: payload,
                })
                .then(response => {
                    if(response.status === 200){
                        dispatch('resetAuthUserDetail');
                    }
                    resolve(response)
                }).catch(error => {
                    // request failed
                    dispatch('resetAuthUserDetail');
                    reject(error) // return error to calling function
                })
        })
        
    },
    setAuthUserDetail({ commit }, user){
        commit('SET_USER', user);
    },
    resetAuthUserDetail({ commit }) {
        commit('SET_AUTH_STATUS', false);
        commit('RESET_AUTH_USER')
    },
    setConfig({ state }, config) {
        for (let key of Object.keys(config)) {
            state.config[key] = config[key];
        }
    },
    setAuthStatus({ commit }, status) {
        commit('SET_AUTH_STATUS', status);
    },
    user_email_exists({ commit, state }, payload) {
        return new Promise((resolve, reject) => {
            axios({
                    method: 'post',
                    url: `api/auth/user-email-exists`,
                    data: payload,
                })
                .then(response => {
                    resolve(response)
                }).catch(error => {
                    // request failed
                    reject(error) // return error to calling function
                })
        })
    },
    sendActivationEmail({ commit, state }, payload) {
        return new Promise((resolve, reject) => {
            axios({
                    method: 'post',
                    url: `api/auth/send-activation-email`,
                    data: payload,
                })
                .then(response => {
                    resolve(response)
                }).catch(error => {
                    // request failed
                    reject(error) // return error to calling function
                })
        })
    },
    activateUser({ commit, state }, payload) {
        return new Promise((resolve, reject) => {
            axios({
                    method: 'get',
                    url: `/api/auth/user/activation/${payload}`,
                    data: payload,
                })
                .then(response => {
                    if(response.status === 200){
                        commit('SET_AUTH_STATUS',true);
                        resolve(response)
                    }
                }).catch(error => {
                    console.log(error)
                    // request failed
                    reject(error) // return error to calling function
                })
        })
    },
    register({ commit, state }, payload) {
        return new Promise((resolve, reject) => {
            axios({
                    method: 'post',
                    url: `api/auth/register`,
                    data: payload,
                })
                .then(response => {
                    if (response.status === 200) {
                        resolve(response) // return response data to calling function
                    } else {
                        resolve(response) // return error to calling function    
                    }
                }).catch(error => {
                    // request failed
                    reject(error) // return error to calling function
                })
        })
    },
    resetPasswordRequest({commit,state},payload){
        return new Promise((resolve,reject)=>{
            axios({
                method: 'post',
                url: `api/auth/reset`,
                data:payload,
            })
            .then(response =>{
                resolve(response);
            }).catch(error =>{
                reject(error)
            })
        })
    },
    changePassword({commit,state},payload){
        return new Promise((resolve,reject)=>{
            axios({
                method: 'post',
                url: `/api/auth/password`,
                data: payload,
            })
            .then(response=>{
                resolve(response);
            }).catch(error=>{
                reject(error);
            })
        })
    },
    authorizePasswordReset({commit,state}, payload){
        return new Promise((resolve,reject)=>{
            axios({
                method: 'post',
                url: `api/auth/validate-password-reset`,
                data: payload,
            })
            .then(response=>{
                resolve(response);
            }).catch(error=>{
                reject(error);
            })
        })
    }
};
const mutations = {
    SET_AUTH_STATUS(state, status) {
        state.is_auth = status;
    },
    RESET_AUTH_USER(state) {
        state.auth_user = [];
        state.last_activity = null;
        localStorage.removeItem('auth_token');
        axios.defaults.headers.common['Authorization'] = null;
    },
    SET_USER(state, data) {
        state.auth_user = data;
    },  
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}