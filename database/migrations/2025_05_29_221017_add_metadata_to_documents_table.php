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
        Schema::table('documents', function (Blueprint $table) {
            $table->string('reference')->nullable()->after('id');
            $table->string('title_analysis')->nullable()->after('title');
            $table->text('content_presentation')->nullable()->after('description');
            $table->string('material_importance')->nullable()->after('material_condition');
            $table->string('administrative_action')->nullable();
            $table->string('theme')->nullable();
            $table->string('document_typology')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn([
                'reference',
                'title_analysis',
                'content_presentation',
                'material_importance',
                'administrative_action',
                'theme',
                'document_typology'
            ]);
        });
    }
};
