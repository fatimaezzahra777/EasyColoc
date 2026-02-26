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
        Schema::table('colocations', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->foreignId('owner_id')->constrained('users')->after('name')->onDelete('cascade');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('owner_id');
        });
    }

    public function down(): void
    {
        Schema::table('colocations', function (Blueprint $table) {
            $table->dropColumn(['name', 'owner_id', 'status']);
        });
    }
};
