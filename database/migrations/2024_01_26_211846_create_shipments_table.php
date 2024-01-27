<?php

use App\Enums\ShipmentEquipmentTypesEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->string('status')->nullable();
            $table->unsignedMediumInteger('weight');
            $table->smallInteger('temperature')->nullable();
            $table->enum('equipment_type', ShipmentEquipmentTypesEnum::values());
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
