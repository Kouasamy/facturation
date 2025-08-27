<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactureArticle extends Model
{
    use HasFactory;

    protected $table = 'facture_articles';

    protected $fillable = [
        'facture_id',
        'description',
        'quantite',
        'prix_unitaire',
        'taux_tva',
        'montant_ht',
        'montant_tva',
        'montant_ttc',
    ];

    protected $casts = [
        'quantite' => 'integer',
        'prix_unitaire' => 'decimal:2',
        'taux_tva' => 'decimal:2',
        'montant_ht' => 'decimal:2',
        'montant_tva' => 'decimal:2',
        'montant_ttc' => 'decimal:2',
    ];

    public function facture()
    {
        return $this->belongsTo(Facture::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($article) {
            $article->montant_ht = $article->quantite * $article->prix_unitaire;
            $article->montant_tva = $article->montant_ht * ($article->taux_tva / 100);
            $article->montant_ttc = $article->montant_ht + $article->montant_tva;
        });
    }
}
