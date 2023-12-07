<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ec_message_cards', function (Blueprint $table) {
            $table->id();
            $table->string('title', 120);
            $table->text('description');
            $table->longText('content');
            $table->integer('order')->unsigned()->default(0);
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::create('ec_message_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->foreignId('parent_id')->default(0);
            $table->mediumText('description')->nullable();
            $table->string('status', 60)->default('published');
            $table->integer('order')->unsigned()->default(0);
            $table->string('image', 255)->nullable();
            $table->string('icon', 255)->nullable();
            $table->string('icon_image', 255)->nullable();
            $table->tinyInteger('is_featured')->unsigned()->default(0);
            $table->timestamps();
        });

        Schema::create('ec_message_card_category', function (Blueprint $table) {
            $table->foreignId('category_id')->index();
            $table->foreignId('message_id')->index();
            $table->primary(['message_id', 'category_id'], 'message_categories_message_primary_key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ec_message_cards');
        Schema::dropIfExists('ec_message_categories');
    }
};
