import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        remoteFiles: [],
    },
    mutations: {
        SET_REMOTE_FILES: function (state, files)  {
            state.remoteFiles = files;
        }
    },
    actions: {
        tryLogin: function({},data) {
            return axios.post('auth/login', data);
        },
        loadRemoteFiles: function({commit}) {
            return axios.get('remote-files/').then(function (responce) {
                commit('SET_REMOTE_FILES',responce.data);
            });
        },

    },
    getters: {
        remoteFiles: state => (state.remoteFiles),
    }
});