import {useAuthUserStore} from "../store/user";

export default {

    methods: {
        hasRole(role){
            return useAuthUserStore().hasRole(role)
        },
        hasPermission(action, module){
            return useAuthUserStore().hasPermission(action, module)
        },
        hasAnyPermission(action, modules=[]){
            return  modules.reduce((res,module)=>res||useAuthUserStore().hasPermission(action, module),false)
        },
        hasAnyAction(actions=[], module){
            return  actions.reduce((res,action)=>res||useAuthUserStore().hasPermission(action, module),false)
        }
    }
}
