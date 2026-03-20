<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Agregar campo de PDF de ficha técnica a productos
        Schema::table('products', function (Blueprint $table) {
            $table->string('datasheet_pdf')->nullable()->after('image');
            $table->text('short_description')->nullable()->after('description');
        });

        // Tabla de imágenes de galería por producto
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('image');
            $table->string('caption')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_images');

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['datasheet_pdf', 'short_description']);
        });
    }
};
