<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void 
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('services')->restrictOnDelete();
            $table->date('event_date');
            $table->time('event_time');
            $table->string('event_location');
            $table->string('event_type');
            $table->text('notes')->nullable();
            $table->enum('status', ['Menunggu', 'Dikonfirmasi', 'Selesai', 'Dibatalkan'])->default('Menunggu');
            $table->enum('payment_status', ['Belum Dibayar', 'Dibayar'])->default('Belum Dibayar');
            $table->unsignedInteger('total_price');
            $table->timestamps();
        });
    }

    public function down(): void 
    {
        Schema::dropIfExists('bookings');
    }
};