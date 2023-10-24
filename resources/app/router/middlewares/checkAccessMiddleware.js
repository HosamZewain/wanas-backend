import UserService from '@services/user'
import {useAuthUserStore} from "../../store/user";

const whiteList = ['/auth', '/login', '/auth-redirect', '/','/403',]; // no redirect whitelist
const noCheckAbilityList = whiteList.concat([ ':pathMatch(.*)*', '/dashboard', '/employee-login-loading']);

export function checkAccessMiddleware(to, from, next) {
    // set page title
    document.title = import.meta.env.VITE_VUE_APP_NAME;
    // determine whether the user has logged in
    const isUserLogged = UserService.isLogged();
    if (isUserLogged) {
        if (to.path === '/login') {
            // if is logged in, redirect to the home page
            next({
                path: '/dashboard'
            });

            // if logged in user is customer, proceed to customer dashboard
        } else {

            let hasAbility = useAuthUserStore().hasPermission(to.meta.action, to.meta.module)
            if (!hasAbility && !noCheckAbilityList.includes(to.path)){
                return next({
                    path: '/403'
                });
            }
            next();
        }
    } else {
        /* has no token*/
        if (whiteList.indexOf(to.matched[0] ? to.matched[0].path : '') !== -1) {
            // in the free login whitelist, go directly
            next();
        } else {
            // other pages that do not have permission to access are redirected to the login page.
            next({
                path: '/'
            });
        }
    }
}


export function dashboardRedirect(to,from,next){
    const isUserLogged = UserService.isLogged();
    if (isUserLogged){
        // if(to.path.startsWith('/customer/') &&
        //     useAuthUserStore().user.roles !== 'customer'){
        //     // console.log(1)
        //     next({name: 'forbidden'})
        // }
        // else if(!whiteList.includes(to.path) &&
        //     !to.path.startsWith('/customer/') &&
        //     useAuthUserStore().user.roles === 'customer'){
        //     // console.log(2)
        //     next({name: 'forbidden'})
        // }else{
        //     // console.log(3)
            next();
        // }
    }else{
        
        next();
    }
}
