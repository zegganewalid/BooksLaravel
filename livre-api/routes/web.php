<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\BookController;
use App\Http\Middleware\VerifyCsrfToken;

// Route de test pour la connexion à la base de données
Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        $database = DB::connection()->getDatabaseName();
        return "Connexion réussie à la base de données: {$database}";
    } catch (\Exception $e) {
        return "Erreur de connexion à la base de données: " . $e->getMessage();
    }
});

// Route de diagnostic direct pour les livres
Route::get('/test-books', function () {
    try {
        // Vérifie si la table existe
        if (!Schema::hasTable('books')) {
            return "La table 'books' n'existe pas. Veuillez exécuter les migrations.";
        }
        
        // Récupérer tous les livres
        $books = DB::table('books')->get();
        
        // Retourner les données
        return response()->json([
            'success' => true,
            'count' => count($books),
            'books' => $books
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});

// Routes API pour les livres avec le contrôleur
Route::prefix('api')->group(function () {
    Route::get('/books', [BookController::class, 'index'])->withoutMiddleware([VerifyCsrfToken::class]);
    Route::post('/books', [BookController::class, 'store'])->withoutMiddleware([VerifyCsrfToken::class]);
    Route::get('/books/{id}', [BookController::class, 'show'])->withoutMiddleware([VerifyCsrfToken::class]);
    Route::put('/books/{id}', [BookController::class, 'update'])->withoutMiddleware([VerifyCsrfToken::class]);
    Route::delete('/books/{id}', [BookController::class, 'destroy'])->withoutMiddleware([VerifyCsrfToken::class]);
    
    // Route de test API
    Route::get('/test', function () {
        return response()->json(['message' => 'API fonctionne correctement']);
    })->withoutMiddleware([VerifyCsrfToken::class]);
});

// Route OPTIONS pour gérer les requêtes préflight CORS
Route::options('/api/{any}', function () {
    return response('', 200)
        ->header('Access-Control-Allow-Origin', 'http://localhost:5173')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With');
})->where('any', '.*');