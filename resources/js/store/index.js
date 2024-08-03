import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";
import createWebSocketPlugin from "./websocketStorePlugin";
import { currentUser } from "./modules/currentUser.js";

const store = createStore({
    modules: {
        currentUser
    },
    plugins: [createPersistedState]
});

export default store;