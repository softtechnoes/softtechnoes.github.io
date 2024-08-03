import { createWebHistory, createRouter } from "vue-router";


const routes = [
  {
    path: "/",
    component: require('./layouts/guest-page').default,
    meta: { validate: ['guest'] },
  },
  {
    path: '/login',
    component: require('./views/auth/login').default
},
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;