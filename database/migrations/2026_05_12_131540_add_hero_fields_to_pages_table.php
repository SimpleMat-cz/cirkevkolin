<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('hero_eyebrow')->nullable()->after('slug');
            $table->string('hero_title')->nullable()->after('hero_eyebrow');
            $table->string('hero_title_accent')->nullable()->after('hero_title');
            $table->string('hero_accent_color')->nullable()->default('coral')->after('hero_title_accent');
            $table->text('hero_description')->nullable()->after('hero_accent_color');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
                'hero_eyebrow',
                'hero_title',
                'hero_title_accent',
                'hero_accent_color',
                'hero_description',
            ]);
        });
    }
};
