<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumns('ec_product_categories', ['cat_type'])) {
            Schema::table('ec_order_product', function (Blueprint $table) {
                $table->string('cat_type')->after('description')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::table('ec_product_categories', function (Blueprint $table) {
            $table->dropColumn('cat_type');
        });
    }
};
