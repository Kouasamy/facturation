<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->string('numero_facture')->unique();
            $table->date('date_emission');
            $table->date('date_echeance');
            $table->decimal('montant_ht', 10, 2)->default(0);
            $table->decimal('montant_tva', 10, 2)->default(0);
            $table->decimal('montant_ttc', 10, 2)->default(0);
            $table->string('statut')->default('brouillon');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['client_id', 'statut']);
            $table->index('numero_facture');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
