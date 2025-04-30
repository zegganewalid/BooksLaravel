<template>
  <header class="bg-blue-600 text-white py-4 shadow-md">
    <div class="container mx-auto px-4 flex items-center justify-between">
      <router-link to="/" class="text-xl font-bold">Bibliothèque</router-link>
      <nav>
        <ul class="flex space-x-6">
          <li>
            <router-link to="/" class="hover:text-blue-200 transition duration-300">Accueil</router-link>
          </li>
          <li>
            <router-link to="/books" class="hover:text-blue-200 transition duration-300">Livres</router-link>
          </li>
          <li>
            <router-link to="/books/create" class="hover:text-blue-200 transition duration-300">Ajouter</router-link>
          </li>
        </ul>
      </nav>
    </div>
  </header>

  <RouterView />

  <footer class="bg-gray-800 text-white py-4 mt-auto">
    <div class="container mx-auto px-4 text-center">
      <p>&copy; {{ new Date().getFullYear() }} - Application de Gestion de Bibliothèque</p>
    </div>
  </footer>
</template>

<script>
import { RouterView } from 'vue-router'

export default {
  components: {
    RouterView
  }
}
</script>