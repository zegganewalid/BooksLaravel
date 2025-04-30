<template>
    <div class="min-h-screen bg-gray-100">
      <div class="container mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Gestion de Bibliothèque</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300">
            <h2 class="text-xl font-semibold text-blue-600 mb-4">Ajouter un Livre</h2>
            <p class="text-gray-600 mb-6">Créez une nouvelle entrée dans votre bibliothèque en spécifiant le titre et la date de sortie.</p>
            <router-link 
              to="/books/create" 
              class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-300"
            >
              Créer un livre
            </router-link>
          </div>
          
          <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300">
            <h2 class="text-xl font-semibold text-green-600 mb-4">Consulter la Bibliothèque</h2>
            <p class="text-gray-600 mb-6">Accédez à la liste complète des livres de votre bibliothèque.</p>
            <router-link 
              to="/books" 
              class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition duration-300"
            >
              Voir les livres
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </template>