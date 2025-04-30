// URL absolue 
const API_BASE_URL = 'http://localhost:8000/api';

// Service pour gérer les livres
export const BookService = {
  // Récupérer tous les livres
  async getBooks() {
    try {
      console.log("Tentative de récupération des livres à:", `${API_BASE_URL}/books`);
      const response = await fetch(`${API_BASE_URL}/books`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        }
      });
      
      if (!response.ok) {
        throw new Error(`Erreur API: ${response.status}`);
      }
      
      // Obtenir le texte brut de la réponse pour le déboguer
      const rawText = await response.text();
      console.log("Réponse brute:", rawText);
      
      // Essayer de parser manuellement pour éviter les erreurs
      try {
        return JSON.parse(rawText);
      } catch (jsonError) {
        console.error("Erreur de parsing JSON:", jsonError);
        console.error("Contenu problématique:", rawText);
        throw new Error("La réponse du serveur n'est pas au format JSON valide");
      }
    } catch (error) {
      console.error('Erreur lors de la récupération des livres:', error);
      throw error;
    }
  },
  
  // Créer un nouveau livre
  async createBook(bookData) {
    try {
      console.log("Tentative de création de livre à:", `${API_BASE_URL}/books`);
      console.log("Données:", bookData);
      
      const response = await fetch(`${API_BASE_URL}/books`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify(bookData)
      });
      
      // Obtenir le texte brut de la réponse pour le déboguer
      const rawText = await response.text();
      console.log("Réponse brute du POST:", rawText);
      
      try {
        // Si la réponse est vide, renvoyer un objet vide
        if (!rawText.trim()) {
          return {};
        }
        const data = JSON.parse(rawText);
        return data;
      } catch (jsonError) {
        console.error("Erreur de parsing JSON (POST):", jsonError);
        console.error("Contenu problématique:", rawText);
        throw new Error("La réponse du serveur n'est pas au format JSON valide");
      }
    } catch (error) {
      console.error('Erreur lors de la création du livre:', error);
      throw error;
    }
  },
  
  // Supprimer un livre par ID
  async deleteBook(id) {
    try {
      console.log("Tentative de suppression du livre à:", `${API_BASE_URL}/books/${id}`);
      
      const response = await fetch(`${API_BASE_URL}/books/${id}`, {
        method: 'DELETE',
        headers: {
          'Accept': 'application/json'
        }
      });
      
      if (!response.ok) {
        throw new Error(`Erreur API: ${response.status}`);
      }
      
      // Analyser la réponse JSON pour le débogage
      const rawText = await response.text();
      console.log("Réponse brute du DELETE:", rawText);
      
      try {
        return rawText ? JSON.parse(rawText) : true;
      } catch (jsonError) {
        console.error("Erreur de parsing JSON (DELETE):", jsonError);
        return true; // Continuer même en cas d'erreur de parsing
      }
    } catch (error) {
      console.error(`Erreur lors de la suppression du livre ${id}:`, error);
      throw error;
    }
  },
  
  // Test de l'API
  async testApi() {
    try {
      const response = await fetch(`${API_BASE_URL}/test`);
      const rawText = await response.text();
      console.log("Réponse du test API:", rawText);
      
      try {
        return JSON.parse(rawText);
      } catch (jsonError) {
        console.error("Erreur de parsing JSON (test):", jsonError);
        throw new Error("La réponse du test n'est pas au format JSON valide");
      }
    } catch (error) {
      console.error('Erreur de test API:', error);
      throw error;
    }
  }
};