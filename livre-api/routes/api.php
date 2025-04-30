<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Book;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Ces routes sont chargées par RouteServiceProvider dans le groupe 'api'.
| Elles ont automatiquement le préfixe 'api'.
|
*/

// Obtenir tous les livres
Route::get('/books', function () {
    $books = Book::orderBy('created_at', 'desc')->get();
    return response()->json($books);
});

// Créer un nouveau livre
Route::post('/books', function (Request $request) {
    try {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'release_date' => 'required|date',
        ]);

        $book = Book::create([
            'title' => $validated['title'],
            'release_date' => $validated['release_date']
        ]);

        // Retourner une réponse JSON propre
        return response()->json($book, 201);
    } catch (\Exception $e) {
        // Capturer toute exception et retourner une erreur propre
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

// Supprimer un livre
Route::delete('/books/{id}', function ($id) {
    $book = Book::findOrFail($id);
    $book->delete();
    return response()->json(['message' => 'Livre supprimé avec succès'], 200);
});

// Route de test pour l'API
Route::get('/test', function () {
    return response()->json(['message' => 'API fonctionne correctement']);
});