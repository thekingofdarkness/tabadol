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

        if (!Schema::hasTable('blog_categories')) {
            Schema::create('blog_categories', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('division_id'); // use unsignedBigInteger for foreign key
                $table->foreign('division_id')
                    ->references('id')
                    ->on('blog_divisions')
                    ->onDelete('cascade'); // Cascade delete if the referenced blog_division is deleted
                $table->string('title');
                $table->text('description');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_categories');
    }
};
