<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('ec_order_product', function (Blueprint $table) {
            if (!Schema::hasColumn('ec_order_product', 'recipient_name'))
            $table->text('recipient_name')->after('message_text')->nullable();
            if (!Schema::hasColumn('ec_order_product', 'recipient_phone'))
            $table->text('recipient_phone')->after('recipient_name')->nullable();
            if (!Schema::hasColumn('ec_order_product', 'recipient_address'))
            $table->text('recipient_address')->after('recipient_phone')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('ec_order_product', function (Blueprint $table) {
            $table->dropColumn('recipient_name');
            $table->dropColumn('recipient_phone');
            $table->dropColumn('recipient_address');
        });
    }
};
