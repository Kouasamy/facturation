<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $table = 'factures';

    protected $fillable = [
        'client_id',
        'numero_facture',
        'date_emission',
        'date_echeance',
        'montant_ht',
        'montant_tva',
        'montant_ttc',
        'statut',
        'notes',
    ];

    protected $casts = [
        'date_emission' => 'date',
        'date_echeance' => 'date',
        'montant_ht' => 'decimal:2',
        'montant_tva' => 'decimal:2',
        'montant_ttc' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    // Statuts possibles
    const STATUT_BROUILLON = 'brouillon';
    const STATUT_ENVOYEE = 'envoyee';
    const STATUT_PAYEE = 'payee';
    const STATUT_EN_RETARD = 'en_retard';

    // Relations
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function articles()
    {
        return $this->hasMany(FactureArticle::class);
    }

    /**
     * Calcul les totaux de la facture à partir des articles et met à jour la facture.
     */
    public function calculerTotaux()
    {
        $totalHt  = $this->articles->sum('montant_ht');
        $totalTva = $this->articles->sum('montant_tva');
        $totalTtc = $this->articles->sum('montant_ttc');

        $this->update([
            'montant_ht'  => $totalHt,
            'montant_tva' => $totalTva,
            'montant_ttc' => $totalTtc,
        ]);

        return $this;
    }

    /**
     * Génère un numéro de facture unique par année.
     */
    public function genererNumeroFacture(): string
    {
        $year = date('Y');
        $lastInvoice = self::whereYear('created_at', $year)->latest()->first();

        $newNumber = '0001';
        if ($lastInvoice) {
            $lastNumber = (int) substr($lastInvoice->numero_facture, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        }

        return 'FA' . $year . '-' . $newNumber;
    }
}
