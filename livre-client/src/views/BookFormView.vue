<template>
    <div class="min-h-screen bg-gray-100">
      <div class="container mx-auto px-4 py-12">
        <div class="flex items-center justify-between mb-8">
          <h1 class="text-3xl font-bold text-gray-800">Ajouter un Livre</h1>
          <router-link 
            to="/" 
            class="text-blue-600 hover:text-blue-800 font-medium"
          >
            Retour à l'accueil
          </router-link>
        </div>
        
        <div class="bg-white shadow-md rounded-lg p-6">
          <div v-if="errors.length > 0" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <p class="font-bold">Veuillez corriger les erreurs suivantes :</p>
            <ul class="list-disc ml-5">
              <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
            </ul>
          </div>
          
          <div v-if="success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <p>Le livre a été ajouté avec succès !</p>
          </div>
          
          <form @submit.prevent="submitForm">
            <div class="mb-4">
              <label for="title" class="block text-gray-700 font-semibold mb-2">Titre du livre</label>
              <input
                type="text"
                id="title"
                v-model="form.title"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Entrez le titre du livre"
                required
              >
            </div>
            
            <div class="mb-6">
              <label for="release_date" class="block text-gray-700 font-semibold mb-2">Date de sortie</label>
              <input
                type="date"
                id="release_date"
                v-model="form.release_date"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
              >
            </div>
            
            <div class="flex items-center justify-between">
              <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                :disabled="isSubmitting"
              >
                {{ isSubmitting ? 'En cours...' : 'Ajouter le livre' }}
              </button>
              
              <router-link 
                to="/books" 
                class="text-blue-600 hover:text-blue-800 font-medium"
              >
                Voir tous les livres
              </router-link>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { BookService } from '@/services/api';
  
  export default {
    data() {
      return {
        form: {
          title: '',
          release_date: ''
        },
        errors: [],
        success: false,
        isSubmitting: false
      };
    },
    methods: {
      async submitForm() {
        this.errors = [];
        this.success = false;
        this.isSubmitting = true;
        
        // Validation simple
        if (!this.form.title.trim()) {
          this.errors.push('Le titre du livre est requis');
        }
        
        if (!this.form.release_date) {
          this.errors.push('La date de sortie est requise');
        }
        
        if (this.errors.length > 0) {
          this.isSubmitting = false;
          return;
        }
        
        try {
          await BookService.createBook(this.form);
          
          // Réinitialisation du formulaire
          this.form.title = '';
          this.form.release_date = '';
          this.success = true;
          
          // Redirection vers la liste après 2 secondes
          setTimeout(() => {
            this.$router.push('/books');
          }, 2000);
        } catch (error) {
          if (error.errors) {
            // Erreurs de validation Laravel
            Object.values(error.errors).forEach(errorMessages => {
              errorMessages.forEach(message => this.errors.push(message));
            });
          } else {
            this.errors.push('Une erreur est survenue lors de l\'ajout du livre');
          }
        } finally {
          this.isSubmitting = false;
        }
      }
    }
  };
  </script>