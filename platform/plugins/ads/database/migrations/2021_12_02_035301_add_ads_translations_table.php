<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('ads_translations')) {
            Schema::create('ads_translations', function (Blueprint $table) {
                $table->string('lang_code', 20);
                $table->foreignId('ads_id');
                $table->string('name', 255)->nullable();
                $table->string('image', 255)->nullable();
                $table->string('url', 255)->nullable();

                $table->primary(['lang_code', 'ads_id'], 'ads_translations_primary');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ads_translations');
    }
};
