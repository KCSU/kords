<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('oauth_providers', function (Blueprint $table) {
            $table->dropColumn(['access_token', 'refresh_token']);
        });
    }

    public function down(): void
    {
        Schema::table('oauth_providers', function (Blueprint $table) {
            $table->string('access_token')->nullable();
            $table->string('refresh_token')->nullable();
        });
    }
};
