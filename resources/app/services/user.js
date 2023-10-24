import Storage from '@services/storage'
import {useAuthUserStore} from "@/store/user"

const USER_KEY = 'app_entity';

export default class User {

    static isLogged() {
        const store = useAuthUserStore()
        return !!store.user.id
    }

    static saveToStorage(user) {
        return Storage.set(USER_KEY, user, {}, true);
    }

    static getFromStorage() {
        return Storage.get(USER_KEY, {}, true, true);
    }

    static removeFromStorage() {
        return Storage.remove(USER_KEY);
    }
}
