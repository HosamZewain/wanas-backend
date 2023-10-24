import BaseApi from "./base.api";
import Http from "@services/http"

export default class AuthApi extends BaseApi {

    static get entity() {
        return ''
    }

    static async csrf() {
        return await Http.get('sanctum/csrf-cookie')
    }

    static async login(credentials) {
        return await Http.post('login', credentials)
    }

    static async logout() {
        return await Http.post('logout')
    }

    static async resetPassword(resetData) {
        return await Http.post('reset-password', resetData)
    }

    static async checkSocialLogin() {
        return await Http.get('check-social-login')
    }
}
