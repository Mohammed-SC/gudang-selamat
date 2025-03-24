<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('satuan_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('satuan');
            $table->timestamps();
            $table->softDeletes(); // Add soft deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            // Drop foreign key
            $table->dropForeign(['satuan_id']);

            // Rename column back and change type
            $table->renameColumn('satuan_id', 'satuan_barang');
            $table->string('satuan_barang')->change();
        });

        Schema::dropIfExists('satuan_barangs');
    }
};
