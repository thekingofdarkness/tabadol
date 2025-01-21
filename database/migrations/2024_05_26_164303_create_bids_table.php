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

        if (!Schema::hasTable('bids')) {
            Schema::create('bids', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('offer_id');
                $table->unsignedBigInteger('bidder_id');
                $table->unsignedBigInteger('receiver_id');
                $table->text('note')->nullable();
                $table->string('status')->default('pending');
                $table->timestamps();

                // Foreign key constraints
                $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
                $table->foreign('bidder_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bids');
    }
};
