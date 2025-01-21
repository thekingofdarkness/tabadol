<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        if (!Schema::hasTable('offers')) {
            Schema::create('offers', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('uid');
                $table->string('current_cadre');
                $table->string('current_aref');
                $table->string('current_dir');
                $table->string('current_commune');
                $table->string('current_institution');
                $table->string('required_aref');
                $table->string('required_dir');
                $table->string('required_commune');
                $table->string('required_institution');
                $table->text('note')->nullable();
                $table->string('status');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
