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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->string("role")->comment("assistant, user");
            $table->text("message");
            $table->unsignedBigInteger("chat_group_id");
            $table->timestamps();
        });

        Schema::table('chats', function (Blueprint $table) {
            $table->foreign(["chat_group_id"], "chats_fk_1")->references("id")->on("chat_groups")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->dropForeign("chats_fk_1");
        });
        Schema::dropIfExists('chats');
    }
};
