import { defineStore } from "pinia";
import AuthApi from "@api/auth.api";
import UserApi from "@api/user.api";
import { forEach } from "lodash";

export const useAuthUserStore = defineStore("authUser", {
    // convert to a function
    state() {
        return {
            user: {},
            id: "",
            token: "",
            name: "",
            avatar: "",
            roles: [],
            permissions: [],
            title: {},
            fcm_tokens: [],
        };
    },
    getters: {
        getUserData(state) {
            return state.user;
        },
    },
    actions: {
        async login(userInfo) {
            const { email, password } = userInfo;
            await AuthApi.csrf();
            return await AuthApi.login({
                email: email.trim(),
                password: password,
            }).then((response) => {
                this.setUserData(response.data.data);
                return response;
            });
        },

        async resetPassword({}, resetData) {
            const { email } = resetData;
            return await AuthApi.resetPassword({
                email: email.trim(),
            }).then((response) => {
                // console.log('reset password done...');
                return response;
            });
        },

        setUserData(data) {
            this.user = data;
            this.permissions = data.permissions;
            this.roles = data.roles_ids;
            this.fcm_tokens = data.fcm_tokens;
        },

        // user logout
        logout() {
            return new Promise((resolve, reject) => {
                try {
                    AuthApi.logout()
                        .then((response) => {
                            this.resetUser();
                            resolve(response);
                        })
                        .catch((error) => {
                            reject(error);
                        });
                } catch (error) {
                    reject(error);
                }
            });
        },

        // remove token
        resetUser() {
            this.user = {};
            this.permissions = [];
        },

        hasPermission(action, module) {
            let check = false;
            if (this.permissions.length <= 0) {
                return check;
            }
            const modulePermissions = this.user.permissions.filter(
                (permission) => permission.module === module
            );
            forEach(modulePermissions, function (ob) {
                if (ob.action === action) {
                    check = true;
                    return true;
                }
            });

            return check;
        },

        hasRole(role) {
            return this.user.roles && this.user.roles.includes(role);
        },

        async checkSocialLogin() {
            return await AuthApi.checkSocialLogin().then((response) => {
                this.setUserData(response.data.data);
                return response;
            });
        },

        updateToken(token) {
            UserApi.updateToken(this.user, {fcm_token: token})
                .then(r =>{
                    this.fcm_tokens.push(token);
                });
        }
    },
    persist: true,
});
