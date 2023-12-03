<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumns('ec_order_product', ['additional_id', 'city_id', 'send_at', 'message_subject', 'message_text'])) {
            Schema::table('ec_order_product', function (Blueprint $table) {
                $table->string('additional_id')->after('send_at')->nullable();
                $table->string('message_id')->after('message_id')->nullable();
                $table->bigInteger('city_id')->after('product_id')->nullable();
                $table->timestamp('send_at')->after('city_id')->nullable();
                $table->string('message_subject')->after('send_at')->nullable();
                $table->text('message_text')->after('message_subject')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::table('ec_order_product', function (Blueprint $table) {
            $table->dropColumn('additional_id');
            $table->dropColumn('message_id');
            $table->dropColumn('city_id');
            $table->dropColumn('send_at');
            $table->dropColumn('message_subject');
            $table->dropColumn('message_text');
        });
    }
};
