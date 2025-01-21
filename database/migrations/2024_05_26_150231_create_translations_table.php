<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {

        if (!Schema::hasTable('translations')) {
            Schema::create('translations', function (Blueprint $table) {
                $table->id();
                $table->string('short_word')->unique();
                $table->string('translation');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('translations');
    }
};
