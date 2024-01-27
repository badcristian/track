<?php

use App\Enums\StopStatusesEnum;
use App\Enums\StopTypesEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stops', function (Blueprint $table) {
            $table->id();
            $table->enum('type', StopTypesEnum::values());
            $table->string('name');
            $table->enum('status', StopStatusesEnum::values())->nullable();
            $table->timestamp('eta')->nullable();
            $table->timestamp('datetime')->nullable();
            $table->timestamp('arrival_datetime')->nullable();
            $table->timestamp('departure_datetime')->nullable();
            $table->boolean('fcfs');
            $table->timestamp('working_hours_start')->nullable();
            $table->timestamp('working_hours_end')->nullable();
            $table->string('ref_numbers')->nullable();
            $table->string('street_address');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('notes')->nullable();
            $table->string('country')->default('zanzibar');
            $table->decimal('lat', 6, 4);
            $table->decimal('lng', 7, 4);
            $table->foreignId('shipment_id')->constrained('shipments')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stops');
    }
};
