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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('primary_email')->nullable();
            $table->bigInteger('number_of_users')->nullable();
            $table->boolean('lock')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
        $data = ['extensya'];

        foreach($data as $name) {
            $tenant = new \App\Models\Tenant();
            $tenant->name = $name;
            $tenant->primary_email = 'superadmin@admin.net';
            $tenant->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
