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
        \Illuminate\Support\Facades\DB::statement("
        ALTER TABLE `permissions` DROP INDEX `permissions_name_guard_name_unique`,
            ADD UNIQUE `permissions_name_guard_name_unique` (`name`, `guard_name`, `group_id`) USING BTREE
      ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
