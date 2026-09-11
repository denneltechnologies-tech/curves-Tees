<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('tag')->nullable(); // e.g. "NEW ARRIVALS", "ACCRA LUXURY"
            $table->string('media_type')->default('image'); // 'image', 'video'
            $table->text('image_path')->nullable();
            $table->text('video_url')->nullable();
            $table->string('button_text')->default('Explore Collection');
            $table->string('button_link')->default('#catalog');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('hero_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_settings');
        Schema::dropIfExists('hero_slides');
    }
};
