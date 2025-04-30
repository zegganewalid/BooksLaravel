<template>
    <div class="min-h-screen bg-gray-100">
      <div class="container mx-auto px-4 py-12">
        <div class="flex items-center justify-between mb-8">
          <h1 class="text-3xl font-bold text-gray-800">Liste des Livres</h1>
          <div class="flex space-x-4">
            <router-link 
              to="/books/create" 
              class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-300"
            >
              Ajouter un livre
            </router-link>
            <router-link 
              to="/" 
              class="text-blue-600 hover:text-blue-800 font-medium"
            >
              Retour à l'accueil
            </router-link>
          </div>
        </div>
        
        <div v-if="loading" class="flex justify-center items-center py-12">
          <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
        </div>
        
        <div v-else-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
          <p>{{ error }}</p>
        </div>
        
        <div v-else-if="books.length === 0" class="bg-gray-100 p-8 rounded text-center">
          <p class="text-gray-700 text-lg">Aucun livre n'a été ajouté pour le moment.</p>
          <router-link 
            to="/books/create" 
            class="text-blue-600 hover:text-blue-800 font-medium mt-4 inline-block"
          >
            Ajouter votre premier livre
          </router-link>
        </div>
        
        <div v-else class="bg-white shadow-md rounded-lg overflow-hidden">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Titre
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Date de sortie
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="book in books" :key="book.id">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">{{ book.title }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-500">{{ formatDate(book.release_date) }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <button 
                    @click="deleteBook(book.id)" 
                    class="text-red-600 hover:text-red-900 focus:outline-none"
                    :disabled="deleteInProgress"
                  >
                    Supprimer
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { BookService } from '@/services/api';
  
  export default {
    data() {
      return {
        books: [],
        loading: true,
        error: null,
        deleteInProgress: false
      };
    },
    created() {
      this.fetchBooks();
    },
    methods: {
      async fetchBooks() {
        this.loading = true;
        this.error = null;
        
        try {
          this.books = await BookService.getBooks();
        } catch (error) {
          this.error = 'Erreur lors du chargement des livres. Veuillez réessayer.';
          console.error(error);
        } finally {
          this.loading = false;
        }
      },
      formatDate(dateString) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(dateString).toLocaleDateString('fr-FR', options);
      },
      async deleteBook(id) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer ce livre ?')) {
          return;
        }
        
        this.deleteInProgress = true;
        
        try {
          await BookService.deleteBook(id);
          // Retirer le livre de la liste locale
          this.books = this.books.filter(book => book.id !== id);
        } catch (error) {
          alert('Erreur lors de la suppression du livre. Veuillez réessayer.');
          console.error(error);
        } finally {
          this.deleteInProgress = false;
        }
      }
    }
  };
  </script>