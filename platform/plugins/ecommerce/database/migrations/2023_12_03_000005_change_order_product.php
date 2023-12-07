<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('ec_order_product', function (Blueprint $table) {
            foreach (['additional_id', 'city_id', 'send_at', 'message_subject'] as $item) {
                if (Schema::hasColumn('ec_order_product', $item))
                $table->dropColumn($item);
            }
            if (!Schema::hasColumn('ec_order_product', 'additional_ids'))
            $table->string('additional_ids')->after('product_id')->nullable();
            if (!Schema::hasColumn('ec_order_product', 'shipping_rule_id'))
            $table->bigInteger('shipping_rule_id')->after('additional_id')->nullable();
            if (!Schema::hasColumn('ec_order_product', 'message_id'))
            $table->string('message_id')->after('shipping_rule_id')->nullable();
            if (!Schema::hasColumn('ec_order_product', 'shipping_date'))
            $table->date('shipping_date')->after('message_id')->nullable();
            if (!Schema::hasColumn('ec_order_product', 'shipping_time'))
            $table->string('shipping_time')->after('shipping_date')->nullable();
            if (!Schema::hasColumn('ec_order_product', 'message_sender'))
            $table->string('message_sender')->after('shipping_date')->nullable();
            if (!Schema::hasColumn('ec_order_product', 'message_text'))
            $table->text('message_text')->after('message_sender')->nullable();
            if (!Schema::hasColumn('ec_order_product', 'additional_price'))
            $table->decimal('additional_price', 15)->after('price')->nullable();
            if (!Schema::hasColumn('ec_order_product', 'shipping_price'))
            $table->decimal('shipping_price', 15)->after('additional_price')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('ec_order_product', function (Blueprint $table) {
            $table->dropColumn('additional_ids');
            $table->dropColumn('message_id');
            $table->dropColumn('shipping_rule_id');
            $table->dropColumn('shipping_date');
            $table->dropColumn('shipping_time');
            $table->dropColumn('message_sender');
            $table->dropColumn('message_text');
            $table->dropColumn('shipping_price');
        });
    }
};
