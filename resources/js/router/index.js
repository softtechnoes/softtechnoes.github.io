import { createRouter, createWebHistory } from "vue-router";
import store from '../store';

const routes = [
    {
        path: "/",
        name: "Home",
        component: require('../layouts/default-page').default,
        // meta: { validate: ['guest'] },
        meta: {
            hideForAuth: true
        },
        children: [{
            // This is the main landing page for guest
            path: '/',
            component: require('../views/guest-pages/home').default,
        },
        {
            path: 'retro/:token',
            component: require('../views/auth/retro').default,
            props: true
        },]
    },
        
    {
        path: "/auth",
        name: "Login",
        component: require('../layouts/guest-page').default,
        meta: {
            hideForAuth: true
        },
        children: [
        {
            path: 'login',
            component: require('../views/auth/login').default
        },
        {
            path: 'register',
            component: require('../views/auth/register').default
        },
        {
            path: 'activate-user/:token',
            component: require('../views/auth/activate').default,
            props: true
        },
        
    ],
    
    },
    {
        path: '/admin', // all the routes which needs authentication
        component: require('../layouts/auth-page').default,
        // meta: { validate: ['auth'] },
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: `dashboard`,
                component: require('../views/auth-pages/dashboard').default
            },
            {
                path: `profile`,
                component: require('../views/auth-pages/Profile').default
            },
            {
                path: `settings`,
                component: require('../views/auth-pages/Settings').default
            },
        ]
    },
    // {
    //     path: '/pathMatch(.*)',
    //     component: require('../layouts/error-page').default,
    //     children: [{
    //         path: '/pathMatch(.*)',
    //         component: require('../views/errors/page-not-found').default
    //     }]
    // },
    {
        path: '/:pathMatch(.*)*',
        component: require('../layouts/error-page').default,
        children: [{
            path: '/:pathMatch(.*)*',
            component: require('../views/errors/page-not-found').default
        }]
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes
});

router.beforeEach((to, from, next) => {
    helper.check()
        .then(response => {
            console.log('response', response) 
            if (to.matched.some(record => record.meta.requiresAuth)) {
                if (!helper.isAuth()) {
                    return next({ path: '/auth/login' });
                } else {
                    return next();
                }
    
            } else {
                next();
            }

            if (to.matched.some(record => record.meta.hideForAuth)) {
                console.log('here')
                if (helper.isAuth()) {
                    console.log('auth')
                    return next({ path: '/admin/dashboard' });
                } else {
                    return next();
                }
            } else {
                // return next();
            }
        })
        .catch(err => {
            
            console.log('err', err)
            return next();
        })
    // firebase.auth().onAuthStateChanged(function(user) {
    //     if (to.matched.some(record => record.meta.requiresAuth)) {
    //         if (!user) {
    //             next({ path: '/login' });
    //         } else {
    //             next();
    //         }

    //     } else {
    //         next();
    //     }

    //     if (to.matched.some(record => record.meta.hideForAuth)) {
    //         if (user) {
    //             next({ path: '/dashboard' });
    //         } else {
    //             next();
    //         }
    //     } else {
    //         next();
    //     }
    // });
});


// router.beforeEach((to, from, next) => {
//     // store.dispatch('currentUser/resetAuthUserDetail');// Use this line to force logout (state and local storage) en each request
//     helper.check()
//         .then(response => {
            
//             // // Check for Maintenance mode; If maintenance mode is on, redirect to "/maintenance" route
//             // if(helper.isAuth() && !helper.hasRole('admin') && helper.getConfig('maintenance_mode') && to.fullPath != '/maintenance') {
//             //     return next({ path: '/maintenance' })
//             // }
//             const intendedPath = to.path;

//             if (to.matched.some(m => m.meta.validate)) {
//                 console.log('validated');
//                 const m = to.matched.find(m => m.meta.validate);

//                 // Check for authentication; If no, redirect to "/login" route
//                 if (m.meta.validate.indexOf('auth') > -1) {
//                     if (!helper.isAuth()) {
//                         return next({ path: '/login', query:{ redirectPath:intendedPath } }) 
//                     }
//                 }

//                 // // Check for screen lock; If enabled, redirect to "/auth/lock" route after screen lock timeout
//                 // if (m.meta.validate.indexOf('lock_screen') > -1){
//                 //     if(helper.getConfig('lock_screen') && helper.isScreenLocked()){
//                 //         pageLoader.hide();
//                 //         return next({ path: '/auth/lock' })
//                 //     }
//                 // }

//                 // Check for authentication; If authenticated, redirect to "/home" route
//                 if (m.meta.validate.indexOf('guest') > -1) {
//                     if (helper.isAuth()) {
//                         // toastr.error(i18n.auth.guest_required);
//                         // pageLoader.hide();
//                         return next({ path: '/dashboard' })
//                     }
//                 }
//             }
//             return next()
//         })
//         .catch(error => {
//             store.dispatch('currentUser/resetAuthUserDetail');
//             console.log('fdsfsdfsdf')
//             // return next();
//             return next({ path: '/login' });
//         });
// });


export default router;