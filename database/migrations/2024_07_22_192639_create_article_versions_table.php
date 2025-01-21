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

        if (!Schema::hasTable('article_versions')) {
            Schema::create('article_versions', function (Blueprint $table) {
                $table->id();
                $table->longText('content');
                $table->unsignedBigInteger('uid')->nullable(); // use unsignedBigInteger for foreign keys
                $table->foreign('uid')
                    ->references('id')
                    ->on('users') // Ensure the table name is correct
                    ->onDelete('set null'); // Set to null if the referenced user is deleted
                $table->unsignedBigInteger('article_id'); // use unsignedBigInteger for foreign keys
                $table->foreign('article_id')
                    ->references('id')
                    ->on('articles')
                    ->onDelete('cascade'); // Cascade delete if the referenced article is deleted
                $table->boolean('is_approved')->default(false);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_versions');
    }
};
