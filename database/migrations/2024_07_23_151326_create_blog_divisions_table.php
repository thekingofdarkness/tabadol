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

        if (!Schema::hasTable('blog_divisions')) {
            Schema::create('blog_divisions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('blog_id'); // use unsignedBigInteger for foreign key
                $table->foreign('blog_id')
                    ->references('id')
                    ->on('blogs')
                    ->onDelete('cascade'); // Cascade delete if the referenced blog is deleted
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
        Schema::dropIfExists('blog_divisions');
    }
};
