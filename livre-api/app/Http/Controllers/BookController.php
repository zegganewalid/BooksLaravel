<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    /**
     * Afficher la liste des livres.
     */
    public function index(): JsonResponse
    {
        try {
            $books = Book::orderBy('created_at', 'desc')->get();
            return response()->json($books);
        } catch (\Exception $e) {
            // Log l'erreur et retourne une réponse JSON d'erreur
            \Log::error('Erreur lors de la récupération des livres: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur serveur: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Enregistrer un nouveau livre.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'release_date' => 'required|date',
            ]);

            $book = Book::create([
                'title' => $validated['title'],
                'release_date' => $validated['release_date']
            ]);

            return response()->json($book, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Afficher un livre spécifique.
     */
    public function show($id): JsonResponse
    {
        $book = Book::findOrFail($id);
        return response()->json($book);
    }

    /**
     * Mettre à jour un livre.
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'release_date' => 'required|date',
            ]);

            $book = Book::findOrFail($id);
            $book->update([
                'title' => $validated['title'],
                'release_date' => $validated['release_date']
            ]);

            return response()->json($book);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Supprimer un livre.
     */
    public function destroy($id): JsonResponse
    {
        try {
            $book = Book::findOrFail($id);
            $book->delete();
            return response()->json(['message' => 'Livre supprimé avec succès'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}