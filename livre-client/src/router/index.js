import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import BookFormView from '../views/BookFormView.vue'
import BookListView from '../views/BookListView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/books/create',
      name: 'book-create',
      component: BookFormView
    },
    {
      path: '/books',
      name: 'book-list',
      component: BookListView
    }
  ]
})

export default router