<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs');
            $table->string('no_batch');
            $table->integer('jumlah');
            $table->date('tanggal_expired');
            $table->timestamps();
            
            // Composite unique index to prevent duplicate batch entries
            $table->unique(['barang_id', 'no_batch']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};