<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->string('title');
            $table->string('reference')->unique();
            $table->longText('content')->nullable();
            $table->json('metadata')->nullable();
            $table->date('issued_at');
            $table->timestamps();

            $table->index(['tenant_id', 'member_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_documents');
    }
};
