<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('author');
            $table->string('publisher');
            $table->unsignedSmallInteger('publication_year');
            $table->string('isbn')->unique();
            $table->text('description')->nullable();
            $table->string('cover_path')->nullable();
            $table->string('pdf_path')->nullable();
            $table->string('epub_path')->nullable();
            $table->unsignedInteger('stock')->default(0);
            $table->string('status')->default('draft');
            $table->timestamps();

            $table->index(['title', 'author', 'publisher']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
