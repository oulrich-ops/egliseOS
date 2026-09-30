<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->string('card_number')->unique();
            $table->string('verification_token')->unique();
            $table->string('pdf_path')->nullable();
            $table->string('status')->default('active');
            $table->date('expires_at')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'member_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_cards');
    }
};
