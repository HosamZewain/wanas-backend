import _ from 'lodash';
export default {
    methods : {
        _get(ob, path){
            return _.get(ob, path);
        }
    }
}
