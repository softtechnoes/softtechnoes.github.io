import Vue from 'vue';
import VueRouter from 'vue-router';
// import { store } from "./store";

// window.Vue = Vue;
// Router

// Vue.use(VueRouter);
let routes = [{
        path: '/', // all the routes which can be access without authentication
        component: require('./layouts/guest-page').default,
        meta: { validate: ['guest'] },
        children: [{
                // This is the main landing page for guest
                path: '/',
                component: require('./views/guest-pages/home').default,
            },
                      
        ],
       
    },
    {
        path: '/', // all the routes which needs authentication
        component: require('./layouts/auth-page').default,
        meta: { validate: ['auth'] },
        children: [
            {
                path: `/dashboard`,
                component: require('./views/auth-pages/dashboard').default
            },
        ]
    },
    {
        path: '*',
        component: require('./layouts/error-page').default,
        children: [{
            path: '*',
            component: require('./views/errors/page-not-found').default
        }]
    },
    {
        path: '/',
        component: require('./layouts/error-page').default,
        children: [
            // {
            //     path: '/terms-and-conditions',
            //     component: require('./views/pages/terms-and-conditions').default
            // },
            {
                path: '/maintenance',
                component: require('./views/errors/maintenance').default
            },
            
        ]
    },

];

const router = new VueRouter({
    routes,
    // linkActiveClass: 'active',
    mode: 'history',
    scrollBehavior (to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        } else {
            return { x: 0, y: 0 }
        }
    }
    });
router.beforeEach((to, from, next) => {
    // store.dispatch('currentUser/resetAuthUserDetail');// Use this line to force logout (state and local storage) en each request
    helper.check()
        .then(response => {
            
            // // Check for Maintenance mode; If maintenance mode is on, redirect to "/maintenance" route
            // if(helper.isAuth() && !helper.hasRole('admin') && helper.getConfig('maintenance_mode') && to.fullPath != '/maintenance') {
            //     return next({ path: '/maintenance' })
            // }
            const intendedPath = to.path;

            if (to.matched.some(m => m.meta.validate)) {
                const m = to.matched.find(m => m.meta.validate);

                // Check for authentication; If no, redirect to "/login" route
                if (m.meta.validate.indexOf('auth') > -1) {
                    if (!helper.isAuth()) {
                        return next({ path: '/login', query:{ redirectPath:intendedPath } }) 
                    }
                }

                // // Check for screen lock; If enabled, redirect to "/auth/lock" route after screen lock timeout
                // if (m.meta.validate.indexOf('lock_screen') > -1){
                //     if(helper.getConfig('lock_screen') && helper.isScreenLocked()){
                //         pageLoader.hide();
                //         return next({ path: '/auth/lock' })
                //     }
                // }

                // Check for authentication; If authenticated, redirect to "/home" route
                if (m.meta.validate.indexOf('guest') > -1) {
                    if (helper.isAuth()) {
                        // toastr.error(i18n.auth.guest_required);
                        // pageLoader.hide();
                        return next({ path: '/dashboard' })
                    }
                }
            }
            return next()
        })
        .catch(error => {
            // store.dispatch('currentUser/resetAuthUserDetail');
            return next({ path: '/login' });
        });
});

export default router;