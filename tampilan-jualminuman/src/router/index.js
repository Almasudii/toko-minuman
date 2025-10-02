import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import loginView from '@/views/loginView.vue'
import registerView from '@/views/registerView.vue'
import DashboardMinuman from '@/views/dashboardMinuman.vue'
// import DashboardKategori from '@/views/DashboardKategori.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/about',
    name: 'about',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
  },
  {
    path: '/minuman',
    component: () => import('../views/minumanView.vue')
  },
  {
    path: '/kategori',
    component: () => import('../views/kategoriView.vue')
  },
  {
    path: '/login',
    component: loginView
  },
  {
    path: '/register',
    component: registerView
  },
  { path: '/dashboard', component: DashboardMinuman },
  // { path: '/dashboard-kategori', component: DashboardKategori },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
