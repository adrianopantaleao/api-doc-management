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
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->boolean('active')->default(true);
        });

        Schema::create('columns', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->boolean('active')->default(true);

            $table->foreignId('type_id')->constrained();
        });

        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->boolean('active')->default(true);

            $table->foreignId('type_id')->constrained();
        });

        Schema::create('column_document', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('content');

            $table->foreignId('column_id')->constrained();
            $table->foreignId('document_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('column_document');
        Schema::dropIfExists('columns');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('types');
    }
};
