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

        if (!Schema::hasTable('comments')) {
            Schema::create('comments', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('content');
                $table->unsignedBigInteger('uid')->nullable();
                $table->foreign('uid')->references('id')->on('users')->onDelete('cascade');
                $table->unsignedBigInteger('article_id');
                $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
