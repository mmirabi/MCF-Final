<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumns('ec_order_product', ['additional_id', 'city_id', 'send_at', 'message_subject', 'message_text'])) {
            Schema::table('ec_order_product', function (Blueprint $table) {
                $table->string('additional_id')->after('product_id')->nullable();
                $table->bigInteger('shipping_rule_id')->after('additional_id')->nullable();
                $table->string('message_id')->after('shipping_rule_id')->nullable();
                $table->date('shipping_date')->after('message_id')->nullable();
                $table->string('shipping_time')->after('shipping_date')->nullable();
                $table->string('message_subject')->after('shipping_time')->nullable();
                $table->text('message_text')->after('message_subject')->nullable();
                $table->decimal('additional_price', 15)->after('price')->nullable();
                $table->decimal('shipping_price', 15)->after('additional_price')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::table('ec_order_product', function (Blueprint $table) {
            $table->dropColumn('additional_id');
            $table->dropColumn('message_id');
            $table->dropColumn('shipping_rule_id');
            $table->dropColumn('shipping_date');
            $table->dropColumn('shipping_time');
            $table->dropColumn('message_subject');
            $table->dropColumn('message_text');
            $table->dropColumn('shipping_price');
        });
    }
};
