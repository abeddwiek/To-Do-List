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
        Schema::table('permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('group_id')->nullable()->index();
            $table->foreign('group_id')->references('id')->on('permission_groups');
         });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};