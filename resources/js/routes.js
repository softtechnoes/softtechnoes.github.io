import { createRouter, createMemoryHistory } from 'vue-router';
import  store  from "./store";

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
            {
                path: '/connexion',
                component: require('./views/auth/login').default
            },
            {
                path: '/inscription',
                component: require('./views/auth/register').default
            },
            {
                path: '/activer-utilisateur/:token',
                component: require('./views/auth/activate').default,
                props: true
            },
            {
                path: `/comment-ca-fonctionne`,
                component: require('./views/guest-pages/howItWorks').default
            },
            {
                path: `/mot-de-passe-oublie`,
                component: require('./views/auth/reset').default
            },
            {
                path: '/changer-mot-de-passe',
                name: 'password-change',
                component: require('./views/auth/password').default
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
            // {
            //     path: '/blank',
            //     component: require('./views/pages/blank').default
            // },
        ]
    },
    // {
    //     path: '*',
    //     component: require('./layouts/error-page').default,
    //     children: [{
    //         path: '*',
    //         component: require('./views/errors/page-not-found').default
    //     }]
    // },
    {
        path: "/erreur/:code",
        component: require('./views/errors/page-not-found').default,
        props: true 
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

const router = createRouter({
    history: createMemoryHistory,
    routes: routes,
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
                        return next({ path: '/connexion', query:{ redirectPath:intendedPath } }) 
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
                        return next({ path: '/tableau-de-bord' })
                    }
                }
            }
            return next()
        })
        .catch(error => {
            store.dispatch('currentUser/resetAuthUserDetail');
            return next({ path: '/connexion' });
        });
});

export default router;