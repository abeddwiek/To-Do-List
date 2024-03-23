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
        Schema::create('to_dos', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->text('description')->nullable();
            $table->text('note')->nullable();
            $table->date('date')->nullable();
            $table->tinyInteger('is_completed')->default(0)->comment('0 not completed 1 completed');

            $table->unsignedBigInteger('creator_id')->nullable()->index();
            $table->foreign('creator_id')->references('id')->on('users');


            $table->unsignedBigInteger('assigned_user_id')->nullable()->index();
            $table->foreign('assigned_user_id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('to_dos');
    }
};
