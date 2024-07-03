import { createPersistedState } from "pinia-plugin-persistedstate";
import { defineStore } from "pinia";


export const useUserStore = defineStore('userStore', {
    state: () => ({
        user: null,
    }),
    actions: {
        getAuth(user) {

        },
        removeUser(id) {
            this.user = null;
        },
        storeUserData(userData) {
            this.user = userData;
        },
    },
    persist: true,
})
