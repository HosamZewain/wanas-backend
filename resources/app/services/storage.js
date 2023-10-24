import Cookies from 'js-cookie'
import {
    Base64
} from 'js-base64'

export default class Storage {
    static get(key, attributes = {}, jsonParse = false, base64Decode = false) {
        let item = Cookies.get(key, attributes);

        if (item === 'undefined' || item === null) {
            return false;
        }

        try {
            if (base64Decode) {
                item = Base64.decode(item);
            }

            if (jsonParse) {
                item = JSON.parse(item);
            }
        } catch (e) {
            item = false;
        }

        return item;
    }

    static set(key, value, attributes = {}, base64Encode = false) {
        if (typeof value === "object") {
            value = JSON.stringify(value);
        }

        if (base64Encode) {
            value = Base64.encode(value);
        }

        Cookies.set(key, value, attributes);
    }

    static remove(key, attributes = {}) {
        Cookies.remove(key, attributes);
    }

    static clean(attributes = {}) {
        Object.keys(Cookies.get()).forEach(function (cookie) {
            Cookies.remove(cookie, attributes);
        });
    }
}
