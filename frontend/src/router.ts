import Vue from 'vue'
import Router from 'vue-router'
import BaseLayout from './containers/BaseLayout'

Vue.use(Router)

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'BaseLayout',
      component: BaseLayout,
      children: [
        {
          path: '',
          name: 'Home',
          component: () => import(/* webpackChunkName: "Home" */'./views/Home.vue')
        },
        {
          path: '/about',
          name: 'about',
          component: () => import(/* webpackChunkName: "about" */ './views/About.vue')
        }
      ]
    },
    {
      path: '/login',
      name: 'login',
      component: () => import(/* webpackChunkName: "login" */ './views/Login')
    },
    {
      path: '/register',
      name: 'register',
      component: () => import(/* webpackChunkName: "register" */'./views/Register')
    }
  ]
})
