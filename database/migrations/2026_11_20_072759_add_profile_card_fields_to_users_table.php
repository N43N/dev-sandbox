<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('title', 60)->nullable()->after('name');
        $table->string('bio', 160)->nullable()->after('title');
        $table->string('url')->nullable()->after('bio');
        $table->string('avatar')->nullable()->after('url');
    });
}


    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['title', 'bio', 'url', 'avatar']);
        });
    }
};
