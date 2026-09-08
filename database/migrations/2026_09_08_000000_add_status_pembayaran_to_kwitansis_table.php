<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kwitansis', function (Blueprint $table) {
            $table->string('status_pembayaran', 20)->default('BELUM LUNAS')->after('harga');
        });
    }

    public function down(): void
    {
        Schema::table('kwitansis', function (Blueprint $table) {
            $table->dropColumn('status_pembayaran');
        });
    }
};
