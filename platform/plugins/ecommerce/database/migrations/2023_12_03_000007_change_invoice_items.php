<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('ec_invoice_items', function (Blueprint $table) {
            foreach (['additional_id', 'city_id', 'send_at', 'message_subject'] as $item) {
                if (Schema::hasColumn('ec_invoice_items', $item))
                    $table->dropColumn($item);
            }
            if (!Schema::hasColumn('ec_invoice_items', 'additional_ids'))
                $table->string('additional_ids')->after('reference_id')->nullable();
            if (!Schema::hasColumn('ec_invoice_items', 'shipping_rule_id'))
                $table->bigInteger('shipping_rule_id')->after('additional_id')->nullable();
            if (!Schema::hasColumn('ec_invoice_items', 'message_id'))
                $table->string('message_id')->after('shipping_rule_id')->nullable();
            if (!Schema::hasColumn('ec_invoice_items', 'shipping_date'))
                $table->date('shipping_date')->after('message_id')->nullable();
            if (!Schema::hasColumn('ec_invoice_items', 'shipping_time'))
                $table->string('shipping_time')->after('shipping_date')->nullable();
            if (!Schema::hasColumn('ec_invoice_items', 'message_sender'))
                $table->string('message_sender')->after('shipping_date')->nullable();
            if (!Schema::hasColumn('ec_invoice_items', 'message_text'))
                $table->text('message_text')->after('message_sender')->nullable();
            if (!Schema::hasColumn('ec_invoice_items', 'additional_price'))
                $table->decimal('additional_price', 15)->after('price')->nullable();
            if (!Schema::hasColumn('ec_invoice_items', 'shipping_price'))
                $table->decimal('shipping_price', 15)->after('additional_price')->nullable();
            if (!Schema::hasColumn('ec_invoice_items', 'recipient_name'))
            $table->text('recipient_name')->after('message_text')->nullable();
            if (!Schema::hasColumn('ec_invoice_items', 'recipient_phone'))
            $table->text('recipient_phone')->after('recipient_name')->nullable();
            if (!Schema::hasColumn('ec_invoice_items', 'recipient_address'))
            $table->text('recipient_address')->after('recipient_phone')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('ec_invoice_items', function (Blueprint $table) {
            $table->dropColumn('additional_ids');
            $table->dropColumn('message_id');
            $table->dropColumn('shipping_rule_id');
            $table->dropColumn('shipping_date');
            $table->dropColumn('shipping_time');
            $table->dropColumn('message_sender');
            $table->dropColumn('message_text');
            $table->dropColumn('shipping_price');
            $table->dropColumn('recipient_name');
            $table->dropColumn('recipient_phone');
            $table->dropColumn('recipient_address');
        });
    }
};
