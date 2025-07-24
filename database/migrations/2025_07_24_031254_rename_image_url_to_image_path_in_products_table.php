<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Mengubah nama kolom dari 'image_url' menjadi 'image_path'
            $table->renameColumn('image_url', 'image_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Mengembalikan nama kolom ke 'image_url' jika migrasi di-rollback
            $table->renameColumn('image_path', 'image_url');
        });
    }
};
