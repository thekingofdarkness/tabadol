<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveReceiverIdFromMessagesTable extends Migration
{
    public function up()
    {

        if (!Schema::hasTable('messages')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->dropForeign(['receiver_id']);
                $table->dropColumn('receiver_id');
            });
        }
    }

    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
        });
    }
}
