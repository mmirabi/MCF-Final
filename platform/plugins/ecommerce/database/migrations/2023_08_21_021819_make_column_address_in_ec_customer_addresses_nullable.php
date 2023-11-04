<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    public function up(): void
    {
        Schema::table('ec_customer_addresses', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->change();
            $table->string('address', 255)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('ec_customer_addresses', function (Blueprint $table) {
            $table->string('phone', 20)->change();
            $table->string('address', 255)->change();
        });
    }
};
