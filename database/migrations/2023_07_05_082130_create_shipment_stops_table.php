<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('shipment_stops', function (Blueprint $table) {
            $table->id();
            $table->timestamp('pickup_time');
            $table->timestamp('delivery_time');
            $table->string('reference_numbers');
            $table->string('status');    //TODO
            $table->decimal('latitude',5,3)->nullable(); //TODO
            $table->decimal('longitude',6,3)->nullable(); //TODO
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipment_stops');
    }
};
