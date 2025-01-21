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

        if (!Schema::hasTable('articles')) {
            Schema::create('articles', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('uid')->nullable(); // use unsignedBigInteger for the foreign key
                $table->foreign('uid') // define the foreign key constraint
                    ->references('id')
                    ->on('users')
                    ->onDelete('set null'); // when the referenced user is deleted, set the foreign key to null
                $table->string('title');
                $table->string('slug')->unique();
                $table->string('thumbnail');
                $table->longText('content');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
