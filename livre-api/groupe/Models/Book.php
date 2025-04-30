<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont mass assignable.
     */
    protected $fillable = [
        'title',
        'release_date',
    ];

    /**
     * Les attributs qui doivent être convertis.
     */
    protected $casts = [
        'release_date' => 'date',
    ];
    
    /**
     * Convertir le modèle en un tableau.
     * Nous surchargeons cette méthode pour nous assurer qu'elle génère un JSON valide.
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'release_date' => $this->release_date ? $this->release_date->format('Y-m-d') : null,
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('Y-m-d H:i:s') : null,
        ];
    }
}