<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si c'est une requête OPTIONS (preflight), retourner directement une réponse
        if ($request->isMethod('OPTIONS')) {
            $response = response('', 200);
        } else {
            // Sinon, traiter la requête normalement
            $response = $next($request);
        }
        
        // Ajouter les en-têtes CORS à toutes les réponses
        $response->header('Access-Control-Allow-Origin', 'http://localhost:5173');
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With');
        
        return $response;
    }
}